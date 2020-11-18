<?php

namespace App\Observers;

use App\Facture;

class FactureObserver
{
    /**
     * Handle the facture "created" event.
     *
     * @param  \App\Facture  $facture
     * @return void
     */
    public function created(Facture $facture)
    {
        // dd(0);
    }

    /**
     * Handle the facture "updated" event.
     *
     * @param  \App\Facture  $facture
     * @return void
     */
    public function updated(Facture $facture)
    {
        // dd(0);
    }

    /**
     * Handle the facture "deleted" event.
     *
     * @param  \App\Facture  $facture
     * @return void
     */
    public function deleted(Facture $facture)
    {
        //
    }

    /**
     * Handle the facture "restored" event.
     *
     * @param  \App\Facture  $facture
     * @return void
     */
    public function restored(Facture $facture)
    {
        //
    }

    /**
     * Handle the facture "force deleted" event.
     *
     * @param  \App\Facture  $facture
     * @return void
     */
    public function forceDeleted(Facture $facture)
    {
        //
    }
}
