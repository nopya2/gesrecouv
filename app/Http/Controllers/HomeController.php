<?php

namespace App\Http\Controllers;

use App\Echelon;
use App\Engagement;
use App\User;
use App\Provider;
use App\Importation;
use App\Facture;
use App\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if(!$request->has('mod'))
            return response('Cette page n\'existe pas', 404);

        switch ($request->mod) {
            case 'comptabilite':
                return $this->dashboardComptabilite($request);
            case 'recouvrement':
                return $this->dashboardRecouvrement($request);
            case 2:
                echo "i égal 2";
            default:
                return $this->error($request);
        }
    }

    /*
    * Dashboar pour le module comptabilité
    */
    public function dashboardComptabilite($request){
        $currentYear = date('Y');

        $engagements = Engagement::where('d_exerci', $currentYear)->count();
        $paiements = Echelon::whereBetween('date_paiement', [$currentYear.'-01-01 00:00', $currentYear.'-12-31 23:59'])->count();
        $paiementsToValidate = Echelon::whereBetween('date_paiement', [$currentYear.'-01-01 00:00', $currentYear.'-12-31 23:59'])
            ->where('etat', '=', 'waiting')
            ->count();
        $lastPaiements = Echelon::whereBetween('date_paiement', [$currentYear.'-01-01 00:00', $currentYear.'-12-31 23:59'])
            ->take(7)
            ->orderBy('id', 'DESC')
            ->get();
        $users = User::all()->count();
        $providers = Provider::all()->count();

        //On va recuper le CPU traffic en fonction du type d'OS utilise
        //Pour Windows
         // $res = shell_exec('wmic cpu get loadpercentage');
         // $array = explode("\r\n", $res);
         // $memory = intval($array[1]);

        //for Linux
        $load = sys_getloadavg();
        $memory = $load[0] * 100;

        //Notification mise à jour
        $update = false;
        $lastImport = Importation::where('filename', 'LIKE', '%%')->orderBy('created_at', 'DESC')->first();
        if($lastImport === null) $update = true;
        if($lastImport !== null){
            $duration = ((new \DateTime())->diff($lastImport->created_at))->days;
            if($duration > 7) $update = true;
        }

        return view('admin.recouvrement.home', [
            'engagements' => $engagements,
            'paiements' => $paiements,
            'last_paiements' => $lastPaiements,
            'to_validate' => $paiementsToValidate,
            'users' => $users,
            'providers' => $providers,
            'update' => $update,
            'memory' => $memory,
            'page' => 'dashboard',
            'sub_page' => ''
        ]);

    }
    /*
    * Dashboar pour le module recouvrement
    *
    */
    public function dashboardRecouvrement($request){
        $currentYear = date('Y');
        $start = $currentYear.'-01-01';
        $end = $currentYear.'-12-31';

        //la dette de tous les clients - Toutes les factures non payées pour l'année en cours
        $notPaid = Facture::where('statut', '!=', 'paid')
            ->whereBetween('date_creation', ["{$currentYear}-01-01", "{$currentYear}-12-31"])
            ->where('deleted', false)
            ->where('statut', '!=', 'cancelled')
            ->where('statut', '!=', 'credit_note')
            ->where('state', '!=', 'waiting')
            ->get();

        //Le montant des factures en retard
        $late = Facture::where('statut', '!=', 'paid')
            ->whereBetween('date_creation', ["{$currentYear}-01-01", "{$currentYear}-12-31"])
            ->where('date_echeance', '<', now()->format('Y-m-d').' 00:00:00')
            ->where('deleted', false)
            ->where('statut', '!=', 'cancelled')
            ->where('statut', '!=', 'credit_note')
            ->where('state', '!=', 'waiting')
            ->get();
            
        //Le nombre de clients ayant des facture en retard
        $clientsLate = Client::where(function ($query) use ($request, $currentYear){
            $query
                ->whereHas('factures', function ($query) use ($request, $currentYear){
                    $query
                        ->where('statut', '!=', 'paid')
                        ->whereBetween('date_creation', ["{$currentYear}-01-01", "{$currentYear}-12-31"])
                        ->where('date_echeance', '<', now())
                        ->where('deleted', false)
                        ->where('statut', '!=', 'cancelled')
                        ->where('statut', '!=', 'credit_note')
                        ->where('state', '!=', 'waiting');
                });
        })->get();
        $nbClientsLate = count($clientsLate);

        //Le montant des factures en attente
        $waiting = Facture::where('statut', '!=', 'paid')
            ->whereBetween('date_creation', ["{$currentYear}-01-01", "{$currentYear}-12-31"])
            ->where('date_echeance', '>=', now()->format('Y-m-d').' 00:00:00')
            ->where('deleted', false)
            ->where('statut', '!=', 'cancelled')
            ->where('statut', '!=', 'credit_note')
            ->where('state', '!=', 'waiting')
            ->get();
            
        //
        $nbClientsWaiting = Client::where(function ($query) use ($request, $currentYear){
            $query
                ->whereHas('factures', function ($query) use ($request, $currentYear){
                    $query
                        ->where('statut', '!=', 'paid')
                        ->whereBetween('date_creation', ["{$currentYear}-01-01", "{$currentYear}-12-31"])
                        ->where('date_echeance', '>=', now())
                        ->where('deleted', false)
                        ->where('statut', '!=', 'cancelled')
                        ->where('statut', '!=', 'credit_note')
                        ->where('state', '!=', 'waiting');
                });
        })->get()->count();

        //Paiement effectué sur les 3 derniers mois
        $lastTrimester = Facture::where('statut', 'paid')
            ->whereBetween('date_creation', ["{$currentYear}-01-01", "{$currentYear}-12-31"])
            ->whereBetween('date_paiement', [Carbon::today()->subMonths(3)->toDateTimeString(), Carbon::today()->toDateTimeString()])
            ->get();

        //Liste des clients ayant des factures non payées
        $clientsNotPaidFactures = Client::where(function ($query) use ($request, $currentYear){
            $query
                ->whereHas('factures', function ($query) use ($request, $currentYear){
                    $query
                        ->where('statut', '!=', 'paid')
                        ->whereBetween('date_creation', ["{$currentYear}-01-01", "{$currentYear}-12-31"])
                        // ->where('date_echeance', '<', now())
                        ->where('deleted', false)
                        ->where('statut', '!=', 'cancelled')
                        ->where('statut', '!=', 'credit_note')
                        ->where('state', '!=', 'waiting');
                });
        })->get()->take(10);

        return view('admin.recouvrement.home', [
            'page' => 'dashboard',
            'sub_page' => '',
            'not_paid' => $notPaid->sum('montant'),
            'late' => $late->sum('montant'),
            'clients_late' => $clientsLate,
            'nb_clients_late' => $nbClientsLate,
            'waiting' => $waiting->sum('montant'),
            'nb_clients_waiting' => $nbClientsWaiting,
            'last_trimester' => $lastTrimester->sum('montant'),
            'client_not_paid_factures' => $clientsNotPaidFactures,
            'start' => $start,
            'end' => $end


        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function test()
    {
        return view('test');
    }

    public function portail(Request $request){
        return view('admin.portail', [
            
        ]);
    }

    public function error(Request $request){
        $module = $request->mod;
        switch($module){
            case 'recouvrement':
                $layout = 'admin.recouvrement.layout';
                break;
            default:
                return view('errors.error_404');
                
                
        }

        return view('error', [
            'layout' => $layout
        ]);
    }
}
