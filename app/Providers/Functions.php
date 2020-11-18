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
}
