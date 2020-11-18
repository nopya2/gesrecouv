<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
    <style>
        @page {
            margin: 1.5cm 1.5cm 2cm 1.5cm;
        }

        body {
            /* font-family: sans-serif; */
            margin: 0.5cm 0;
            /* text-align: justify; */
        }

        header{
            width: 100%;
            height: 160px;
        }
        header .left{
            float: left;
            width: 33.33333333333333%;
            height: auto;
            text-align: center;
            font-size: 10px;
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

        #footer {
            position: fixed;
            left: 0;
            right: 0;
            color: #aaa;
            font-size: 0.8em;
            bottom: 0;
        }
        #footer .page-number {
            text-align: right;
        }
        #footer .page-number:before {
            content: "Page " counter(page)
        }
        #footer .informations{
            border-top: 0.1pt solid #aaa;
            text-align: center;
        }

        table.totaux {
            width: 70%;
            height: auto;
            border-collapse: collapse;
            table-layout: fixed;
            margin: 10px 0 20px 0;
        }
        table.totaux thead tr th{
            text-align: center;
            vertical-align: middle;
            font-size: 13px;
            background: #BDD7EE;
            border: 1px solid black;
            height: 30px;
        }
        table.totaux tbody tr td{
            vertical-align: middle;
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;
        }

        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 60%;
            /* font-weight: 700; */
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
        }
        .badge-success {
            color: #fff;
            background-color: #26A042;
        }
        .badge-danger {
            color: #fff;
            background-color: #dc3545;
        }

        ul.legend {
            display: block;
            width: 100%;
            height: auto;
            text-align: right;
            margin-top: 30px;
            list-style: none;
            padding: 0px;
            font-size: 13px;
        }
        ul.legend li{
            height: auto;
            list-style: none;
            display: inline-block;
        }
        .table {
            width: 100%;
            height: auto;
        }
        .table table{
            width: 100%;
            /*border: 1px solid black;*/
            border-collapse: collapse;
            /* table-layout: fixed; */
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
            N°__________/PR/ANINF/DG/DF/SCF/BC
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
    <div id="footer">
        <div class="page-number"></div>
        <div class="informations">
            Agence Nationale des Infrastructures Numériques et des Fréquences<br>
            BP: 798 - Libreville - Tél: +241 11 76 32 49/11 76 32 79 - e-mail: info@aninf.ga
        </div>
    </div>
    <h2 style="border: 2px solid black; background: #9BC2E6; padding: 5px; text-align: center; text-transform: uppercase">
        situation de {{ $provider }}<br>
        <span style="font-size: 12px">Période: Du {{ $start->format('d/m/Y') }} au {{ $end->format('d/m/Y') }}</span>
    </h2>
    <table class="totaux">
        <thead>
            <tr>
                <th style="text-align: center">Montants Engagés</th>
                <th style="text-align: center">Montants Payés</th>
                <th style="text-align: center">Montants Non Payés</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center">{{ number_format($m_engage, 0, ',', ' ') }}</td>
                <td style="text-align: center">{{ number_format($m_paye, 0, ',', ' ') }}</td>
                <td style="text-align: center">{{ number_format($m_non_paye, 0, ',', ' ') }}</td>
            </tr>
        </tbody>
    </table>

    <ul class="legend">
        <li>
            <span class="badge badge-success">{{ $nbre_payes }}</span> Payé
        </li>
        <li>
            <span class="badge badge-danger">{{ $nbre_non_payes }}</span> Non payé
        </li>
    </ul>
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th style="text-align: center">N° engagement</th>
                <th style="text-align: center">N° devis</th>
                <th style="text-align: center">Intitulé de la dépense</th>
                <th style="text-align: center">Montant engagé</th>
                <th style="text-align: center">Montant payé</th>
                <th style="text-align: center">Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($engagements as $engagement)
            <tr>
                <td width="10px">
                    @if($engagement->is_paid == true)
                        <span class="badge badge-success">&nbsp;</span>
                    @else
                        <span class="badge badge-danger">&nbsp;</span>
                    @endif
                </td>
                <td>{{ $engagement->n_engage }}</td>
                <td style="text-transform: uppercase">{{ $engagement->n_devis }}</td>
                <td>{{ $engagement->l_depeng }}</td>
                <td style="text-align: center">{{ number_format($engagement->m_engage, 0, ',', ' ') }}</td>
                <td style="text-align: center">{{ number_format($engagement->m_paye, 0, ',', ' ') }}</td>
                <td style="text-align: center">
                    @if($engagement->date_paiement)
                        {{ $engagement->date_paiement->format('d/m/Y') }}
                    @else
                        N/A
                    @endif

                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <p style="text-align: right; margin: 50px 40px 0 0; font-weight: bold">Visa D.F</p>
</body></html>
