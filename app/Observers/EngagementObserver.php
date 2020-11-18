<?php

namespace App\Observers;

use App\Engagement;

class EngagementObserver
{
    /**
     * Handle the quote "retrieved" event.
     *
     * @param  \App\Engagement  $engagement
     * @return void
     */
//    public function retrieved(Engagement $engagement)
//    {
//        if($engagement->m_paye >= $engagement->m_engage){
//            $engagement->is_paid = true;
//            $engagement->save();
//        }
//
//    }

    /**
     * Handle the engagement "created" event.
     *
     * @param  \App\Engagement  $engagement
     * @return void
     */
    public function created(Engagement $engagement)
    {
        //
    }

    /**
     * Handle the engagement "updated" event.
     *
     * @param  \App\Engagement  $engagement
     * @return void
     */
    public function updated(Engagement $engagement)
    {
        //
    }

    /**
     * Handle the engagement "deleted" event.
     *
     * @param  \App\Engagement  $engagement
     * @return void
     */
    public function deleted(Engagement $engagement)
    {
        //
    }

    /**
     * Handle the engagement "restored" event.
     *
     * @param  \App\Engagement  $engagement
     * @return void
     */
    public function restored(Engagement $engagement)
    {
        //
    }

    /**
     * Handle the engagement "force deleted" event.
     *
     * @param  \App\Engagement  $engagement
     * @return void
     */
    public function forceDeleted(Engagement $engagement)
    {
        //
    }
}
