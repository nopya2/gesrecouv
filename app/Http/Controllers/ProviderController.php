<?php

namespace App\Http\Controllers;

use App\Echelon;
use App\Engagement;
use App\Provider;
use App\Situation;
use App\Http\Resources\Provider as ProviderResource;
use App\Http\Resources\Engagement as EngagementResource;
use App\Http\Resources\Echelon as EchelonResource;
use Illuminate\Http\Request;
use PDF;
use App\Exports\ProvidersExport;
use Maatwebsite\Excel\Facades\Excel;

class ProviderController extends Controller
{
    public function home()
    {
        return view('admin.providers.index', [
            'page' => 'provider',
            'sub_page' => 'provider.list'
        ]);
    }

    public function index(Request $request)
    {
        $keyword = "";
        if($request->has('keyword'))
            $keyword = $request->keyword;
        $providers = Provider::where('name', 'like', '%'.$keyword.'%')
            ->orderBy('name', 'ASC')
            ->get();

        foreach ($providers as $provider) {
            $provider->mt_engage = Engagement::where('l_nmtir', '=', $provider->name)->sum('m_engage');
            $provider->mt_paye = Engagement::where('l_nmtir', '=', $provider->name)->sum('m_paye');
            $provider->solde = $provider->mt_engage - $provider->mt_paye;
            if($provider->name === "AGENCE COMPTABLE ANINF" && $provider->nif !== '900741'){
                unset($provider);
            }
        }

        return ProviderResource::collection($providers);
    }



    public function loadData(Request $request){

        $engagements = Engagement::where('l_nmtir', $request->provider)
            ->orderBy('id', 'DESC')
            ->get();

        $echelons = Echelon::whereHas('engagement', function ($query) use ($request){
                    $query->where('l_nmtir', $request->provider);
                })
            ->orderBy('id', 'desc')
            ->get();

        return [
            'engagements' => $engagements,
            'echelons' => $echelons
        ];

    }

    public function loadEngagements(Request $request){

        $requete = Engagement::where('l_nmtir', $request->provider)
            ->where(function ($query) use ($request){
                $query
                    ->where('n_engage', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('n_devis', 'LIKE', '%' . $request->keyword . '%');
            });

        if($request->start != null && $request->end != null){
            $requete
                ->whereBetween('d_engage', [$request->start, $request->end]);
        }


        $engagements = $requete
            ->orderBy('id', 'DESC')
            ->get();

        //On récupere le montant total des engagements
        $amountEngage = 0;
        $amountPaye = 0;
        $amountNonPaye = 0;
        foreach ($engagements as $engagement) {
            $amountEngage += $engagement->m_engage;
            if($engagement->is_paid == true) {$amountPaye += $engagement->m_paye;}
        }

        $amountNonPaye = $amountEngage - $amountPaye;

        return [
            'resources' => EngagementResource::collection($engagements)->paginate(10),
            'm_engage' => $amountEngage,
            'm_paye' => $amountPaye,
            'm_non_paye' => $amountNonPaye
        ];

    }

    public function loadEchelons(Request $request){

        $echelons = Echelon::whereHas('engagement', function ($query) use ($request){
                $query
                    ->where('l_nmtir', $request->provider)
                    ->where(function ($query) use ($request){
                        $query
                            ->where('n_engage', 'LIKE', '%' . $request->keyword . '%')
                            ->orWhere('n_devis', 'LIKE', '%' . $request->keyword . '%');
                    });
            })
            ->where('etat', '=', 'validated')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return EchelonResource::collection($echelons);

    }

    public function printPDF(Request $request){
        $requete = Engagement::where('l_nmtir', $request->provider);

        if($request->start != null && $request->end != null){
            $requete
                ->whereBetween('d_engage', [$request->start, $request->end]);
        }

        $engagements = $requete
            ->orderBy('id', 'DESC')
            ->get();

        //On récupere le montant total des engagements
        $amountEngage = 0;
        $amountPaye = 0;
        $amountNonPaye = 0;
        $nbrPayes = 0;
        foreach ($engagements as $engagement) {
            $amountEngage += $engagement->m_engage;
            if($engagement->is_paid == true) {
                $amountPaye += $engagement->m_paye;
                $nbrPayes++;
            }
        }

        $amountNonPaye = $amountEngage - $amountPaye;
        $nbrNonPayes = count($engagements) - $nbrPayes;

        $pdf = PDF::loadView('admin.providers.provider_pdf', [
            'engagements' => $engagements,
            'm_engage' => $amountEngage,
            'm_paye' => $amountPaye,
            'm_non_paye' => $amountNonPaye,
            'provider' => $request->provider,
            'start' => new \DateTime($request->start),
            'end' => new \DateTime($request->end),
            'nbre_payes' => $nbrPayes,
            'nbre_non_payes' => $nbrNonPayes
        ]);
//        return $pdf->download('medium.pdf');
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('fichier.pdf');
    }

    public function history(Request $request){
        $currentDate = new \DateTime();
        $requete = Engagement::where('l_nmtir', $request->provider)
            ->where('cancelled', false)
            ->whereBetween('d_engage', ['2011-01-01', $currentDate->format('Y-m-d')]);

        $engagements = $requete
            ->orderBy('id', 'DESC')
            ->get();

        //On récupere le montant total des engagements
        $amountEngage = 0;
        $amountPaye = 0;
        $amountNonPaye = 0;
        $nbrPayes = 0;
        $echelons = [];
        foreach ($engagements as $engagement) {
            foreach ($engagement->echelons as $echelon){
                if($echelon->etat === 'validated'){
                    array_push($echelons, $echelon);
                }
            }
        }
        foreach ($echelons as $echelon) {
            $amountEngage += $echelon->engagement->m_engage;
            if($echelon->engagement->is_paid == true) {
                $amountPaye += $echelon->m_paye;
                $nbrPayes++;
            }
        }


        $amountNonPaye = $amountEngage - $amountPaye;
        $nbrNonPayes = count($engagements) - $nbrPayes;

        $pdf = PDF::loadView('admin.providers.history_pdf', [
            'engagements' => $engagements,
            'm_engage' => $amountEngage,
            'm_paye' => $amountPaye,
            'm_non_paye' => $amountNonPaye,
            'provider' => $request->provider,
            'start' => new \DateTime($request->start),
            'end' => new \DateTime($request->end),
            'nbre_payes' => $nbrPayes,
            'nbre_non_payes' => $nbrNonPayes,
            'echelons' => $echelons,
            'current_date' => $currentDate
        ]);
//        return $pdf->download('medium.pdf');
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('fichier.pdf');
    }

    public function printProviders(Request $request){
        $currentDate = new \DateTime();
        $start = $request->start;
        $end = $request->end;

        $providers = Provider::orderBy('name', 'ASC')->get();
        $mTotalEngage = 0;
        $mTotalPaye = 0;
        foreach ($providers as $provider) {
            $provider->mt_engage = Engagement::where('l_nmtir', '=', $provider->name)->whereBetween('d_engage', [$start, $end])->sum('m_engage');
            $provider->mt_paye = Engagement::where('l_nmtir', '=', $provider->name)->whereBetween('d_engage', [$start, $end])->sum('m_paye');
            $provider->solde = $provider->mt_engage - $provider->mt_paye;
            $mTotalEngage += $provider->mt_engage;
            $mTotalPaye += $provider->mt_paye;
        }

        $soldeTotal = $mTotalEngage - $mTotalPaye;

        $pdf = PDF::loadView('admin.providers.providers_pdf', [
            'providers' => $providers,
            'current_date' => $currentDate,
            'm_engage' => $mTotalEngage,
            'm_paye' => $mTotalPaye,
            'solde' => $soldeTotal,
            'start' => new \DateTime($start),
            'end' => new \DateTime($end)
        ]);
//        return $pdf->download('medium.pdf');
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('situation-fournisseurs-'.$currentDate->format('dmY').'.pdf');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function exportProviders()
    {
        return Excel::download(new ProvidersExport, 'fournisseurs.xlsx');
    }
}
