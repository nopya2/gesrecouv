<?php

namespace App\Observers;

use App\Echelon;
use App\Historique;
use Illuminate\Support\Facades\Auth;

class EchelonObserver
{
    /**
     * Handle the echelon "created" event.
     *
     * @param  \App\Echelon  $echelon
     * @return void
     */
    public function created(Echelon $echelon)
    {
        $currentUser = Auth::user();
        $options['echelon_id'] = $echelon->id;
        $options['user'] = $currentUser->name." ".$currentUser->firstname;
        $options['action'] = 'Ajouter un paiement';
        $options['engagement'] = $echelon->engagement->n_engage;
        $options['montant'] = $echelon->m_paye;

        $event = Historique::forceCreate([
            'body' => $options,
        ]);

        //
    }

    /**
     * Handle the echelon "updated" event.
     *
     * @param  \App\Echelon  $echelon
     * @return void
     */
    public function updated(Echelon $echelon)
    {
        //
    }

    /**
     * Handle the echelon "deleted" event.
     *
     * @param  \App\Echelon  $echelon
     * @return void
     */
    public function deleted(Echelon $echelon)
    {
        //
    }

    /**
     * Handle the echelon "restored" event.
     *
     * @param  \App\Echelon  $echelon
     * @return void
     */
    public function restored(Echelon $echelon)
    {
        //
    }

    /**
     * Handle the echelon "force deleted" event.
     *
     * @param  \App\Echelon  $echelon
     * @return void
     */
    public function forceDeleted(Echelon $echelon)
    {
        //
    }
}
