<?php

namespace App\Exports;

use App\Engagement;
use Maatwebsite\Excel\Concerns\FromCollection;

class EngagementsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Engagement::all();
    }
}
