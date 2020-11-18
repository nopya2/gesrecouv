<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Paiement;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Facture extends Model
{
    use LogsActivity;

    protected static $ignoreChangedAttributes = ['state',"statut"];
    protected static $logOnlyDirty = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'id', 'utilisateur_id', 'parent_id', 'client_id', 'type_id', 'statut', 'num_facture', 'montant', 'num_dossier', 'date_creation', 'date_depot', 'date_echeance',
    //     'date_paiement', 'commentaire', 'created_at', 'updated_at', 'deleted', 'state'
    // ];

    protected $guarded = [];

    protected $casts = [
        'date_creation' => 'datetime:Y-m-d H:i:s',
        'date_depot' => 'datetime:Y-m-d H:i:s',
        'date_echeance' => 'datetime:Y-m-d H:i:s',
        'date_paiement' => 'datetime:Y-m-d H:i:s',
        'deleted' => 'boolean'
        // 'd_previsional_paiement' => 'datetime:Y-m-d',
    ];
    protected $attributes = [
        'deleted' => false
    ];

    // protected static $logAttributes = ['name', 'text'];

    public function utilisateur()
    {
        return $this->belongsTo('App\User');
    }

    public function parent()
    {
        return $this->belongsTo('App\Facture');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function paiements()
    {
        return $this->hasMany('App\Paiement');
    }

    public function getMPaidAttribute(){
        $amount = 0;
        $paiements = $this->paiements()->get()->toArray();
        foreach($paiements as $paiement){
            $amount += $paiement['montant'];
        }

        return $amount;
    }

    public function getMNotPaidAttribute(){
        return $this->montant - $this->getMPaidAttribute();
    }

    public function getDescriptionForEvent(string $eventName): string
    {

        if($eventName=="created")
        {
            $user = Auth::user();
            return "{$user->fullName} a créé la facture n°{$this->num_facture} ";
        }
        if($eventName=="updated")
        {
            $user = Auth::user();
            return "{$user->fullName} a modifié la facture n°{$this->num_facture} ";
        }
        if($eventName=="deleted")
        {
            $user = Auth::user();
            return "{$user->fullName} a supprimé la facture n°{$this->num_facture} ";
        }
    }
}
