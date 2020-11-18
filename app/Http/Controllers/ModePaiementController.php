<?php

namespace App\Http\Controllers;

use App\ModePaiement;
use App\Http\Resources\ModePaiement as ModePaiementResource;
use Illuminate\Http\Request;

class ModePaiementController extends Controller
{
    public function home()
    {
        return view('admin.modes_paiement.index', [
            'page' => 'parametre',
            'sub_page' => 'mode_paiement.list'
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

        $modesPaiement = ModePaiement::where('libelle', 'like', '%' . $keyword . '%')
            ->orderBy('libelle', 'asc')->paginate($limit);

        return ModePaiementResource::collection($modesPaiement);
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
            'libelle' => ['required'],
            'description' => [],
        ]);

        $modePaiement = ModePaiement::forceCreate([
            'libelle' => $data['libelle'],
            'description' => $data['description']
        ]);

        return new ModePaiementResource($modePaiement);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModePaiement  $modePaiement
     * @return \Illuminate\Http\Response
     */
    public function show(ModePaiement $modePaiement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModePaiement  $modePaiement
     * @return \Illuminate\Http\Response
     */
    public function edit(ModePaiement $modePaiement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ModePaiement  $modePaiement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModePaiement $modePaiement)
    {
        $data = $request->validate([
            'id' => ['required'],
            'libelle' => ['required'],
            'description' => [],
        ]);

        $modePaiement = ModePaiement::find($request->id);

        $modePaiement->libelle = $data['libelle'];
        $modePaiement->description = $data['description'];
        $modePaiement->updated_at = new \DateTime();

        $modePaiement->save();


        return new ModePaiementResource($modePaiement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ModePaiement  $modePaiement
     * @return \Illuminate\Http\Response
     */
    public function destroy($modePaiement)
    {
        $modePaiement = ModePaiement::find($modePaiement);

        if($modePaiement->delete()){
            return new ModePaiementResource($modePaiement);
        }
    }
}
