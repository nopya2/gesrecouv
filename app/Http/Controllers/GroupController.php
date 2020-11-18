<?php

namespace App\Http\Controllers;

use App\Group;
use App\Permission;
use App\Http\Resources\Group as GroupResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class GroupController extends Controller
{
    public function home()
    {
        // if (!Gate::allows('isAdmin')) {
        //     abort(403, 'Désolé, vous ne pouvez pas executer cette action');
        // }

        return view('admin.groups.index', [
            'page' => 'user',
            'sub_page' => 'group.list'
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
            $keyword = $request->limit;
        $keyword = '';
        if($request->has('keyword'))
            $keyword = $request->keyword;
        // if (!Gate::allows('isAdmin')) {
        //     abort(403, 'Désolé, vous ne pouvez pas executer cette action');
        // }

        $groups = Group::where('name', 'like', '%' . $keyword . '%')
            ->orderBy('name', 'asc')->paginate($limit);

        return GroupResource::collection($groups);
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
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $group = Group::forceCreate([
            'name' => $data['name'],
            'description' => $data['description'],
            'created_by' => $currentUser->id,
            'updated_by' => $currentUser->id,
        ]);

        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function ajaxShow(Group $group)
    {
        return new GroupResource($group);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $currentUser = Auth::user();

        $data = $request->validate([
            'id' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $group = Group::find($request->id);

        $group->name = $data['name'];
        $group->description = $data['description'];
        $group->updated_by = $currentUser->id;
        $group->updated_at = new \DateTime();

        $group->save();


        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function permissions(Group $group)
    {
        return view('admin.groups.permissions', [
            'page' => 'user',
            'sub_page' => 'group.list',
            'group' => $group
        ]);
    }

    public function changePermission($group, $permission, Request $request)
    {
        $group = Group::find($group);
        $permission = Permission::find($permission);

        if($request->has('action')){
            if($request->action === 'add'){
                //On verifie si la permission sélectionnée n'est pas 'consulter'
                //Si non, on cherche l'id de la permission du module dont le slug est 'consulter'
                //
                if($permission->slug !== 'consulter'){
                    $permissionToFind = Permission::where('name', 'consulter')
                        ->where('module_id', $permission->module_id)
                        ->first();

                    $group->permissions()->attach($permissionToFind->id);
                }
                //On vérifie si la
                $group->permissions()->attach($permission->id);
            }
            if($request->action === 'delete'){
                //Si la permission à returer est la permission 'consulter' on retire toutes les autres permissions
                if($permission->slug === 'consulter'){
                    $permissions = Permission::where('module_id', $permission->module_id)->get();
                    foreach ($permissions as $permission) {
                        $group->permissions()->detach($permission->id);
                    }
                }
                $group->permissions()->detach($permission->id);
            }
        }

        return new GroupResource($group);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($group)
    {
        $group = Group::find($group);

        if($group->delete()){
            return new GroupResource($group);
        }
    }
}
