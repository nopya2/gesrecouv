<?php

namespace App\Providers;
use App\Facture;
use Illuminate\Support\Facades\DB;

class Functions{

    public static function stringToDate($dateExcel){
        if($dateExcel === '' || $dateExcel === NULL){
            return NULL;
        }

        if(gettype($dateExcel) === 'integer'){
            $date = date('Y-m-d 00:00', intval((intval($dateExcel) - 25569)*24*60*60 ));
            return new \DateTime($date);
        }
        else{
            $array = explode('/', $dateExcel);
            if(count($array) >= 3){
                $finalDateExcel = $array[2].'-'.$array[1].'-'.$array[0].' 00:00';
                return $date = new \DateTime($finalDateExcel);
            }else{
                return null;
            }

        }
////        elseif (strpos($dateExcel, '/') !== false){
////            $array = explode('/', $dateExcel);
////            $finalDateExcel = $array[2].'-'.$array[1].'-'.$array[0].' 00:00';
////
////            return new \DateTime($finalDateExcel);
////        }
//        else{
//            return NULL;
//        }

    }

    public static function generateNumPaiment(){
        // $last = DB::table('paiements')->latest('created_at')->first();
        $num = 'P'.date('Y').date('m').date('d').date('H').date('i').date('s');

        return $num;
    }

    public static function generateNumFacture($codeType){

        $year = date('Y');

        $lastFacture = Facture::whereBetween('created_at', [$year.'-01'.'-01', date('Y').'-12'.'-31'])->orderBy('created_at', 'desc')->first();
        if(!$lastFacture){
            return strtoupper("1/{$year}/{$codeType}/pr/aninf/dg/df/scf");
        }
        
        $arrayChars = explode('/', $lastFacture->num_facture);
        $numFacture = strtoupper((intval($arrayChars[0])+1)."/{$year}/{$codeType}/pr/aninf/dg/df/scf");

        return $numFacture;
    }

    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
