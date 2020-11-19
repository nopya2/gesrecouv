<?php

namespace App\Http\Controllers;

use App\Facture;
use App\Http\Requests\FactureRequest;
use App\Http\Resources\Facture as FactureResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactureController extends Controller
{
    public function home()
    {
        return view('admin.factures.index', [
            'page' => 'facture',
            'sub_page' => 'facture.list'
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

        $queryBuilder = Facture::where(function ($query) use ($request){
            $query
                ->where('num_facture', 'LIKE', '%' . $request->keyword . '%')
                ->where('deleted', false);
                // ->orWhere('nif', 'like', '%' . $request->keyword . '%');

            });

        if($request->has('client_id') && $request->client_id != ''){
            $queryBuilder->where('client_id', $request->client_id);
        }

        if($request->has('type') && $request->type != ''){
            $queryBuilder->where('type_id', $request->type);
        }

        if($request->has('statut') && $request->statut != ''){
            if($request->statut == 'to_validate'){
                $queryBuilder->where('state', 'waiting');
            }
            if($request->statut == 'cancelled'){
                $queryBuilder->where('statut', 'cancelled');
            }
            if($request->statut == 'litigation'){
                $queryBuilder->where('statut', 'litigation');
            }
            if($request->statut == 'paid'){
                $queryBuilder->where('statut', 'paid');
            }
            if($request->statut == 'waiting'){
                $queryBuilder
                    ->where(function($query) use ($request){
                        $query
                            ->where('statut', '!=', 'paid')
                            ->where('date_echeance', '>', now());
                    });
            }
            if($request->statut == 'later'){
                $queryBuilder
                    ->where(function($query) use ($request){
                        $query
                            ->where('statut', '!=', 'paid')
                            ->where('date_echeance', '<', now());
                    });
            }
            if($request->has('start') && $request->has('end') && $request->start != "" && $request->end != ""){
                $queryBuilder
                    ->whereBeteween('date_creation', [$request->start, $request->end]);
            }
        }
        
        $factures = $queryBuilder
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return FactureResource::collection($factures);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.factures.create', [
            'page' => 'facture',
            'sub_page' => 'facture.create'
        ]);
    }


    public function store(FactureRequest $request)
    {

        $facture = Facture::create([
            'client_id' => $request->input('client_id'),
            'parent_id' => $request->input('parent_id'),
            'num_facture' => $request->input('num_facture'),
            'type_id' => $request->input('type_id'),
            'montant' => $request->input('montant'),
            'num_dossier' => $request->input('num_dossier'),
            'date_creation' => $request->input('date_creation'),
            'date_depot' => $request->input('date_depot'),
            'date_echeance' => $request->input('date_echeance'),
            'statut' => 'in_progress',
            'state' => 'waiting',
            'utilisateur_id' => Auth::user()->id
        ]);

        // return response()->json(["facture"=>new FactureResource($facture)],201);

        return new FactureResource($facture);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function show(Facture $facture)
    {
        return view('admin.factures.details', [
            'facture' => $facture,
            'page' => 'facture',
            'sub_page' => 'facture.show'
        ]);
    }

    public function getFacture(Facture $facture)
    {
        return new FactureResource($facture);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function edit(Facture $facture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function update(FactureRequest $request, Facture $facture)
    {
        Facture::whereId($facture->id)->update($request->toArray());
        $facture->touch();

        return new FactureResource($facture->fresh());
    }

    /**
     * Valide une facture.
     *
     * @param  \App\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function validateFacture(Facture $facture){

        $user = Auth::user();
        Facture::whereId($facture->id)->update(['state'=>"Validated","updated_at"=>now()]);

        activity()
            ->performedOn($facture->fresh())
            ->causedBy(Auth::user())
            // ->withProperties(['laravel' => 'awesome'])
            ->log("{$user->fullName} a validé la facture n°{$facture->num_facture} ");

        return new FactureResource($facture->fresh());
    }

    /**
     * Annule la facture.
     *
     * @param  \App\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function cancelFacture(Facture $facture){

        $user = Auth::user();
        Facture::whereId($facture->id)->update(['state'=>"cancelled", 'statut'=>'cancelled', "updated_at"=>now()]);

        activity()
            ->performedOn($facture->fresh())
            ->causedBy(Auth::user())
            // ->withProperties(['laravel' => 'awesome'])
            ->log("{$user->fullName} a annulé la facture n°{$facture->num_facture}");

        return new FactureResource($facture->fresh());
    }

    /**
     * Modifie le statut de la facture en litige.
     *
     * @param  \App\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function litigateFacture(Facture $facture){

        $user = Auth::user();
        Facture::whereId($facture->id)->update(['statut'=>'litigation', "updated_at"=>now()]);

        activity()
            ->performedOn($facture->fresh())
            ->causedBy(Auth::user())
            // ->withProperties(['laravel' => 'awesome'])
            ->log("{$user->fullName} a modifié le statut de la facture n°{$facture->num_facture} en litige");

        return new FactureResource($facture->fresh());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facture $facture)
    {
        $user = Auth::user();

        Facture::whereId($facture->id)->update(['deleted'=>true, "updated_at"=>now()]);
        activity()
            ->performedOn($facture->fresh())
            ->causedBy(Auth::user())
            ->log("{$user->fullName} a supprimé la facture n°{$facture->num_facture}");

        return response()->json(['message' => 'Facture supprimée'], 200);
    }
}
