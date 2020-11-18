<?php

namespace App\Http\Controllers;

use App\Echelon;
use App\Engagement;
use App\User;
use App\Provider;
use App\Importation;
use Illuminate\Http\Request;

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
    public function index()
    {
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

        return view('admin.dashboard', [
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
}
