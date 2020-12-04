<?php

namespace App\Http\Controllers;

use App\Models\SecteurActivite;
use App\Http\Resources\SecteurActivite as SecteurActiviteResource;
use Illuminate\Http\Request;

class SecteurActiviteController extends Controller
{
    public function home()
    {

        return view('admin.recouvrement.configuration.secteur_activite.index', [
            'page' => 'parametre',
            'sub_page' => 'secteur-activite.list'
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

        $secteurs = SecteurActivite::where('name', 'like', '%' . $keyword . '%')
            ->orderBy('name', 'asc')->paginate($limit);

        return SecteurActiviteResource::collection($secteurs);
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
            'name' => ['required'],
            'description' => [''],
        ]);

        $secteur = SecteurActivite::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        return new SecteurActiviteResource($secteur);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SecteurActivite  $secteurActivite
     * @return \Illuminate\Http\Response
     */
    public function show(SecteurActivite $secteurActivite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SecteurActivite  $secteurActivite
     * @return \Illuminate\Http\Response
     */
    public function edit(SecteurActivite $secteurActivite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SecteurActivite  $secteurActivite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SecteurActivite $secteurActivite)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => [''],
        ]);

        $secteur = SecteurActivite::find($request->id);

        $secteur->name = $data['name'];
        $secteur->description = $data['description'];
        $secteur->touch();
        $secteur->save();

        return new SecteurActiviteResource($secteur);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SecteurActivite  $secteurActivite
     * @return \Illuminate\Http\Response
     */
    public function destroy(SecteurActivite $secteur)
    {
        if($secteur->delete()){
            return response()->json(['message', 'Secteur supprimé', 200]);
        }
    }
}
