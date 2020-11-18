<?php

namespace App\Http\Controllers;

use App\Engagement;
use App\NatureDepense;
use App\Historique;
use App\Importation;
use App\Http\Resources\Engagement as EngagementResource;
use App\Http\Resources\NatureDepense as NatureDepenseResource;
use App\Imports\EngagementsImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Excel;
//use Illuminate\Support\Collection;
use App\Support\Collection;

class EngagementController extends Controller
{
    public function home()
    {
        return view('admin.engagements.index', [
            'page' => 'engagement',
            'sub_page' => 'engagement.list'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $provider = "";
        if($request->has('provider'))
            $provider = $request->provider;
        $field = 'id';
        $order = "desc";
        if($request->order !== NULL){
            $field = 'm_engage';
            $order = $request->order;
        }
        //On liste en fonction de la date de l'engagement et non en fonction de l'exercice
        $requete = Engagement::where('nat_dep', 'LIKE', '%'.$request->nature.'%')
            ->where(function ($query) use ($request){
                $query->where('n_engage', 'LIKE', '%' . $request->keyword . '%')
                    // ->orWhere('l_dep', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('l_depeng', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('l_nmtir', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('n_mattir', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('c_mattir', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('l_chap', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('n_devis', 'like', '%' . $request->keyword . '%')
                    ;
            })
            ->where('l_nmtir', 'LIKE', '%'.$provider.'%')
            ->where('cancelled', false);

        if(!is_null($request->exercice)){
            $requete
                ->where('d_exerci', '=', $request->exercice);

            if(intval($request->month) != 0){
                $start = $request->exercice.'-'.$request->month.'-01';
                $lastDay = (new \DateTime($start))->format('t');
                $end = $request->exercice.'-'.$request->month.'-'.$lastDay;
                $requete
                    ->whereBetween('d_engage', [$start, $end]);
            }
        }

        if($request->realized !== null){
            $realized = false;
            if($request->realized === 'true')
                $realized = true;
            $requete
                ->where('realized', $realized);
        }

        if($request->chapitre !== null){
            $requete
                ->where('chap', $request->chapitre);
        }

        $engagements = $requete
            ->orderBy($field, $order)->get();

        //On selectionne tous les engagements en retard
        if($request->late === 'true'){
            $engagements = $engagements->filter(function ($engagement) {
                return $engagement->is_late === true;
            });
        }

        //On selectionne tous les reengagements
        if($request->reengagement === 'true'){
            $engagements = $engagements->filter(function ($engagement) {
                return $engagement->r_engage === 'r';
            });
        }

        //On filtre les engagements payés et non payés
        if($request->status !== NULL){
            if($request->status === 'paye'){
                $engagements = $engagements->filter(function ($engagement) {
                    return $engagement->is_paid == true;
                });
            }elseif($request->status === 'non_paye'){
                $engagements = $engagements->filter(function ($engagement) {
                    return $engagement->is_paid == false;
                });
            }
        }

        //On récupere le montant total des engagements
        $amountEngage = 0;
        $amountPaye = 0;
//        $amountNonPaye = 0;
        foreach ($engagements as $engagement) {
            $amountEngage += $engagement->m_engage;
            $amountPaye += $engagement->m_paye;
        }

        $amountNonPaye = $amountEngage - $amountPaye;

        return [
              'm_engage' => $amountEngage,
              'm_paye' => $amountPaye,
              'm_non_paye' => $amountNonPaye,
              'resources' => EngagementResource::collection($engagements)->paginate(15),
          ];

    }

    public function searchPost(Request $request)
    {
        $provider = "";
        if($request->has('provider'))
            $provider = $request->provider;
        $field = 'id';
        $order = "desc";
        if($request->order !== NULL){
            $field = 'm_engage';
            $order = $request->order;
        }
        //On liste en fonction de la date de l'engagement et non en fonction de l'exercice
        $requete = Engagement::where('nat_dep', 'LIKE', '%'.$request->nature.'%')
            ->where(function ($query) use ($request){
                $query->where('n_engage', 'LIKE', '%' . $request->keyword . '%')
                    // ->orWhere('l_dep', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('l_depeng', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('l_nmtir', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('n_mattir', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('c_mattir', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('l_chap', 'like', '%' . $request->keyword . '%')
                    // ->orWhere('n_devis', 'like', '%' . $request->keyword . '%')
                    ;
            })
            // ->where('l_nmtir', 'IN', '(AGENCE COMPTABLE ANINF)')
            ->where('cancelled', false);

        // $matchCases = [];
        $requete->whereIn('l_nmtir', $request->providers);

        $string = ['l_nmtir'=>'AGENCE COMPTABLE ANINF'];

        if(!is_null($request->exercice)){
            $requete
                ->where('d_exerci', '=', $request->exercice);

            if(intval($request->month) != 0){
                $start = $request->exercice.'-'.$request->month.'-01';
                $lastDay = (new \DateTime($start))->format('t');
                $end = $request->exercice.'-'.$request->month.'-'.$lastDay;
                $requete
                    ->whereBetween('d_engage', [$start, $end]);
            }
        }

        if($request->realized !== null){
            $realized = false;
            if($request->realized === 'true')
                $realized = true;
            $requete
                ->where('realized', $realized);
        }

        if($request->chapitre !== null){
            $requete
                ->where('chap', $request->chapitre);
        }

        $engagements = $requete
            ->orderBy($field, $order)->get();

        //On selectionne tous les engagements en retard
        if($request->late === 'true'){
            $engagements = $engagements->filter(function ($engagement) {
                return $engagement->is_late === true;
            });
        }

        //On selectionne tous les reengagements
        if($request->reengagement === 'true'){
            $engagements = $engagements->filter(function ($engagement) {
                return $engagement->r_engage === 'r';
            });
        }

        //On filtre les engagements payés et non payés
        if($request->status !== NULL){
            if($request->status === 'paye'){
                $engagements = $engagements->filter(function ($engagement) {
                    return $engagement->is_paid == true;
                });
            }elseif($request->status === 'non_paye'){
                $engagements = $engagements->filter(function ($engagement) {
                    return $engagement->is_paid == false;
                });
            }
        }

        //On récupere le montant total des engagements
        $amountEngage = 0;
        $amountPaye = 0;
//        $amountNonPaye = 0;
        foreach ($engagements as $engagement) {
            $amountEngage += $engagement->m_engage;
            $amountPaye += $engagement->m_paye;
        }

        $amountNonPaye = $amountEngage - $amountPaye;

        return [
              'm_engage' => $amountEngage,
              'm_paye' => $amountPaye,
              'm_non_paye' => $amountNonPaye,
              'resources' => EngagementResource::collection($engagements)->paginate(15),
          ];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Engagement  $engagement
     * @return \Illuminate\Http\Response
     */
    public function show(Engagement $engagement)
    {
//        $engagement = Engagement::findOrFail($engagement);

        return view('admin.engagements.show', [
            'engagement' => $engagement,
            'page' => 'engagement',
            'sub_page' => 'engagement.show'
        ]);
    }

    public function ajaxSelectSingle($engagement)
    {
        $engagement = Engagement::findOrFail($engagement);

        if(!empty($engagement))
            return new EngagementResource($engagement);
        else
            return new JsonResponse('error', 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Engagement  $engagement
     * @return \Illuminate\Http\Response
     */
    public function edit(Engagement $engagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Engagement  $engagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'commentaire' => ['required'],
        ]);

        $engagement = Engagement::find($request->id);

        $engagement->commentaire = $data['commentaire'];
        $engagement->realized = $request->realized;
        $engagement->updated_at = new \DateTime();

        $engagement->save();


        return new EngagementResource($engagement);
    }

    public function import(Request $request){

        // $this->validate($request, [
        //     'file'  => 'required|mimes:xls,xlsx'
        // ]);

        $exercice = intval($request->exercice);

        try {
            Excel::import(new EngagementsImport(), request()->file('file'));
        } catch (\Exception $e) {
            dd($e);
        }

        //upload excel file after importing


        $fileName = $exercice.'-'.time().'.'.$request->file->extension();

        $request->file->move(public_path('uploads/excel-files'), $fileName);

        //On cree la base de donnees les chapitres issus des engagements

        //On cree l'evenement
        $currentUser = Auth::user();
        $options['user'] = $currentUser->name." ".$currentUser->firstname;
        $options['action'] = 'Importations engagements';
        $options['filename'] = $fileName;

        $event = Historique::forceCreate([
            'body' => $options,
        ]);

        //On cree le log de l'importation
        $importation = Importation::forceCreate([
            'filename' => $fileName,
        ]);

        return new JsonResponse('success', 200);
    }

    public function engagementsParStatut(){
        $currentYear = date('Y');

        $engagements = Engagement::where('d_exerci', $currentYear)->get();
        $engagementPaye = 0;
        $engagementNonPaye = 0;

        foreach ($engagements as $engagement){
            if($engagement->is_paid === true)
                $engagementPaye++;
            else
                $engagementNonPaye++;
        }

        return new JsonResponse([
            'engagement_paye' => $engagementPaye,
            'engagement_non_paye' => $engagementNonPaye
        ]);

    }

    public function engagementsParAnnee(){
        $year = intval(date('Y'));
        $years = [];
        for($i = 10; $i > 0; $i--){
            array_push($years, $year--);
        }
        $years = array_reverse($years);

        $engagements = [];
        $engagementsPayes = [];
        $engagementsNonPayes = [];
        foreach ($years as $year){
            $allEngagements = Engagement::where('d_exerci', $year)->get();

            $nbre = count($allEngagements);
            array_push($engagements, $nbre);

            $nbrePayes = count($allEngagements->filter(function ($engagement) { return $engagement->is_paid == true; }));
            array_push($engagementsPayes, $nbrePayes);

            $nbreNonPayes = $nbre - $nbrePayes;
            array_push($engagementsNonPayes, $nbreNonPayes);
        }

        return [
            'years' => $years,
            'engagements' => $engagements,
            'payes' => $engagementsPayes,
            'non_payes' => $engagementsNonPayes
        ];
    }

    public function montantParAnnee(){
        $year = intval(date('Y'));
        $years = [];
        for($i = 10; $i > 0; $i--){
            array_push($years, $year--);
        }
        $years = array_reverse($years);

        $engagements = [];
        $engagementsPayes = [];
        $engagementsNonPayes = [];
        foreach ($years as $year){
            $allEngagements = Engagement::where('d_exerci', $year)->get();

            $total = $allEngagements->sum('m_engage');
            array_push($engagements, $total);

            $payes = ($allEngagements->filter(function ($engagement) { return $engagement->is_paid == true; }))->sum('m_paye');
            array_push($engagementsPayes, $payes);

            $nonPayes = $total - $payes;
            array_push($engagementsNonPayes, $nonPayes);
        }

        return [
            'years' => $years,
            'engagements' => $engagements,
            'payes' => $engagementsPayes,
            'non_payes' => $engagementsNonPayes
        ];
    }

    public function search()
    {
        return view('admin.engagements.search', [
            'page' => 'engagement.search',
            'sub_page' => 'engagement.search.list'
        ]);
    }

    public function engagementsByMutlicriteria(Request $request)
    {
        $devis = $request->devis;
        $start = $request->start;
        $end = $request->end;
        $provider = $request->provider;
        $status = $request->status;
        $imputation = $request->imputation;
        $nature = $request->nature;
        $lbl_imputation = $request->lbl_imputation;
        $n_engagement = $request->n_engagement;
        $lbl_depense = $request->lbl_depense;
        $chapitre = $request->chapitre;
        $n_matricule = $request->n_matricule;
        $c_matricule = $request->c_matricule;
        $date_depot_start = $request->date_depot_start;
        $date_depot_end = $request->date_depot_end;
        $date_paiement_start = $request->date_paiement_start;
        $date_paiement_end = $request->date_paiement_end;
        $date_engagement_start = $request->date_engagement_start;
        $date_engagement_end = $request->date_engagement_end;

//        dd($date_depot_start);

        $query = Engagement::whereBetween('d_exerci', [$start, $end])
            ->where('l_nmtir', 'LIKE', '%'.$provider.'%')
            ->where('n_devis', 'LIKE', '%'.$devis.'%')
            ->where('c_dest', 'LIKE', '%'.$imputation.'%')
            ->where('nat_dep', 'LIKE', '%'.$nature.'%')
            ->where('l_dep', 'LIKE', '%'.$lbl_imputation.'%')
            ->where('n_engage', 'LIKE', '%'.$n_engagement.'%')
            ->where('l_depeng', 'LIKE', '%'.$lbl_depense.'%')
            ->where('l_chap', 'LIKE', '%'.$chapitre.'%')
            ->where('n_mattir', 'LIKE', '%'.$n_matricule.'%')
            ->where('c_mattir', 'LIKE', '%'.$c_matricule.'%');

        if($date_depot_start !== null && $date_depot_end !== null){
            $query
                ->whereBetween('date_depot_ac', [$date_depot_start.' 00:00', $date_depot_end.' 23:59']);
        }
        if($date_paiement_start !== null && $date_paiement_end !== null){
            $query
                ->whereBetween('date_paiement', [$date_paiement_start.' 00:00', $date_paiement_end.' 23:59']);
        }
        if($date_engagement_start !== null && $date_engagement_end !== null){
            $query
                ->whereBetween('d_engage', [$date_engagement_start.' 00:00', $date_engagement_end.' 23:59']);
        }

        $engagements = $query
            ->orderBy('id', 'desc')
            ->get();

        //On filtre les engagements par statut
        if($status !== NULL){
            switch ($status) {
                case 'paye':
                    $engagements = $engagements->filter(function ($engagement) {
                        return $engagement->is_paid == true;
                    });
                    break;
                case 'paye_early':
                    $engagements = $engagements->filter(function ($engagement) {
                        return $engagement->is_paid_early == true;
                    });
                    break;
                case 'paye_later':
                    $engagements = $engagements->filter(function ($engagement) {
                        return $engagement->is_paid_later == true;
                    });
                    break;
                case 'non_paye':
                    $engagements = $engagements->filter(function ($engagement) {
                        return $engagement->is_paid == false;
                    });
                    break;
                case 'non_paye_later':
                    $engagements = $engagements->filter(function ($engagement) {
                        return ($engagement->is_paid == false && $engagement->is_late == true);
                    });
                    break;
                default:
                    // code...
                    break;
            }

        }

        // if($status){
        //     if($status == 'paye')
        //         $bool = true;
        //     else
        //         $bool = false;
        //
        //     $engagements = Engagement::whereBetween('d_exerci', [$start, $end])
        //         ->where('l_nmtir', 'LIKE', '%'.$provider.'%')
        //         ->where('n_devis', 'LIKE', '%'.$devis.'%')
        //         ->where('is_paid', $bool)
        //         ->orderBy('id', 'desc')
        //         ->paginate(15);
        // }

        return EngagementResource::collection($engagements)->paginate(15);
    }

    public function listNaturesDepenses(){
        $natures = NatureDepense::all();

        return NatureDepenseResource::collection($natures);
    }

    //Liste des données pour le filtre multicitères
    public function loadCriterias(Request $request)
    {
        $natures = NatureDepense::all();
        $imputations = DB::table('engagements')->select('c_dest as imputation')
            ->where('c_dest', 'LIKE', '%'.$request->imputation.'%')
            ->distinct()
            ->limit(5)
            ->get();
        $lblImputBudgets = DB::table('engagements')->select('l_dep as lbl_imputation')
            ->where('l_dep', 'LIKE', '%'.$request->lbl_imputation.'%')
            ->distinct()
            ->limit(5)
            ->get();

        $nEngagements = DB::table('engagements')->select('n_engage as n_engagement')
            ->where('n_engage', 'LIKE', '%'.$request->n_engagement.'%')
            ->distinct()
            ->limit(5)
            ->get();

        $lblDepenses = DB::table('engagements')->select('l_depeng as lbl_depense')
            ->where('l_depeng', 'LIKE', '%'.$request->lbl_depense.'%')
            ->distinct()
            ->limit(5)
            ->get();

        $chapitres = DB::table('engagements')->select('l_chap as chapitre')
            ->where('l_chap', 'LIKE', '%'.$request->chapitre.'%')
            ->distinct()
            ->limit(5)
            ->get();

        $nMatricules = DB::table('engagements')->select('n_mattir as n_matricule')
            ->where('n_mattir', 'LIKE', '%'.$request->n_matricule.'%')
            ->distinct()
            ->limit(5)
            ->get();

        $cMatricules = DB::table('engagements')->select('c_mattir as c_matricule')
            ->where('c_mattir', 'LIKE', '%'.$request->c_matricule.'%')
            ->distinct()
            ->limit(5)
            ->get();

        return [
            'natures' => $natures,
            'lbl_imputations' => $lblImputBudgets,
            'imputations' => $imputations,
            'n_engagements' => $nEngagements,
            'lbl_depenses' => $lblDepenses,
            'chapitres' => $chapitres,
            'n_matricules' => $nMatricules,
            'c_matricules' => $cMatricules
        ];
    }

    /**
     * Selection des engagements pour les formulaires
     */
    public function selectEngagementsForInputField(Request $request){
        $field = 'id';
        $order = "desc";
        $nature = '';
        if($request->has('nature'))
            $nature = $request->nature;

        $engagements = Engagement::where('n_engage', 'LIKE', '%' . $request->keyword . '%')
            ->where('nat_dep', 'LIKE', '%' . $nature . '%')
            ->orderBy($field, $order)
            ->limit(10)
            ->get();

        return EngagementResource::collection($engagements);
    }

    public function cancel(Request $request){
        $engagement = Engagement::find($request->id);

        $engagement->cancelled = true;
        $engagement->save();

        return new EngagementResource($engagement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Engagement  $engagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Engagement $engagement)
    {
        //
    }

    public function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
    }
}
