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
    protected $fillable = [
        'id', 'utilisateur_id', 'raison_sociale', 'nif', 'bp', 'adresse', 'ville', 'pays', 'tel', 'responsable', 'tel_responsable', 'email', 'type', 'created_at',
        'updated_at'
    ];

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

    //Factures non payées et en retard
    public function notPaidLateByYear(){
        $currentYear = date('Y');

        $filtered = $this->factures->filter(function ($item, $key) use ($currentYear){
            return  
                $item->date_creation >= "{$currentYear}-01-01" && $item->date_creation <= "{$currentYear}-12-31"
                && $item->date_echeance < now()->format('Y-m-d').' 00:00:00';
        });

        return $filtered->sum('montant');
    }

    //Factures non payées en attente
    public function notPaidWaitingByYear(){
        $currentYear = date('Y');

        $filtered = $this->factures->filter(function ($item, $key) use ($currentYear){
            return  
                $item->date_creation >= "{$currentYear}-01-01" && $item->date_creation <= "{$currentYear}-12-31"
                && $item->date_echeance >= now()->format('Y-m-d').' 00:00:00';
        });

        return $filtered->sum('montant');
    }

    public function getTotalAmountAttribute(){
        if($this->factures->count() <= 0)
            return 0;
        return $this->factures->sum('montant');
    }

    public function getMPaidAttribute(){
        return $filtered = $this->factures->filter(function ($item, $key){
            return $item->statut == 'paid';
        })->sum('montant');
    }

    public function getMNotPaidAttribute(){
        return $this->getTotalAmountAttribute() - $this->getMPaidAttribute();
    }

    // public function getMNotPaidLate(){
    //     return $filtered = $this->factures->filter(function ($item, $key){
    //         return $item->statut == 'paid';
    //     })->sum('montant');
    // }


}
