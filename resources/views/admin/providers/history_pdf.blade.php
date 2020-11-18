<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
    <style>
        body{ margin: 1em; width: 100%}
        /*p { width: 50%; text-align: justify; }*/
        header{
            width: 100%;
            height: 160px;
        }
        header .left{
            float: left;
            width: 33.33333333333333%;
            height: auto;
            text-align: center;
            font-size: 11px;
        }
        header .center{
            float: left;
            width: 33.33333333333333%;
            height: auto;
            text-align: center;
        }
        header .center img{
            text-align: center;
            width: 70px;
            height: auto;
        }
        header .right{
            float: left;
            width: 33.33333333333333%;
            height: auto;
            text-align: center;
        }
        .table {
            width: 100%;
            height: auto;
        }
        .table table{
            width: 100%;
            /*border: 1px solid black;*/
            border-collapse: collapse;
            table-layout: fixed;
        }
        .table table thead tr th{
            text-align: center;
            vertical-align: middle;
            font-size: 13px;
            background: #BDD7EE;
            border: 1px solid black;
            height: 30px;
        }
        .table table tbody tr td{
            vertical-align: middle;
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;
        }


    </style>
</head>
<body>
<header>
    <div class="left">
        PRESIDENCE DE LA REPUBLIQUE<br>
        ---------------------------<br>
        AGENCE NATIONALE DES INFRASTRUCTURES<br>
        NUMERIQUES ET DES FREQUENCES<br>
        ---------------------------<br>
        DIRECTION GENERALE<br>
        ---------------------------<br>
        DIRECTION FINANCIERE<br>
        ---------------------------<br>
        SERVICE COMPTABILITE ET FACTURATION<br>
        ---------------------------<br>
        N°_____/PR/ANINF/DG/DF/SCF/BC
    </div>
    <div class="center">
        <img src="img/logo/logo.png">
    </div>
    <div class="right">
        REPUBLIQUE GABONAISE<br>
        -----------------<br>
        Union – Travail – Justice
    </div>
</header>
<section>
    <h2 style="border: 2px solid black; background: #9BC2E6; padding: 5px; text-align: center; text-transform: uppercase">situation de {{ $provider }} au {{ $current_date->format('d/m/Y') }}</h2>
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>N° de facture</th>
                <th>Date Ordonnance</th>
                <th>Date de paiement</th>
                <th>N° Ordonnance</th>
                <th>Objet de la dépense</th>
                <th>Montant engagé</th>
                <th>Montant payé</th>
                <th>Solde</th>
            </tr>
            </thead>
            <tbody>
            @foreach($echelons as $echelon)
            <tr>
                <td>{{ $echelon->engagement->n_devis }}</td>
                <td style="text-align: center">{{ $echelon->created_at->format('d/m/Y') }}</td>
                <td style="text-align: center">
                    @if($echelon->date_paiement)
                        {{ $echelon->date_paiement->format('d/m/Y') }}
                    @endif
                </td>
                <td>{{ $echelon->n_ordonnance }}</td>
                <td>{{ $echelon->engagement->l_dep }}</td>
                <td style="text-align: center">{{ number_format($echelon->engagement->m_engage, 0, ',', ' ') }}</td>
                <td style="text-align: center">{{ number_format($echelon->m_paye, 0, ',', ' ') }}</td>
                <td style="text-align: center">{{ number_format($echelon->engagement->m_engage - $echelon->m_paye, 0, ',', ' ') }}</td>
            </tr>
            @endforeach
            <tr style="font-weight: bold;">
                <td colspan="5" style="background: #BDD7EE">
                Total
                </td>
                <td style="text-align: center; background: #BDD7EE">{{ number_format($m_engage, 0, ',', ' ') }}</td>
                <td style="text-align: center; background: #BDD7EE">{{ number_format($m_paye, 0, ',', ' ') }}</td>
                <td style="text-align: center; background: #BDD7EE">{{ number_format($m_engage - $m_paye, 0, ',', ' ') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</section>
</body></html>
