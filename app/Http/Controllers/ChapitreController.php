<?php

namespace App\Http\Controllers;

use App\Chapitre;
use App\Http\Resources\Chapitre as ChapitreResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChapitreController extends Controller
{
    public function home()
    {
        return view('admin.chapitres.index', [
            'page' => 'parametre',
            'sub_page' => 'chapitre'
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
        $nature = '';
        if($request->has('nature'))
            $nature = $request->nature;
        // if (!Gate::allows('isAdmin')) {
        //     abort(403, 'Désolé, vous ne pouvez pas executer cette action');
        // }

        $chapitres = Chapitre::where('l_chap', 'like', '%' . $keyword . '%')
            ->where('nature', 'like', '%' . $nature . '%')
            ->orderBy('n_chap', 'asc')->paginate($limit);

        return ChapitreResource::collection($chapitres);
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
            'n_chap' => ['required'],
            'l_chap' => ['required'],
            'nature' => ['required']
        ]);

        $chapitre = Chapitre::forceCreate([
            'n_chap' => $data['n_chap'],
            'l_chap' => $data['l_chap'],
            'nature' => $data['nature'],
        ]);

        return new ChapitreResource($chapitre);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chapitre  $chapitre
     * @return \Illuminate\Http\Response
     */
    public function show(Chapitre $chapitre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chapitre  $chapitre
     * @return \Illuminate\Http\Response
     */
    public function edit(Chapitre $chapitre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chapitre  $chapitre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $data = $request->validate([
            'id' => ['required'],
            'n_chap' => ['required'],
            'l_chap' => ['required'],
            'nature' => ['required'],
        ]);

        $chapitre = Chapitre::find($request->id);

        $chapitre->n_chap = $data['n_chap'];
        $chapitre->l_chap = $data['l_chap'];
        $chapitre->nature = $data['nature'];
        $chapitre->updated_at = new \DateTime();

        $chapitre->save();


        return new ChapitreResource($chapitre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chapitre  $chapitre
     * @return \Illuminate\Http\Response
     */
    public function destroy($chapitre)
    {
        $chapitre = Chapitre::find($chapitre);

        if($chapitre->delete()){
            return new ChapitreResource($chapitre);
        }
    }
}
