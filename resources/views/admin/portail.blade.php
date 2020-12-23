<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>COFIRE ERP</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('theme/admin-lte/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
          <div class="container">
            <a href="../../index3.html" class="navbar-brand">
              <img src="{{ asset('theme/admin-lte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                   style="opacity: .8">
              <span class="brand-text font-weight-light">COFIRE ERP</span>
            </a>
      
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
              
            </div>
      
            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
              <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    {{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                            <img src="{{ asset('theme/admin-lte/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                            <img src="{{ asset('theme/admin-lte/dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                            <img src="{{ asset('theme/admin-lte/dist/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div> --}}
                </li>
              <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    {{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div> --}}
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1"
                        href="#" data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        class="nav-link dropdown-toggle">{{ Auth::user()->firstname }}</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                    <li><a href="#" class="dropdown-item">Documentation </a></li>
        
                    <li class="dropdown-divider"></li>
        
                    <!-- Level two dropdown-->
                    <li onclick="document.getElementById('logout-form').submit();">
                        <a href="#" class="dropdown-item text-danger">Déconnexion <i class="fas fa-arrow-alt-circle-right"></i></a>
                        <form action="{{ route('logout') }}" method="post" id="logout-form">
                            @csrf
                            {{-- <button type="submit" class="btn btn-sm btn-danger" title="Se deconnecter" onclick="logout()">
                                <i class="fa fa-arrow-alt-circle-right"></i>
                            </button> --}}
                        </form>
                    </li>
                    </ul>
                </li>
            </ul>
          </div>
        </nav>
        <!-- /.navbar -->
      
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            
            <div class="content-header">
                @if ($message = Session::get('welcome'))
                <div class="container">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-info"></i> Bienvenue!</h5>
                        COFIRE ERP, Application de gestion de la Direction Financière
                    </div>
                </div><!-- /.container-fluid -->
                @endif
            </div>
           
          <!-- /.content-header -->
      
          <!-- Main content -->
          <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><i class="fas fa-comments-dollar"></i> Recouvrement</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="{{  route('home', ['mod'=>'recouvrement']) }}" class="btn btn-primary text-lg">Accéder</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-success"><i class="fas fa-file-invoice"></i> Facturation</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-success text-lg">Accéder</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-warning"><i class="fas fa-calculator"></i> Comptabilité</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-warning text-lg">Accéder</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-info"><i class="fas fa-wallet"></i> Finance</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-info text-lg">Accéder</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-danger"><i class="fas fa-users-cog"></i> Utilisateurs & Groupes</h5>
                            <p class="card-text">Gestion des utilisateurs, des groupes et des permissions.</p>
                            <a href="#" class="btn btn-danger text-lg">Accéder</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-secondary"><i class="fas fa-cogs"></i> Paramètres</h5>
                            <p class="card-text">Configurations, Paramètres globaux, Notifications.</p>
                            <a href="#" class="btn btn-secondary text-lg">Accéder</a>
                        </div>
                        </div>
                    </div>
                </div>
              
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
      
        <!-- Control Sidebar -->
        {{-- <aside class="control-sidebar control-sidebar-dark">
          <!-- Control sidebar content goes here -->
          <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
          </div>
        </aside> --}}
        <!-- /.control-sidebar -->
      
        <!-- Main Footer -->
        <footer class="main-footer">
          <!-- To the right -->
          {{-- <div class="float-right d-none d-sm-inline">
            Anything you want
          </div> --}}
          <!-- Default to the left -->
          <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
      </div>
      <!-- ./wrapper -->
      
      <!-- REQUIRED SCRIPTS -->
      
      <!-- jQuery -->
      <script src="{{ asset('theme/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
      <!-- Bootstrap 4 -->
      <script src="{{ asset('theme/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <!-- AdminLTE App -->
      <script src="{{ asset('theme/admin-lte/dist/js/adminlte.min.js') }}"></script>

</body>
</html>
