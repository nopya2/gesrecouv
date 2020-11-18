<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
    <style>
        body{
            margin: 5px 20px 5px 20px;
            width: 100%
        }
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
        .footer{
            width: 100%;
            margin: 30px 0 0 0;
            height: auto;
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            text-decoration: underline;
        }
        .footer .left{
            width: 50%;
            height: auto;
            float: left;
        }
        .footer .right{
            width: 50%;
            height: auto;
            float: right;
        }
    </style>
</head>
<body marginwidth="0" marginheight="0">
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
        N°0{{ $bordereau->id }}/PR/ANINF/DG/DF/SCF/BC
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
    <div style="background: #E7E6E6">
        <h3 style="width: 100%; text-align: center">BORDEREAU D'ENVOI DES JOURNEES COMPTABLES</h3>
        <p style="text-align: center">
            <span style="text-transform: uppercase">{{ $bordereau->nature }}</span>
            <span style="margin-left: 30px">N°0{{ $bordereau->id }}</span>
        </p>
    </div>
    <p style="text-align: center">Journée comptable du : {{ $bordereau->created_at->format('d/m/Y') }}</p>
    <h3 style="text-align: center; background: #E7E6E6">Chapitre: {{ $bordereau->chapitre->n_chap }} {{ $bordereau->chapitre->l_chap }}</h3>
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>N°</th>
                <th>N°  de l'engagement</th>
                <th>Imputation</th>
                <th>Montant engagé</th>
                <th>N°Ordonnance</th>
                <th>Fournisseur</th>
                <th>Objet de la Dépense</th>
                <th>Montant ordonnancé</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bordereau->echelons as $key =>$item)
            <tr>
                <td style="text-align: center">{{ $key+1 }}</td>
                <td style="text-align: center">{{ $item->engagement->n_engage }}</td>
                <td style="text-align: center">{{ $item->engagement->c_dest }}</td>
                <td style="text-align: center">{{ number_format($item->engagement->m_engage, 0, ',', ' ') }}</td>
                <td>{{ $item->n_ordonnance }}</td>
                <td>{{ $item->engagement->l_nmtir }}</td>
                <td>{{ $item->engagement->l_dep }}</td>
                <td style="text-align: center">{{ number_format($item->m_paye, 0, ',', ' ') }}</td>
            </tr>
            @endforeach
            <tr>
                <th></th>
                <th colspan="2" style="border: 1px solid black">Nbre Total d'Ordonnances:</th>
                <th style="text-align: center; border: 1px solid black">{{ count($bordereau->echelons) }}</th>
                <th colspan="3"></th>
                <th style="text-align: center; border: 1px solid black">{{ number_format($bordereau->m_ordonnance, 0, ',', ' ') }}</th>
            </tr>
            </tbody>
        </table>
        <div class="footer">
            <div class="left">
                <p>direction financière</p>
            </div>
            <div class="right">
                <p>agence comptable</p>
            </div>
        </div>
    </div>
</section>
</body>
</html>
