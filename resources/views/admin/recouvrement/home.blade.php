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
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">CPU Traffic</span>
                            <span class="info-box-number">
                  {{ $memory }}
                  <small>%</small>
                </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Engagements</span>
                            <span class="info-box-number">{{ $engagements }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Paiements</span>
                            <span class="info-box-number">{{ $paiements }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-shipping-fast"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Fournisseurs</span>
                            <span class="info-box-number">{{ $providers }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Utilisateurs</span>
                            <span class="info-box-number">{{ $users }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

            <div class="row">
                <div class="col-md-4">
                    @if($update == true)
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Mise à jour!</h5>
                        Votre de base de données des engagements n'est pas à jour <a href="{{ route('engagement.index') }}">Allez à la page</a>
                    </div>
                    @endif
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-info"></i> Validation paiements!</h5>
                        Il y'a {{ $to_validate }} paiements à valider <a href="{{ route('echelon.index') }}">Allez à la page</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Derniers paiements
                                <a href="{{ route('echelon.index') }}"><button class="btn btn-primary">Tous</button></a>
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive table-striped">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>N&deg; engagement</th>
                                        <th>Fournisseur</th>
                                        <th>Date</th>
                                        <th>N&deg; devis</th>
                                        <th>Montant payé</th>
                                        <th>Utilisateur</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($last_paiements) <=0)
                                    <tr>
                                        <td colspan="6" style="text-align: center">Aucun paiement</td>
                                    </tr>
                                    @endif
                                    @foreach ($last_paiements as $paiement)
                                    <tr>
                                        <td><a href="{{ route('engagement.show', ['engagement'=>$paiement->engagement->id]) }}">{{ $paiement->n_engage }}</a></td>
                                        <td>{{ $paiement->engagement->l_nmtir }}</td>
                                        <td>{{ $paiement->date_paiement }}</td>
                                        <td>{{ $paiement->engagement->n_devis }}</td>
                                        <td><span class="badge badge-success">{{ number_format($paiement->m_paye, 0, ",", " ") }}</span></td>
                                        <td>
                                            {{ $paiement->user->name }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        {{--<div class="card-footer clearfix">--}}
                            {{--<a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>--}}
                        {{--</div>--}}
                        <!-- /.card-footer -->
                    </div>
                </div>

                {{--<div class="col-md-4">--}}
                    {{--<div class="card card-danger">--}}
                        {{--<div class="card-header">--}}
                            {{--<h3 class="card-title">Engagements par statut - {{ date('Y') }}</h3>--}}

                            {{--<div class="card-tools">--}}
                                {{--<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>--}}
                                {{--</button>--}}
                                {{--<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="chartjs-size-monitor">--}}
                                {{--<div class="chartjs-size-monitor-expand">--}}
                                    {{--<div class=""></div>--}}
                                {{--</div>--}}
                                {{--<div class="chartjs-size-monitor-shrink">--}}
                                    {{--<div class="">--}}

                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<repartition-engagement-statut></repartition-engagement-statut>--}}
                        {{--</div>--}}
                        {{--<!-- /.card-body -->--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-6">--}}
                    {{--<div class="card card-danger">--}}
                        {{--<div class="card-header">--}}
                            {{--<h3 class="card-title">Engagements par année</h3>--}}

                            {{--<div class="card-tools">--}}
                                {{--<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>--}}
                                {{--</button>--}}
                                {{--<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="chart">--}}
                                {{--<engagements-par-annee></engagements-par-annee>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- /.card-body -->--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-6">--}}
                    {{--<div class="card card-danger">--}}
                        {{--<div class="card-header">--}}
                            {{--<h3 class="card-title">Montants par année</h3>--}}

                            {{--<div class="card-tools">--}}
                                {{--<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>--}}
                                {{--</button>--}}
                                {{--<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="position-relative mb-4">--}}
                                {{--<canvas id="sales-chart" height="250"></canvas>--}}
                                {{--<montants-par-annee></montants-par-annee>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- /.card-body -->--}}
                    {{--</div>--}}
                {{--</div>--}}
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
