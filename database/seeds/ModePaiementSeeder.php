<?php

use App\ModePaiement;
use Illuminate\Database\Seeder;

class ModePaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $paiements = [
            ["libelle"=>'cheque',"description"=>""],
            ["libelle"=>'virement',"description"=>""],
            ["libelle"=>'espèces',"description"=>""],
            ["libelle"=>'airtelmoney',"description"=>""],
            ["libelle"=>'mobicash',"description"=>""]
        ];

        foreach($paiements as $paiement)
        {
            ModePaiement::create([
                'libelle' => $paiement['libelle'],
                'description' => $paiement['description']
            ]);
        }
    }
}
