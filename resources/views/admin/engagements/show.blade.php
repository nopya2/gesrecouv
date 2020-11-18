@extends('admin.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Engagements</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('engagement.index') }}"></a>Engagements</li>
                        <li class="breadcrumb-item active">Engagement N&deg; {{ $engagement->n_engage }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <!-- Custom Tabs -->
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3">
                            Engagement N&deg; {{ $engagement->n_engage }}
                            @if($engagement->is_paid == true)
                                <span class="right badge badge-success">Payé</span>
                            @endif
                        </h3>
                    </div><!-- /.card-header -->
                    {{--<div class="card-body">--}}
                    {{--</div><!-- /.card-body -->--}}
                </div>
                <!-- ./card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-12">
                <engagement-details :n_engage="'{{ $engagement->n_engage }}'" :engagement_id="'{{ $engagement->id }}'"
                    :modifier="{{ intval(Auth::user()->group->hasPermission('engagements', 'modifier')) }}"
                    :payer="{{ intval(Auth::user()->group->hasPermission('paiements', 'ajouter')) }}"
                    :valider="{{ intval(Auth::user()->group->hasPermission('paiements', 'valider')) }}"
                    :annuler="{{ intval(Auth::user()->group->hasPermission('paiements', 'annuler')) }}"></engagement-details>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('custom_scripts')
    <script>
    </script>
@endpush