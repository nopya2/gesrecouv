<?php

namespace App\Http\Controllers;

use App\Module;
use App\Permission;
use App\Http\Resources\Module as ModuleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    public function home()
    {

        return view('admin.modules.index', [
            'page' => 'module',
            'sub_page' => 'module.list'
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

        $modules = Module::where('name', 'like', '%' . $keyword . '%')
            ->orderBy('name', 'asc')->paginate($limit);

        return ModuleResource::collection($modules);
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
            'description' => ['required'],
            'slug' => ['required'],
        ]);

        $module = Module::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'slug' => Str::slug($data['slug'], '-')
        ]);

        return new ModuleResource($module);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'slug' => ['required'],
        ]);

        $module = Module::find($request->id);

        $module->name = $data['name'];
        $module->slug = $data['slug'];
        $module->description = $data['description'];
        $module->save();

        return new ModuleResource($module);
    }

    public function addPermission(Request $request, Module $module){
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $permission = Permission::create([
            'module_id' => $module->id,
            'name' => $data['name'],
            'description' => $data['description'],
            'slug' => Str::slug($data['name'], '-')
        ]);

        return new ModuleResource($module->fresh());
    }

    public function deletePermission(Request $request, Module $module){
        if(!$request->has('permission'))
            return response()->json(['message' => 'Cet élément n\'existe pas!'], 404);
        
        $permission = Permission::find(intval($request->permission));
        $permission->delete();

        return new ModuleResource($module->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {

        if($module->delete()){
            return response()->json(['message', 'Module supprimé', 200]);
        }
    }
}
