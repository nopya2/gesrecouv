@extends('admin.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Statistiques</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Statistiques</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <stats-engagements-annee></stats-engagements-annee>
            </div>
            <div class="col-md-6">
                <stats-montants-engages-annee></stats-montants-engages-annee>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <stats-par-statut-annee></stats-par-statut-annee>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection