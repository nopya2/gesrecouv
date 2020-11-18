<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Resources\Client as ClientResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    public function home()
    {
        return view('admin.clients.index', [
            'page' => 'client',
            'sub_page' => 'client.list'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = 10000000;
        if($request->has('limit'))
            $limit = $request->limit;
        $keyword = '';
        if($request->has('keyword'))
            $keyword = $request->keyword;
        // if (!Gate::allows('isAdmin')) {
        //     abort(403, 'Désolé, vous ne pouvez pas executer cette action');
        // }

        $clients = Client::where(function ($query) use ($request){
            $query
                ->where('raison_sociale', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('nif', 'like', '%' . $request->keyword . '%');

            })
            ->orderBy('raison_sociale', 'asc')->paginate($limit);

        return ClientResource::collection($clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clients.create', [
            'page' => 'client',
            'sub_page' => 'client.create'
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
        $data = $request->validate([
            'raison_sociale' => ['required'],
            'nif' => ['required'],
            'bp' => [],
            'adresse' => ['required'],
            'ville' => ['required'],
            'pays' => ['required'],
            'tel' => [],
            'responsable' => ['required'],
            'tel_responsable' => ['required'],
            'email' => ['required']
        ]);

        $client = Client::forceCreate([
            'raison_sociale' => $data['raison_sociale'],
            'nif' => $data['nif'],
            'bp' => $data['bp'],
            'adresse' => $data['adresse'],
            'ville' => $data['ville'],
            'pays' => $data['pays'],
            'tel' => $data['tel'],
            'responsable' => $data['responsable'],
            'tel_responsable' => $data['tel_responsable'],
            'email' => $data['email'],
            'utilisateur_id' => Auth::user()->id
        ]);

        return new ClientResource($client);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('admin.clients.show', [
            'client' => $client,
            'page' => 'client',
            'sub_page' => 'client.show'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function showAjax(Client $client)
    {
        return new ClientResource($client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        // $user = User::findOrFail($user);

        return view('admin.clients.edit', [
            'client' => $client,
            'page' => 'client',
            'sub_page' => 'client.edit'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'raison_sociale' => ['required'],
            'nif' => ['required'],
            'bp' => [],
            'adresse' => ['required'],
            'ville' => ['required'],
            'pays' => ['required'],
            'tel' => [],
            'responsable' => ['required'],
            'tel_responsable' => ['required'],
            'email' => ['required']
        ]);

        $client = Client::find($request->id);

        $client->raison_sociale = $data['raison_sociale'];
        $client->nif = $data['nif'];
        $client->bp = $data['bp'];
        $client->adresse = $data['adresse'];
        $client->ville = $data['ville'];
        $client->pays = $data['pays'];
        $client->tel = $data['tel'];
        $client->responsable = $data['responsable'];
        $client->tel_responsable = $data['tel_responsable'];
        $client->email = $data['email'];
        $client->updated_at = new \DateTime();

        $client->save();

        return new ClientResource($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {

        if($client->delete()){
            return new ClientResource($client);
        }
    }
}
