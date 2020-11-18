<?php

namespace App\Http\Controllers;

use App\Engagement;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function home()
    {
        return view('admin.statistics', [
            'page' => 'statistics',
            'sub_page' => 'statistics'
        ]);
    }

    public function statistics(Request $request){
        //Selection des engagements  par annee

    }

    public function engagementsAnnee(Request $request){
        $year = $request->year;
        $months = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre',
            'Novembre', 'Décembre'
        ];

        $engagements = [];
        $engagementsPayes = [];
        $engagementsNonPayes = [];
        for($i = 1; $i <= 12; $i++){
            $allEngagements = Engagement::whereBetween('d_engage', [$year.'-'.$i.'-1', $year.'-'.$i.'-31'])->get();

            $nbre = count($allEngagements);
            array_push($engagements, $nbre);

            $nbrePayes = count($allEngagements->filter(function ($engagement) { return $engagement->is_paid == true; }));
            array_push($engagementsPayes, $nbrePayes);

            $nbreNonPayes = $nbre - $nbrePayes;
            array_push($engagementsNonPayes, $nbreNonPayes);
        }

        return [
            'months' => $months,
            'engagements' => $engagements,
            'payes' => $engagementsPayes,
            'non_payes' => $engagementsNonPayes
        ];
    }

    public function montantsEngagesAnnee(Request $request){
        $year = $request->year;
        $months = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre',
            'Novembre', 'Décembre'
        ];

        $engagements = [];
        $engagementsPayes = [];
        $engagementsNonPayes = [];
        for($i = 1; $i <= 12; $i++){
            $allEngagements = Engagement::whereBetween('d_engage', [$year.'-'.$i.'-1', $year.'-'.$i.'-31'])->get();

            $total = $allEngagements->sum('m_engage');
            array_push($engagements, $total);

            $payes = ($allEngagements->filter(function ($engagement) { return $engagement->is_paid == true; }))->sum('m_paye');
            array_push($engagementsPayes, $payes);

            $nonPayes = $total - $payes;
            array_push($engagementsNonPayes, $nonPayes);
        }

        return [
            'months' => $months,
            'engagements' => $engagements,
            'payes' => $engagementsPayes,
            'non_payes' => $engagementsNonPayes
        ];
    }

    public function engagementsStatutAnnee(Request $request){
        $year = $request->year;
        $allEngagements = Engagement::whereBetween('d_engage', [$year.'-01-01', $year.'-12-31'])->get();
        $nbre = count($allEngagements);

        $nbrePayes = count($allEngagements->filter(function ($engagement) { return $engagement->is_paid == true; }));
        $nbreNonPayes = $nbre - $nbrePayes;

        return [
            'payes' => $nbrePayes,
            'non_payes' => $nbreNonPayes
        ];
    }
}
