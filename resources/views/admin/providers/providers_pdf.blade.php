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

        /* body{ margin: 1em; width: 100%} */
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
<section>
    <h2 style="border: 2px solid black; background: #9BC2E6; padding: 5px; text-align: center; text-transform: uppercase">
        situation des  fournisseurs ({{ count($providers) }})<br>
        <span style="font-size: 12px">Période du {{ $start->format('d/m/Y') }} au {{ $end->format('d/m/Y') }}</span>
    </h2>
    <table class="totaux">
        <thead>
        <tr>
            <th>Montant Total Engagé</th>
            <th>Montant Total Payé</th>
            <th>Solde</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="text-align: center">
                {{ number_format($m_engage, 0, ',', ' ') }}
            </td>
            <td style="text-align: center">
                {{ number_format($m_paye, 0, ',', ' ') }}
            </td>
            <td style="text-align: center">
                {{ number_format($solde, 0, ',', ' ') }}
            </td>
        </tr>
        </tbody>
    </table>
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>Nom</th>
                <th>NIF</th>
                <th>Montant engagé</th>
                <th>Montant payé</th>
                <th>Solde</th>
            </tr>
            </thead>
            <tbody>
            @foreach($providers as $provider)
            <tr>
                <td>{{ $provider->name }}</td>
                <td style="text-align:center">{{ $provider->nif }}{{ $provider->code_nif }}</td>
                <td style="text-align: center">{{ number_format($provider->mt_engage, 0, ',', ' ') }}</td>
                <td style="text-align: center">{{ number_format($provider->mt_paye, 0, ',', ' ') }}</td>
                <td style="text-align: center">{{ number_format($provider->solde, 0, ',', ' ') }}</td>
            </tr>
            @endforeach
            {{--<tr style="font-weight: bold;">
                <td colspan="5" style="background: #BDD7EE">
                Total
                </td>
                <td style="text-align: center; background: #BDD7EE">{{ number_format($m_engage, 0, ',', ' ') }}</td>
                <td style="text-align: center; background: #BDD7EE">{{ number_format($m_paye, 0, ',', ' ') }}</td>
                <td style="text-align: center; background: #BDD7EE">{{ number_format($m_engage - $m_paye, 0, ',', ' ') }}</td>
            </tr>--}}
            </tbody>
            {{--<tfoot>--}}
            {{--<tr>--}}
                {{--<th colspan="5">--}}
                    {{--Total--}}
                {{--</th>--}}
                {{--<th></th>--}}
                {{--<th></th>--}}
                {{--<th></th>--}}
            {{--</tr>--}}
            {{--</tfoot>--}}
        </table>
    </div>
    <p style="text-align: right; margin: 50px 40px 0 0; font-weight: bold">Visa D.F</p>
</section>
</body></html>
