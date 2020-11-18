<?php

namespace App\Http\Controllers;

use App\Echelon;
use App\Engagement;
use App\Document;
use App\Historique;
use App\Http\Resources\Echelon as EchelonResource;
use App\Providers\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EchelonController extends Controller
{
    public function home()
    {
        return view('admin.echelons.index', [
            'page' => 'echelon',
            'sub_page' => 'echelon.list'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requete = Echelon::whereBetween('created_at', [$request->exercice.'-01-01 00:00:00', $request->exercice.'-12-31 23:59:59'])
            ->where(function ($query) use ($request){
                $query
                    ->whereHas('engagement', function ($query) use ($request){
                        $query->where('l_nmtir', 'like', '%' . $request->keyword . '%')
                            ->orWhere('n_devis', 'like', '%' . $request->keyword . '%');
                    })
                    ->orWhere('n_engage', 'LIKE', '%' . $request->keyword . '%');
            });

        if($request->etat !== null){
            $requete
                ->where('etat', '=', $request->etat);
        }

        $echelons = $requete
            ->orderBy('id', 'desc')
            ->paginate(15);

        return EchelonResource::collection($echelons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentUser = Auth::user();

        $data = $request->validate([
            'n_ordonnance' => ['required'],
            'n_engage' => ['required'],
            'm_paye' => ['required'],
            'date_paiement' => [''],
            'date_depot_ac' => [''],
            'comment' => ['']
        ]);

        //On selectionne d'abord l'engagement qui correspond a ce numero d'engagement
        $engagement = Engagement::where('n_engage', '=', $data['n_engage'])
            ->orderBy('id', 'DESC')
            ->first();

        $echelon = Echelon::forceCreate([
            'n_ordonnance' => $data['n_ordonnance'],
            'n_engage' => $data['n_engage'],
            'm_paye' => $data['m_paye'],
            'date_paiement' => Functions::stringToDate($data['date_paiement']),
            'date_depot_ac' => Functions::stringToDate($data['date_depot_ac']),
            'comment' => $data['comment'],
            'user_id' => $currentUser->id,
            'engagement_id' => $engagement->id
        ]);

        $engagement->date_paiement = $echelon->date_paiement;
        $engagement->date_depot_ac = $echelon->date_depot_ac;
        $engagement->save();

        if($engagement->is_paid == true){
            $echelon->etat = 'validated';
            $echelon->save();
        }

        return new EchelonResource($echelon);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Echelon  $echelon
     * @return \Illuminate\Http\Response
     */
    public function show(Echelon $echelon)
    {
        //
    }

    public function selectByEngagementNumber(Request $request)
    {
        $echelons = Echelon::where('n_engage', '=', $request->n_engage)
            ->orderBy('id', 'DESC')
            ->get();

        return EchelonResource::collection($echelons);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Echelon  $echelon
     * @return \Illuminate\Http\Response
     */
    public function edit(Echelon $echelon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Echelon  $echelon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Echelon $echelon)
    {
        //
    }

    public function uploadFiles(Request $request){

        $echelon = Echelon::find($request->echelon);

        $files = $request->documents;

        foreach ($files as $key => $file) {
            // $fileName = time().'.'.$file->extension();
            $fileName = $file->getClientOriginalName();
            $newFile = Document::forceCreate([
                'filename' => $fileName,
            ]);
            $echelon->documents()->attach($newFile->id);
            $file->move(public_path('uploads/documents'), $fileName);
        }

        return new EchelonResource($echelon);


        // $fileName = $exercice.'-'.time().'.'.$request->file->extension();

        // $request->file->move(public_path('uploads/excel-files'), $fileName);

    }

    public function validerPaiement(Request $request){
        $echelon = Echelon::find($request->id);

        $echelon->etat = 'validated';
        $echelon->date_paiement = Functions::stringToDate($request->date_paiement);
        $echelon->save();

        //On actualise le montant l'engagement
        $echelon->engagement->m_paye += $echelon->m_paye;
        //On modifie la date de paiement pour appliquer à la derniere date de paiement
        $echelon->engagement->date_paiement = $echelon->date_paiement;
        $echelon->engagement->date_depot_ac = $echelon->date_depot_ac;
//        $engagement->date_depot_ac = Functions::stringToDate($data['date_depot_ac']);
        $echelon->engagement->save();


        //On cree l'evenement
        $currentUser = Auth::user();
        $options['echelon_id'] = $echelon->id;
        $options['user'] = $currentUser->name." ".$currentUser->firstname;
        $options['action'] = 'Valider paiement';
        $options['engagement'] = $echelon->engagement->n_engage;
        $options['montant'] = $echelon->m_paye;

        $event = Historique::forceCreate([
            'body' => $options,
        ]);

        return new EchelonResource($echelon);

    }

    public function annulerPaiement(Request $request){
        $echelon = Echelon::find($request->id);

        $echelon->etat = 'cancelled';
        $echelon->save();

        //On cree l'evenement
        $currentUser = Auth::user();
        $options['echelon_id'] = $echelon->id;
        $options['user'] = $currentUser->name." ".$currentUser->firstname;
        $options['action'] = 'Valider paiement';
        $options['engagement'] = $echelon->engagement->n_engage;
        $options['montant'] = $echelon->m_paye;

        $event = Historique::forceCreate([
            'body' => $options,
        ]);

        return new EchelonResource($echelon);

    }


    public function showAttacheFile($document)
    {
        $file = public_path()."/uploads/documents/".$document;
        // // Quick check to verify that the file exists
        if( !file_exists($file) ) die("File not found");
        // // Force the download
        header("Content-Disposition: attachment; filename=" . basename($file));
        header("Content-Length: " . filesize($file));
        header("Content-Type: application/octet-stream;");
        readfile($file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Echelon  $echelon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Echelon $echelon)
    {
        //
    }
}
