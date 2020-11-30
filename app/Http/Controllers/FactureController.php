<?php

namespace App\Http\Controllers;

use App\Facture;
use App\Type;
use App\Document;
use App\Http\Requests\FactureRequest;
use App\Http\Resources\Facture as FactureResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\Functions;

class FactureController extends Controller
{
    public function home()
    {
        return view('admin.recouvrement.factures.index', [
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
        
        //Recherche par client
        if($request->has('client_id') && $request->client_id != ''){
            $queryBuilder->where('client_id', $request->client_id);
        }

        //Recherche par type
        if($request->has('type') && $request->type != ''){
            $queryBuilder->where('type_id', $request->type);
        }

        //Recherche par statut
        if($request->has('statut') && $request->statut != ''){
            //Les factures qui doivent etre validées
            if($request->statut == 'to_validate'){
                $queryBuilder->where('state', 'waiting');
            }
            //Les avoirs
            if($request->statut == 'credit_note'){
                $queryBuilder->where('statut', 'credit_note');
            }
            //Les factures annulées
            if($request->statut == 'cancelled'){
                $queryBuilder->where('statut', 'cancelled');
            }
            //Les factures en litige
            if($request->statut == 'litigation'){
                $queryBuilder->where('statut', 'litigation');
            }
            //Les factures payées
            if($request->statut == 'paid'){
                $queryBuilder->where('statut', 'paid');
            }
            //Les factures non payées
            if($request->statut == 'not_paid'){
                $queryBuilder->where('statut', '!=', 'paid')
                    ->where('statut', '!=', 'credit_note')
                    ->where('statut', '!=', 'cancelled');
            }
            //Les factures en attente de paiement
            if($request->statut == 'waiting'){
                $queryBuilder
                    ->where(function($query) use ($request){
                        $query
                            ->where('statut', '!=', 'paid')
                            ->where('statut', '!=', 'cancelled')
                            ->where('statut', '!=', 'credit_note')
                            ->where('date_echeance', '>=', now()->format('Y-m-d').' 00:00:00');
                    });
            }
            //Les factures en retard et non payées
            if($request->statut == 'later'){
                $queryBuilder
                    ->where(function($query) use ($request){
                        $query
                            ->where('statut', '!=', 'paid')
                            ->where('statut', '!=', 'cancelled')
                            ->where('statut', '!=', 'credit_note')
                            ->where('date_echeance', '<', now()->format('Y-m-d').' 00:00:00');
                    });
            }
        }

        //Sélection des factures par période
        if($request->has('start') && $request->has('end') && $request->start != "" && $request->end != ""){
            $queryBuilder
                ->whereBetween('date_creation', [$request->start, $request->end]);
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
        return view('admin.recouvrement.factures.create', [
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
        //Redicrection à la page d'erreur
        if($facture->deleted === true)
            return redirect('error?mod=recouvrement');

        return view('admin.recouvrement.factures.details', [
            'facture' => $facture,
            'page' => 'facture',
            'sub_page' => 'facture.show'
        ]);
    }

    public function getFacture(Facture $facture)
    {
        if($facture->deleted === true)
            return redirect('error?mod=recouvrement');

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
        //Redicrection à la page d'erreur
        if($facture->deleted === true)
            return redirect('error?mod=recouvrement');
        if($facture->state !== 'waiting' && $facture->statut !== 'in_progress' && $facture->m_paid!==0)
            return redirect('error?mod=recouvrement');

        return view('admin.recouvrement.factures.edit', [
            'facture' => $facture,
            'page' => 'facture',
            'sub_page' => 'facture.show'
        ]);
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
        Facture::whereId($facture->id)->update(['state'=>"validated","updated_at"=>now()]);

        activity()
            ->performedOn($facture->fresh())
            ->causedBy(Auth::user())
            // ->withProperties(['laravel' => 'awesome'])
            ->log("<b>".strtoupper($user->fullName)."</b>"." a validé la facture n°{$facture->num_facture} ");

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
            ->log("<b>".strtoupper($user->fullName)."</b>"." a annulé la facture n°{$facture->num_facture}");

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
            ->log("<b>".strtoupper($user->fullName)."</b>"." a modifié le statut de la facture n°{$facture->num_facture} en litige");

        return new FactureResource($facture->fresh());
    }

    /**
     * Transforme la facture en avoir.
     *
     * @param  \App\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function transformToCreditNote(Facture $facture){

        $user = Auth::user();
        //on annule la facture initiale
        Facture::whereId($facture->id)->update(['statut'=>'cancelled', 'state'=>'cancelled', "updated_at"=>now()]);

        activity()
            ->performedOn($facture->fresh())
            ->causedBy(Auth::user())
            // ->withProperties(['laravel' => 'awesome'])
            ->log("<b>".strtoupper($user->fullName)."</b>"." a annulé la facture n°{$facture->num_facture}");

        $typeFacture = Type::find($facture->type_id);
        
        
        $newFacture = Facture::create([
            'client_id' => $facture->client_id,
            'parent_id' => $facture->id,
            'num_facture' => Functions::generateNumFacture($typeFacture->code),
            'type_id' => $facture->type_id,
            'montant' => $facture->m_not_paid,
            'num_dossier' => $facture->num_dossier,
            'date_creation' => now(),
            'date_depot' => null,
            'date_echeance' => null,
            'statut' => 'credit_note',
            'state' => 'validated',
            'utilisateur_id' => Auth::user()->id
        ]);

        return new FactureResource($newFacture->fresh());
    }

    public function addDocument(Request $request, Facture $facture){
        $user = Auth::user();

        if($request->has('document')){
            $file = $request->document;
            $fileName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getClientSize();

            $newFile = Document::create([
                'filename' => $fileName,
                'extension' => $extension,
                'size' => $size
            ]);

            $facture->documents()->attach($newFile->id);
            $file->move(public_path('uploads/documents'), $fileName);

            activity()
            ->performedOn($facture->fresh())
            ->causedBy(Auth::user())
            // ->withProperties(['laravel' => 'awesome'])
            ->log("<b>".strtoupper($user->fullName)."</b>"." a ajouté un document à la facture n°{$facture->num_facture}");

        }
        return new FactureResource($facture->fresh());
    }

    public function removeDocument(Request $request, Facture $facture){
        $user = Auth::user();

        if(!$request->has('id'))
            return response()->json(['message' => 'Document non trouvé!'], 404);

        
        $document = Document::find($request->id);
        if(!$document)
            return response()->json(['message' => 'Document non trouvé!'], 404);
        
        $fileName = $document->filename;
        //On supprime le fichier de la facture
        $facture->documents()->detach($document->id);
        // //On supprime la facture de la base de données
        $document->delete();

        //On supprime le fichier sur le serveur
        if(file_exists(public_path('uploads/documents/'.$fileName))){
            unlink(public_path('uploads/documents/'.$fileName));
        }else{
            return response()->json(['message' => 'Ce fichier n\'existe pas!'], 404);
        }

        activity()
            ->performedOn($facture->fresh())
            ->causedBy(Auth::user())
            // ->withProperties(['laravel' => 'awesome'])
            ->log("<b>".strtoupper($user->fullName)."</b>"." a supprimé un document de la facture n°{$facture->num_facture}");

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
            ->log("<b>".strtoupper($user->fullName)."</b>"." a supprimé la facture n°{$facture->num_facture}");

        return response()->json(['message' => 'Facture supprimée'], 200);
    }
}
