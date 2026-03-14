<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"><span>Administration SaaS</span></li>

                <li class="{{ request()->routeIs('super_admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('super_admin.dashboard') }}">
                        <i class="feather-grid"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('super_admin.tenants.*') ? 'active' : '' }}">
                    <a href="{{ route('super_admin.tenants.index') }}">
                        <i class="fas fa-university"></i> <span>Universités</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('super_admin.plans.*') ? 'active' : '' }}">
                    <a href="{{ route('super_admin.plans.index') }}">
                        <i class="fas fa-tags"></i> <span>Plans</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('super_admin.abonnements.*') ? 'active' : '' }}">
                    <a href="{{ route('super_admin.abonnements.index') }}">
                        <i class="fas fa-receipt"></i> <span>Abonnements</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('super_admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('super_admin.users.index') }}">
                        <i class="fas fa-users"></i> <span>Comptes</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('super_admin.logs.*') ? 'active' : '' }}">
                    <a href="{{ route('super_admin.logs.index') }}">
                        <i class="fas fa-shield-alt"></i> <span>Logs</span>
                    </a>
                </li>

                <li class="menu-title"><span>Compte</span></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-sa-side">@csrf
                        <a href="#" onclick="document.getElementById('logout-sa-side').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
