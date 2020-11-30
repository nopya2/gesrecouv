<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{ asset('theme/admin-lte/dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->formatName() }}</a>
    </div>
</div>

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('home', ['mod' => 'recouvrement']) }}" class="nav-link @isset($page) {{ ($page == 'dashboard') ? 'active' : '' }} @endisset">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Tableau de bord
                    {{--<span class="right badge badge-danger">New</span>--}}
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('factures.index') }}" class="nav-link @isset($page) {{ ($page == 'facture') ? 'active' : '' }} @endisset">
                <i class="nav-icon fas fa-shipping-fast"></i>
                <p>
                    Factures
                    {{--<span class="right badge badge-danger">New</span>--}}
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('clients.index') }}" class="nav-link @isset($page) {{ ($page == 'client') ? 'active' : '' }} @endisset">
                <i class="nav-icon fas fa-shipping-fast"></i>
                <p>
                    Clients
                    {{--<span class="right badge badge-danger">New</span>--}}
                </p>
            </a>
        </li>

        @if(Auth::user()->group->hasPermission('utilisateurs', 'consulter')
            || Auth::user()->group->hasPermission('groupes', 'consulter')
            || Auth::user()->group->hasPermission('chapitres', 'consulter'))
            <li class="nav-header">ADMINISTRATION</li>
            <!-- Users -->
            @if(Auth::user()->group->hasPermission('utilisateurs', 'consulter')
                || Auth::user()->group->hasPermission('groupes', 'consulter'))
            <li class="nav-item has-treeview @isset($page) {{ ($page == 'user' || $page=='module' || $page=='group') ? 'menu-open' : '' }} @endisset">
                <a href="#" class="nav-link @isset($page) {{ ($page == 'user' || $page=='module' || $page=='group') ? 'active' : '' }} @endisset">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Utilisateurs et Groupes
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if(Auth::user()->group->hasPermission('utilisateurs', 'consulter'))
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link @isset($sub_page) {{ ($sub_page == 'user.list') ? 'active' : '' }} @endisset">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Utilisateurs</p>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->group->hasPermission('utilisateurs', 'creer'))
                    <li class="nav-item">
                        <a href="{{ route('user.create') }}" class="nav-link @isset($sub_page) {{ ($sub_page == 'user.create') ? 'active' : '' }} @endisset">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ajouter Utilisateur</p>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->group->hasPermission('groupes', 'consulter'))
                    <li class="nav-item">
                        <a href="{{ route('groups.index') }}" class="nav-link @isset($sub_page) {{ ($sub_page == 'group.list') ? 'active' : '' }} @endisset">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Groupes</p>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('modules.index') }}" class="nav-link @isset($sub_page) {{ ($sub_page == 'module.list') ? 'active' : '' }} @endisset">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Modules</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if(Auth::user()->group->hasPermission('chapitres', 'consulter'))
            <li class="nav-item has-treeview @isset($page) {{ ($page == 'parametre') ? 'menu-open' : '' }} @endisset">
                <a href="#" class="nav-link @isset($page) {{ ($page == 'parametre') ? 'active' : '' }} @endisset">
                    <i class="nav-icon fas fa-wrench"></i>
                    <p>
                        Paramètres
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('types.index') }}" class="nav-link @isset($sub_page) {{ ($sub_page == 'type.list') ? 'active' : '' }} @endisset">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Types de facture</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('modes_paiement.index') }}" class="nav-link @isset($sub_page) {{ ($sub_page == 'mode_paiement.list') ? 'active' : '' }} @endisset">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Modes de paiement</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
        @endif
    </ul>
</nav>
<!-- /.sidebar-menu -->
