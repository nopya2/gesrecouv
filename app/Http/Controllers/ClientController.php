<?php

namespace App\Http\Controllers;

use App\Client;
use App\Facture;
use App\Http\Requests\ClientRequest;
use App\Http\Resources\Client as ClientResource;
use App\Http\Resources\Facture as FactureResource;
use App\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ClientController extends Controller
{

    public function home()
    {
        return view('admin.recouvrement.clients.index', [
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
        return view('admin.recouvrement.clients.create', [
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
    public function store(ClientRequest $request)
    {

        $client = Client::forceCreate([
            'raison_sociale' => $request->raison_sociale,
            'nif' => $request->nif,
            'bp' => $request->b,
            'adresse' => $request->adresse,
            'ville' => $request->ville,
            'pays' => $request->pays,
            'tel' => $request->tel,
            'responsable' => $request->responsable,
            'tel_responsable' => $request->tel_responsable,
            'email' => $request->email,
            'secteur_id' => $request->secteur_id,
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
        $previous = 0;
        $previousClient = Client::where('id', '<', $client->id)->get()->last();
        if($previousClient) $previous = $previousClient->id;
        
        $next = 0;
        $nextClient = Client::where('id', '>', $client->id)->get()->first();
        if($nextClient) $next = $nextClient->id;

        $clients = Client::all();

        $index = null;
        foreach($clients as $key => $value){
            if($value->id === $client->id) $index = $key + 1;
        }

        //Prochaine échéance
        $nextEcheance = Facture::where('client_id', $client->id)
            ->where('deleted', false)
            ->where('statut', '!=', 'paid')
            ->where('statut', '!=', 'cancelled')
            ->where('statut', '!=', 'credit_note')
            ->where('date_echeance', '>', now())
            ->orderBy('date_echeance', 'asc')
            ->get()->first();
        if($nextEcheance) $nbDaysNextEcheance = (date_diff(now(), $nextEcheance->date_echeance))->days;
        else $nbDaysNextEcheance = 0;

        //Dernier paiement
        $lastPaiement = Paiement::whereHas('facture', function(Builder $query) use ($client){
                $query
                    ->where('client_id', $client->id)
                    ->where('deleted', false)
                    ->where('statut', '!=', 'paid')
                    ->where('statut', '!=', 'cancelled')
                    ->where('statut', '!=', 'credit_note');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->first();

        if($lastPaiement) $nbDaysLastPaiement = (date_diff(now(), $lastPaiement->created_at))->days;
        else $nbDaysLastPaiement = 0;

        //Dernière facture en retard
        $firstLateFacture = Facture::where('client_id', $client->id)
            ->where('deleted', false)
            ->where('statut', '!=', 'paid')
            ->where('statut', '!=', 'cancelled')
            ->where('statut', '!=', 'credit_note')
            ->where('date_echeance', '<', now())
            ->orderBy('date_echeance', 'asc')
            ->get()->first();

        if($firstLateFacture) $nbDaysFirstLateFacture = (date_diff(now(), $firstLateFacture->date_echeance))->days;
        else $nbDaysFirstLateFacture = 0;

        return view('admin.recouvrement.clients.show', [
            'page' => 'client',
            'sub_page' => 'client.show',
            'client' => $client,
            'previous' => $previous,
            'next' => $next,
            'total' => $client->count(),
            'current' => $index,
            'nb_days_next_echeance' => $nbDaysNextEcheance,
            'nb_days_last_paiement' => $nbDaysLastPaiement,
            'nb_days_first_late_facture' => $nbDaysFirstLateFacture
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

        return view('admin.recouvrement.clients.edit', [
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
    public function update(ClientRequest $request, Client $client)
    {

        $client = Client::find($request->id);

        $client->raison_sociale = $request->raison_sociale;
        $client->nif = $request->nif;
        $client->bp = $request->bp;
        $client->adresse = $request->adresse;
        $client->ville = $request->ville;
        $client->pays = $request->pays;
        $client->tel = $request->tel;
        $client->responsable = $request->responsable;
        $client->tel_responsable = $request->tel_responsable;
        $client->email = $request->email;
        $client->updated_at = new \DateTime();

        $client->save();

        return new ClientResource($client);
    }
    
    /**
     * La liste des factures pour un client
     * 
     */
    public function getFacturesByClient(Request $request, Client $client){
        $factures = Facture::whereDeleted(false)
                    ->where('statut', '!=', 'cancelled')
                    ->where('client_id', $client->id)
                    ->orderBy('id', 'desc')
                    ->paginate(10);

        return FactureResource::collection($factures);
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
