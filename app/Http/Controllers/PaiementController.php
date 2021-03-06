<?php

namespace App\Http\Controllers;

use App\Paiement;
use App\Document;
use App\Http\Resources\Paiement as PaiementResource;
use App\Http\Resources\Facture as FactureResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\Functions;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = 100;
        if($request->has('limit'))
            $limit = $request->limit;
        $keyword = '';
        if($request->has('keyword'))
            $keyword = $request->keyword;

        $paiements = Paiement::all();

        return Paiement::collection($paiements);
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

        $data = $request->validate([
            'mode_paiement' => ['required'],
            'date_paiement' => ['required'],
            'commentaire' => [],
            'facture_id' => ['required'],
            'montant' => ['required'],
        ]);

        $paiement = Paiement::forceCreate([
            'mode_paiement' => $data['mode_paiement'],
            'date_paiement' => $data['date_paiement'],
            'commentaire' => $data['commentaire'],
            'facture_id' => $data['facture_id'],
            'montant' => $data['montant'],
            'user_id' => Auth::user()->id,
            'num_paiement' => Functions::generateNumPaiment()
        ]);

        if($request->has('documents')){
            $files = $request->documents;

            foreach ($files as $key => $file) {
                // $fileName = time().'.'.$file->extension();
                $fileName = $file->getClientOriginalName();
                $newFile = Document::forceCreate([
                    'filename' => $fileName,
                ]);
                $paiement->documents()->attach($newFile->id);
                $file->move(public_path('uploads/documents'), $fileName);
            }
        }

        $user = Auth::user();
        activity()
            ->performedOn($paiement->facture)
            ->causedBy(Auth::user())
            ->withProperties(['facture' => $paiement->facture, 'user' => $user, 'paiement' => $paiement])
            ->log("<b>".strtoupper($user->fullName)."</b>"." a ajouté un paiement n°{$paiement->num_paiement} à la facture n°{$paiement->facture->num_facture}");


        return ['paiement' => new PaiementResource($paiement), 'facture' => new FactureResource($paiement->facture)];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function show(Paiement $paiement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function edit(Paiement $paiement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paiement $paiement)
    {
                
    }

    public function updateState(Request $request, Paiement $paiement){
        if(!$request->has('action'))
            return response()->json(['message'=>'Erreur serveur interne'], 500);
        
        
        if($request->action =='validate')
            $paiement->state = 'validated';
        if($request->action =='cancel')
            $paiement->state = 'cancelled';

        $paiement->updated_at = now();
        $paiement->save();

        $user = Auth::user();
        activity()
            ->performedOn($paiement->facture)
            ->causedBy(Auth::user())
            ->withProperties(['facture' => $paiement->facture, 'user' => $user, 'paiement' => $paiement])
            ->log("<b>".strtoupper($user->fullName)."</b>"." a validé le paiement n°{$paiement->num_paiement} de la facture n°{$paiement->facture->num_facture}");

        return new PaiementResource($paiement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paiement $paiement)
    {
        //
    }
}
