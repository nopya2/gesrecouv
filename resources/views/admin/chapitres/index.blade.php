@extends('admin.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Paramètres - Chapitres</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Paramètres</li>
                        <li class="breadcrumb-item active">Chapitres</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Chapitres</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if(session()->get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Succès!</strong> {{ session()->get('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                        @endif
                        <chapitres></chapitres>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('custom_scripts')
    <script>

    </script>
@endpush
