<?php

namespace App\Http\Controllers;

use App\Bejc;
use App\BejcItem;
use App\Echelon;
use App\Engagement;
use App\Http\Resources\Bejc as BejcResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\Functions;
use PDF;

class BejcController extends Controller
{
    public function home()
    {
        return view('admin.bordereau.bejcs.index', [
            'page' => 'bordereau',
            'sub_page' => 'bejc'
        ]);
    }

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
        // if (!Gate::allows('isAdmin')) {
        //     abort(403, 'Désolé, vous ne pouvez pas executer cette action');
        // }

        $bejcs = Bejc::where('id', 'like', '%' . $keyword . '%')
            ->orderBy('created_at', 'desc')->paginate($limit);

        return BejcResource::collection($bejcs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bordereau.bejcs.create', [
            'page' => 'bordereau',
            'sub_page' => 'bejc.create'
        ]);
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
            'chapitre' => ['required'],
            'nature' => ['required'],
            'amount' => ['required']
        ]);


        //On cree d'abord le bordereau
        $bordereau = Bejc::forceCreate([
            'chapitre_id' => intval($data['chapitre']),
            'nature' => $data['nature'],
            'm_ordonnance' => $data['amount'],
            'user_id' => $currentUser->id,
        ]);

        $items = $request->items;
        $echelons = [];

        //puis on cree les items du bordereau
        //puis on cree les echelons de cet engagement
        foreach ($items as $item){
            // $itemBejc = BejcItem::forceCreate([
            //     'engagement_id' => $item['id'],
            //     'bejc_id' => $bordereau->id,
            //     'n_ordonnance' => $item['num_ordonnance'],
            //     'm_ordonnance' => $item['montant_ordonnance']
            // ]);


            //On selectionne d'abord l'engagement qui correspond a ce numero d'engagement
            $engagement = Engagement::find($item['id']);

            $echelon = Echelon::forceCreate([
                'n_ordonnance' => $item['num_ordonnance'],
                'n_engage' => $engagement->n_engage,
                'm_paye' => $item['montant_ordonnance'],
                'date_depot_ac' => Functions::stringToDate($item['date_depot_ac']),
                'comment' => $item['comment'],
                'user_id' => $currentUser->id,
                'engagement_id' => $engagement->id
            ]);

            $bordereau->echelons()->attach($echelon->id);

            array_push($echelons, $echelon);
        }

        return [
            'bejc' => new BejcResource($bordereau),
            'echelons' => $echelons
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bejc  $bejc
     * @return \Illuminate\Http\Response
     */
    public function show(Bejc $bejc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bejc  $bejc
     * @return \Illuminate\Http\Response
     */
    public function edit(Bejc $bejc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bejc  $bejc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bejc $bejc)
    {
        //
    }

    public function pdf($bordereau, Request $request)
    {
        $bordereau = Bejc::findOrFail($bordereau);

        $pdf = PDF::loadView('admin.bordereau.bejcs.pdf', [
            'page' => 'bordereau',
            'sub_page' => 'bejc',
            'bordereau' => $bordereau
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('fichier.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bejc  $bejc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bejc $bejc)
    {
        //
    }
}
