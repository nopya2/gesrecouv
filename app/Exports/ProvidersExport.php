<?php

namespace App\Exports;

use App\Provider;
use App\Engagement;
use App\Http\Resources\Provider as ProviderResource;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProvidersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $providers = Provider::all();
        foreach ($providers as $provider) {
            $provider->mt_engage = Engagement::where('l_nmtir', '=', $provider->name)->sum('m_engage');
            $provider->mt_paye = Engagement::where('l_nmtir', '=', $provider->name)->sum('m_paye');
            $provider->solde = $provider->mt_engage - $provider->mt_paye;
        }

        return ProviderResource::collection($providers);

    }
}
