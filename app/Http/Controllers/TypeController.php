<?php

namespace App\Http\Controllers;

use App\Http\Resources\Type as TypeResource;
use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function home()
    {
        return view('admin.types.index', [
            'page' => 'parametre',
            'sub_page' => 'type.list'
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

        $types = Type::where('libelle', 'like', '%' . $keyword . '%')
            ->orderBy('libelle', 'asc')->paginate($limit);

        return TypeResource::collection($types);
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
            'code' => ['required'],
            'description' => [],
        ]);

        $type = Type::forceCreate([
            'libelle' => $data['libelle'],
            'code' => $data['code'],
            'description' => $data['description']
        ]);

        return new TypeResource($type);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {

        $data = $request->validate([
            'id' => ['required'],
            'libelle' => ['required'],
            'code' => ['required'],
            'description' => [],
        ]);

        $type = Type::find($request->id);

        $type->libelle = $data['libelle'];
        $type->code = $data['code'];
        $type->description = $data['description'];
        $type->updated_at = new \DateTime();

        $type->save();


        return new TypeResource($type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy($type)
    {
        $type = Type::find($type);

        if($type->delete()){
            return new TypeResource($type);
        }
    }
}
