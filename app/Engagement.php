<?php

namespace App;

use App\Echelon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Engagement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'd_exerci', 'c_dest', 'nat_dep', 'l_dep', 'm_dispo', 'm_toteng', 'm_tengvi', 'm_totliq', 'm_tordvi',
        'm_totord', 'm_dotini', 'n_engage', 'm_engage', 'date_depot_ac', 'date_paiement', 'm_paye', 'd_engage', 'mois_',
        'm_tliqenga', 'm_non_paye', 'l_depeng', 'l_nmtir', 'n_mattir', 'c_mattir', 'chap', 'l_chap', 'n_devis', 'nip', 'r_engage',
        'desc_r_engage', 'v_m_paye', 'is_paid', 'created_at', 'updated_at', 'date_echeance', 'engagement', 'realized', 'commentaire',
        'cancelled'
    ];

    protected $casts = [
        'd_engage' => 'datetime',
        'date_paiement' => 'datetime',
        'is_paid' => 'boolean',
        'date_echeance' => 'datetime',
        'date_depot_ac' => 'datetime',
        'realized' => 'boolean',
        'cancelled' => 'boolean',
        'created_at' => 'datetime'
        // 'd_previsional_paiement' => 'datetime:Y-m-d',
    ];

//    public function getMPayeAttribute($value)
//    {
//        if($this->getOriginal('m_engage') <= 0)
//            return 0;
//
//        $echelons = Echelon::where('n_engage', '=', $this->getOriginal('n_engage'))->get();
//        $amount = 0;
//        foreach ($echelons as $echelon){
//            $amount += $echelon->m_paye;
//        }
//        return $amount;
//    }

    public function getMNonPayeAttribute($value)
    {
//        if($this->getOriginal('m_engage') <= 0)
//            return 0;
//
//        $echelons = Echelon::where('n_engage', '=', $this->getOriginal('n_engage'))->get();
//        $amount = 0;
//        foreach ($echelons as $echelon){
//            $amount += $echelon->m_paye;
//        }
//        return $this->getOriginal('m_engage') - $amount;
        return $this->m_engage - $this->m_paye;
    }

    public function getMEngageAttribute($value)
    {
        return $value;
    }

    public function echelons()
    {
        return $this->hasMany('App\Echelon');
    }

    public function getIsLateAttribute(){
        //On ajoute 90 jours a la date de paiement
//        $datePaiement = new \DateTime($this->getOriginal('d_engage'));
//        $dateFinPaiement = $datePaiement->add(new \DateInterval('P90D'));
        $now = new \DateTime();

        if($this->getIsPaidAttribute()) return false;

        //On compare la date de delai du paiement et la date actuelle
        if($this->date_echeance >= $now)
            return false;

        return true;
    }

    public function getFormatLDepengAttribute(){
        return Str::limit($this->l_depeng, 20, ' (...)');
    }

    public function getFormatLDepAttribute(){
        return Str::limit($this->l_dep, 20, ' (...)');
    }

    public function getIsPaidAttribute(){
        if($this->m_paye >= $this->m_engage) return true;
        else return false;
    }

    public function getDPrevisionalPaiementAttribute(){
        $dEngagement = new \DateTime($this->d_engage);
        return $dEngagement->add(new \DateInterval('P90D'));
    }

    public function getIsPaidEarlyAttribute(){
        if($this->date_echeance >= $this->date_paiement && $this->getIsPaidAttribute() == true)
            return true;

        return false;
    }

    public function getIsPaidLaterAttribute(){
        if($this->getDPrevisionalPaiementAttribute() < $this->date_paiement && $this->getIsPaidAttribute() == true)
            return true;

        return false;
    }
}
