<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'id', 'utilisateur_id', 'raison_sociale', 'nif', 'bp', 'adresse', 'ville', 'pays', 'tel', 'responsable', 'tel_responsable', 'email', 'type', 'created_at',
    //     'updated_at'
    // ];

    protected $guarded = [];

    public function utilisateur()
    {
        return $this->belongsTo('App\User');
    }

    public function factures()
    {
        return $this->hasMany('App\Facture');
    }

    public function relaunches()
    {
        return $this->hasMany('App\Models\Relaunch')->orderBy('id', 'desc');
    }

    public function secteur()
    {
        return $this->belongsTo('App\Models\SecteurActivite');
    }

    //Factures non payées et en retard de l'exercice en cours
    public function notPaidLateByYear(){
        $currentYear = date('Y');

        $filtered = $this->factures->filter(function ($item, $key) use ($currentYear){
            return  
                $item->date_creation >= "{$currentYear}-01-01" && $item->date_creation <= "{$currentYear}-12-31"
                && $item->date_echeance < now()->format('Y-m-d').' 00:00:00'
                && $item->statut !== 'credit_note'
                && $item->deleted === false
                && $item->statut !== 'cancelled';
        });

        return $filtered->sum('montant');
    }

    //Factures non payées en attente de l'exercice en cours
    public function notPaidWaitingByYear(){
        $currentYear = date('Y');

        $filtered = $this->factures->filter(function ($item, $key) use ($currentYear){
            return  
                $item->date_creation >= "{$currentYear}-01-01" && $item->date_creation <= "{$currentYear}-12-31"
                && $item->date_echeance >= now()->format('Y-m-d').' 00:00:00'
                && $item->statut !== 'credit_note'
                && $item->deleted === false
                && $item->statut !== 'cancelled';
        });

        return $filtered->sum('montant');
    }

    //Total montant des factures
    public function getTotalAmountAttribute(){
        if($this->factures->count() <= 0)
            return 0;
        return $this->factures->filter(function ($facture, $key){
            return $facture->deleted === false && $facture->statut !== 'cancelled'
                    && $facture->state === 'validated';
        })->sum('montant');
    }

    
    //Montant total payé
    public function getMPaidAttribute(){
        return $filtered = $this->factures->filter(function ($item, $key){
            return $item->statut == 'paid';
        })->sum('montant');
    }

    //Montant total non payé
    public function getMNotPaidAttribute(){
        return $this->getTotalAmountAttribute() - $this->getMPaidAttribute();
    }

    //Montant total non payé en retard
    public function getMNotPaidLateAttribute(){
        return $this->factures->filter(function ($facture, $key){
            return $facture->deleted === false && $facture->statut !== 'cancelled'
                    && $facture->statut !== 'credit_note'
                    && $facture->state === 'validated'
                    && $facture->date_echeance < now();
        })->sum('montant');
    }

    //Montant total non payé en attente
    public function getMNotPaidWaitingAttribute(){
        return $this->factures->filter(function ($facture, $key){
            return $facture->deleted === false && $facture->statut !== 'cancelled'
                    && $facture->statut !== 'credit_note'
                    && $facture->state === 'validated'
                    && $facture->date_echeance >= now();
        })->sum('montant');
    }

    //Factures payées
    public function getPaidAttribute(){
        return $this->factures->filter(function ($facture, $key){
            return $facture->statut === 'paid';
        });
    }

    //Factures non payées
    public function getNotPaidAttribute(){
        return $this->factures->filter(function ($facture, $key){
            return $facture->deleted === false 
                    && $facture->statut !== 'credit_note' && $facture->statut !== 'cancelled'
                    && $facture->state === 'validated'  && $facture->statut !== 'paid';
        });
    }

}
