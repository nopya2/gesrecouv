<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function getVilles(Request $request)
    {
        $villes = ['Libreville', 'Port-Gentil', 'Franceville', 'Oyem', 'Moanda', 'Mouila', 'Lambaréné', 'Tchibanga', 'Koulamoutou'
        	   ,'Makokou', 'Bitam', 'Tsogni', 'Gamba', 'Mounana', 'Ntoum', 'Nkan', 'Lastourville', 'Okondja', 'Ndendé', 'Booué'
               ,'Fougamou', 'Ndjolé', 'Mbigou', 'Mayumba', 'Mitzic', 'Mékambo', 'Lékoni', 'Mimongo', 'Minvoul', 'Medouneu', 'Omboué'
               ,'Cocobeach', 'Kango'];

        return ['villes' => $villes];
    }

    public function getPays(Request $request)
    {
        $pays = ['Gabon'];

        return ['pays' => $pays];
    }
}
