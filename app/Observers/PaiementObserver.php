<?php

namespace App\Observers;

use App\Paiement;

class PaiementObserver
{
    /**
     * Handle the paiement "created" event.
     *
     * @param  \App\Paiement  $paiement
     * @return void
     */
    public function created(Paiement $paiement)
    {
        // if($paiement->facture->MNotPaid <= 0){
        //     $paiement->facture->statut = 'paid';
        //     $paiement->facture->date_paiement = now();
        //     $paiement->facture->save();
        // }

        // $paiement->facture->touch();
    }

    /**
     * Handle the paiement "updated" event.
     *
     * @param  \App\Paiement  $paiement
     * @return void
     */
    public function updated(Paiement $paiement)
    {
        if($paiement->state == 'validated'){
            if($paiement->facture->m_paid < $paiement->facture->montant){
                $paiement->facture->m_paid += $paiement->montant;

                if($paiement->facture->MNotPaid <= 0){
                    $paiement->facture->statut = 'paid';
                    $paiement->facture->date_paiement = now();
                    $paiement->facture->save();
                }
            }
            
            $paiement->facture->touch();
        }
        
    }

    /**
     * Handle the paiement "deleted" event.
     *
     * @param  \App\Paiement  $paiement
     * @return void
     */
    public function deleted(Paiement $paiement)
    {
        //
    }

    /**
     * Handle the paiement "restored" event.
     *
     * @param  \App\Paiement  $paiement
     * @return void
     */
    public function restored(Paiement $paiement)
    {
        //
    }

    /**
     * Handle the paiement "force deleted" event.
     *
     * @param  \App\Paiement  $paiement
     * @return void
     */
    public function forceDeleted(Paiement $paiement)
    {
        //
    }
}
