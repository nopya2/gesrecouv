<?php

namespace App\Imports;

use App\Engagement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Providers\Functions;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class EngagementsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Engagement|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            //On doit d'abord vérifier si l'engagement existe
            $result = Engagement::where('n_engage', '=', $row['n_engage'])
                ->orderBy('id', 'DESC')
                ->first();
            if(empty($result)){
                $r_engage = null;
                $desc_r_engage = null;
                //Si l'engagement n'existe pas, on cree un nouvel engament
                //Avant de créer l'engagement, on vérifie si un engagement avec ce numéro de devis existe
                $search = Engagement::where('n_devis', '=', $row['n_devis'])
                    ->where('d_exerci', '=', $row['d_exerci'])
                    ->orderBy('id', 'DESC')
                    ->first();
                if(!empty($search)){
                    //Si l'engagement ayant ce numéro de devis existe, on considère cet engagement comme un réengagement
                    $r_engage = 'r';
                    $desc_r_engage = "Réengagement OP: ".$search->n_engage.", Exerice: ".$search->d_exerci;
                }

                Engagement::create([
                    'd_exerci'  => intval($row['d_exerci']),
                    'c_dest'   => strval($row['c_dest']),
                    'nat_dep'   => $row['nature de la dépenses'],
                    'l_dep'    => $row['L_dest'],
                    'm_dispo'  => doubleval($row['m_dispo']),
                    'm_toteng'   => doubleval($row['m_toteng']),
                    'm_tengvi'  => doubleval($row['m_tengvi']),
                    'm_totliq'  => doubleval($row['m_totliq']),
                    'm_tordvi'  => doubleval($row['m_tordvi']),
                    'm_totord'  => doubleval($row['m_totord']),
                    'm_dotini'  => doubleval($row['m_dotini']),
                    'n_engage'  => $row['n_engage'],
                    'm_engage'  => doubleval($row['m_engage']),
                    'date_depot_ac'  => Functions::stringToDate($row["dates_dépôt AC "]),
                    'date_paiement'  => Functions::stringToDate($row['dates_paiement']),
                    'm_paye'  => doubleval($row['m_payés']),
                    'd_engage'  => Functions::stringToDate($row['d_engage']),
                    'mois_'  => $row['mois_'],
                    'm_tliqenga'  => doubleval($row['m_tliqenga']),
                    'm_non_paye'  => doubleval($row['m_non payés']),
                    'l_depeng'  => $row['l_depeng'],
                    'l_nmtir'  => $row['l_nmtir'],
                    'n_mattir'  => $row['n_mattir'],
                    'c_mattir'  => $row['c_mattir'],
                    'chap'  => substr($row['c_dest'], 5, 2),
                    'l_chap'  => $row['l_chap'],
                    'n_devis'  => $row['n_devis'],
                    'r_engage' => $r_engage,
                    'desc_r_engage' => $desc_r_engage,
                    'date_echeance'  => (Functions::stringToDate($row['d_engage']))->add(new \DateInterval('P90D')),
                    'realized'  => false,
                ]);
            }else{
                //Si l'engagement existe
                //On modifie les champs suivants de l'engagement
                //Fournisseur [l_nmtir, n_mattir, c_mattir]
                //Montant engagé [m_engage]
                //Librellé de la dépense [l_depeng]
                //N° facture [n_devis]
                $result->nat_dep = $row['nature de la dépenses'];
                $result->l_nmtir = $row['l_nmtir'];
                $result->n_mattir = $row['n_mattir'];
                $result->c_mattir = $row['c_mattir'];
                $result->m_engage = doubleval($row['m_engage']);
                $result->l_depeng = $row['l_depeng'];
                $result->n_devis = $row['n_devis'];

                $result->save();
            }
        }
    }

//    public function headingRow(): int
//    {
//        return 2;
//    }
}
