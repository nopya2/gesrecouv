@extends('layouts.recouvrement')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Clients - Détails | <span class="text-sm">{{ $client->raison_sociale }}</span></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
                        <li class="breadcrumb-item active">Détails [{{ $client->id }}]</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <client-edit :client_id="{{ $client->id }}"></client-edit>
    </section>
    <!-- /.content -->
@endsection

@push('custom_scripts')
    <script>

    </script>
@endpush
