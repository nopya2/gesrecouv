<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestion du recouvrement | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/toastr/toastr.min.css') }}">
    <!-- Ion Slider -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/ion-rangeslider/css/ion.rangeSlider.min.css') }}">
    <!-- bootstrap slider -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/bootstrap-slider/css/bootstrap-slider.min.css') }}">
    <!-- Bootstrap MultiSelect -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-multiselect-master/dist/css/bootstrap-multiselect.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/dist/css/adminlte.min.css') }}">
    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            {{--<li class="nav-item d-none d-sm-inline-block">--}}
                {{--<a href="index3.html" class="nav-link">Home</a>--}}
            {{--</li>--}}
            {{--<li class="nav-item d-none d-sm-inline-block">--}}
                {{--<a href="#" class="nav-link">Contact</a>--}}
            {{--</li>--}}
        </ul>

        <!-- SEARCH FORM -->
        {{--<form class="form-inline ml-3">--}}
            {{--<div class="input-group input-group-sm">--}}
                {{--<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">--}}
                {{--<div class="input-group-append">--}}
                    {{--<button class="btn btn-navbar" type="submit">--}}
                        {{--<i class="fas fa-search"></i>--}}
                    {{--</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</form>--}}

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            {{--<li class="nav-item dropdown">--}}
                {{--<a class="nav-link" data-toggle="dropdown" href="#">--}}
                    {{--<i class="far fa-comments"></i>--}}
                    {{--<span class="badge badge-danger navbar-badge">3</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<!-- Message Start -->--}}
                        {{--<div class="media">--}}
                            {{--<img src="{{ asset('theme/admin-lte/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">--}}
                            {{--<div class="media-body">--}}
                                {{--<h3 class="dropdown-item-title">--}}
                                    {{--Brad Diesel--}}
                                    {{--<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>--}}
                                {{--</h3>--}}
                                {{--<p class="text-sm">Call me whenever you can...</p>--}}
                                {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- Message End -->--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<!-- Message Start -->--}}
                        {{--<div class="media">--}}
                            {{--<img src="{{ asset('theme/admin-lte/dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
                            {{--<div class="media-body">--}}
                                {{--<h3 class="dropdown-item-title">--}}
                                    {{--John Pierce--}}
                                    {{--<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>--}}
                                {{--</h3>--}}
                                {{--<p class="text-sm">I got your message bro</p>--}}
                                {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- Message End -->--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<!-- Message Start -->--}}
                        {{--<div class="media">--}}
                            {{--<img src="{{ asset('theme/admin-lte/dist/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
                            {{--<div class="media-body">--}}
                                {{--<h3 class="dropdown-item-title">--}}
                                    {{--Nora Silvester--}}
                                    {{--<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>--}}
                                {{--</h3>--}}
                                {{--<p class="text-sm">The subject goes here</p>--}}
                                {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- Message End -->--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>--}}
                {{--</div>--}}
            {{--</li>--}}
            <!-- Notifications Dropdown Menu -->
            {{--<li class="nav-item dropdown">--}}
                {{--<a class="nav-link" data-toggle="dropdown" href="#">--}}
                    {{--<i class="far fa-bell"></i>--}}
                    {{--<span class="badge badge-warning navbar-badge">15</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
                    {{--<span class="dropdown-item dropdown-header">15 Notifications</span>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<i class="fas fa-envelope mr-2"></i> 4 new messages--}}
                        {{--<span class="float-right text-muted text-sm">3 mins</span>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<i class="fas fa-users mr-2"></i> 8 friend requests--}}
                        {{--<span class="float-right text-muted text-sm">12 hours</span>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item">--}}
                        {{--<i class="fas fa-file mr-2"></i> 3 new reports--}}
                        {{--<span class="float-right text-muted text-sm">2 days</span>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
                {{--</div>--}}
            {{--</li>--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">--}}
                    {{--<i class="fas fa-th-large"></i>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="post" id="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger" title="Se deconnecter" onclick="logout()">
                        <i class="fa fa-arrow-alt-circle-right"></i>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="brand-link">
            <img src="{{ asset('theme/admin-lte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">GesRECOUV</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            @include('admin.recouvrement.sidebar')
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2020-{{ (new \DateTime())->format('Y') }} <a href="http://aninf.ga">ANINF</a>.</strong>
        Tous droits reservés.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('theme/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('theme/admin-lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('theme/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('theme/admin-lte/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('theme/admin-lte/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('theme/admin-lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('theme/admin-lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('theme/admin-lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('theme/admin-lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('theme/admin-lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('theme/admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('theme/admin-lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('theme/admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('theme/admin-lte/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('theme/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('theme/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('theme/admin-lte/plugins/toastr/toastr.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('theme/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('theme/admin-lte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ asset('theme/admin-lte/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('theme/admin-lte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('theme/admin-lte/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- Ion Slider -->
<script src="{{ asset('theme/admin-lte/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<!-- Bootstrap slider -->
<script src="{{ asset('theme/admin-lte/plugins/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
<!-- Bootstrap MultiSelect -->
<script src="{{ asset('library/bootstrap-multiselect-master/dist/js/bootstrap-multiselect.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('theme/admin-lte/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="{{ asset('theme/admin-lte/dist/js/pages/dashboard.js') }}"></script>--}}
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('theme/admin-lte/dist/js/demo.js') }}"></script>
@stack('custom_scripts')
<script src="{{ asset('js/app.js') }}"></script>

<script>
    function logout(){
        window.localStorage.removeItem('authUser');
        window.localStorage.clear()
    }
</script>
</body>
</html>
