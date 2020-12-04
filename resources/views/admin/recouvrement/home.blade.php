@extends('admin.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tableau de bord | Exercice {{ date('Y') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="#">Accueil</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-top border-primary mb-3">
                        <div class="card-header d-flex">
                            <h3>Vos clients vous doivent</h3>
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="btn nav-link" href="/factures?start={{$start}}&end={{$end}}&statut=not_paid">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <p style="font-size: 35px" class="text-primary">
                                <strong>{{ number_format($not_paid, 0, "", " ") }} Fcfa</strong>
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="alert border-warning">
                                        <strong class="text-lg text-orange">En retard</strong>
                                        <a type="button" class="close btn btn-sm" href="/factures?start={{$start}}&end={{$end}}&statut=later">
                                            <i class="fas fa-plus-circle"></i>
                                        </a>
                                        <p class="text-orange" style="font-size: 30px"><strong>{{ number_format($late, 0, "", " ") }} Fcfa</strong></p>
                                        <p class="text-orange m-0">({{ number_format($nb_clients_late, 0, "", " ") }} clients)</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert border-primary">
                                        <strong class="text-lg text-primary">A venir</strong>
                                        <a type="button" class="close btn btn-sm" href="/factures?start={{$start}}&end={{$end}}&statut=waiting">
                                            <i class="fas fa-plus-circle"></i>
                                        </a>
                                        <p class="text-primary" style="font-size: 30px"><strong>{{ number_format($waiting, 0, "", " ") }} Fcfa</strong></p>
                                        <p class="text-primary m-0">({{ number_format($nb_clients_waiting, 0, "", " ") }} clients)</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-top border-success mb-3">
                        <div class="card-header">
                            <h3>Payé</h3>
                        </div>
                        <div class="card-body">
                            <p style="font-size: 35px" class="text-success">
                                <strong>{{ number_format($last_trimester, 0, "", " ") }} Fcfa</strong>
                            </p>
                            <p class="card-text text-success">
                                Paiements reçus sur les trois derniers mois de l'exercice en cours
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-top border-secondary mb-3">
                        {{-- <div class="card-header">
                            <h3>Header</h3>
                        </div> --}}
                        <div class="card-body">
                            <h5 class="card-title">Primary card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card border-top border-primary mb-3">
                        <div class="card-header">
                            <h3>Qui vous doit quoi?</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table projects">
                                <thead>
                                    <tr>
                                        <td class="text-center vertical-align">Client</td>
                                        <td class="text-center vertical-align">Relance</td>
                                        <th class="text-orange text-center vertical-align">En retard</th>
                                        <th class="text-info text-center vertical-align">A venir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client_not_paid_factures as $client)
                                    <tr>
                                        <td class="vertical-align">
                                            <a href="/clients/{{$client->id}}">
                                                    {{ $client->raison_sociale }} <span class="text-sm text-gray">({{count($client->factures)}})</span>
                                                </a>
                                            </td>
                                        <td class="vertical-align text-center">
                                            @if(count($client->relaunches) > 0)
                                            18/01/2020<br>
                                            3
                                            @else
                                            <span class="text-gray-dark">Aucune relance </span>
                                            @endif
                                        </td>
                                        <td class="vertical-align text-center">
                                            <strong class="text-orange">{{ number_format($client->notPaidLateByYear(), 0, "", " ") }}</strong>
                                        </td>
                                        <td class="vertical-align text-center">
                                            <strong class="text-info">{{ number_format($client->notPaidWaitingByYear(), 0, "", " ") }}</strong>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="text-center p-2">
                                <a class="btn btn-primary text-light" href="/clients">Voir en détails</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-top border-warning mb-3">
                        <div class="card-header">
                            <h3>Montant à relancer</h3>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Primary card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('custom_scripts')
    <script>
        $(function () {

        })
    </script>
@endpush
