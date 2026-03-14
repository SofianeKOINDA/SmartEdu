<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"><span>Mon espace</span></li>

                <li class="{{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('enseignant.dashboard') }}">
                        <i class="feather-grid"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('enseignant.cours.*') || request()->routeIs('enseignant.evaluations.*') || request()->routeIs('enseignant.presences.*') || request()->routeIs('enseignant.notes.*') ? 'active' : '' }}">
                    <a href="{{ route('enseignant.cours.index') }}">
                        <i class="fas fa-book-reader"></i> <span>Mes cours</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('enseignant.emploi_du_temps.*') ? 'active' : '' }}">
                    <a href="{{ route('enseignant.emploi_du_temps.index') }}">
                        <i class="fas fa-calendar-alt"></i> <span>Mon emploi du temps</span>
                    </a>
                </li>

                <li class="menu-title"><span>Compte</span></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-ens-side">@csrf
                        <a href="#" onclick="document.getElementById('logout-ens-side').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
