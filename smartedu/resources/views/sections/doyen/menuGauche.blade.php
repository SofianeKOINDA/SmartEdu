<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"><span>Mon espace</span></li>

                <li class="{{ request()->routeIs('doyen.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('doyen.dashboard') }}">
                        <i class="feather-grid"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><span>Gestion</span></li>

                <li class="{{ request()->routeIs('doyen.facultes.*') ? 'active' : '' }}">
                    <a href="{{ route('doyen.facultes.index') }}">
                        <i class="fas fa-building"></i> <span>Facultés</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('doyen.departements.*') ? 'active' : '' }}">
                    <a href="{{ route('doyen.departements.index') }}">
                        <i class="fas fa-sitemap"></i> <span>Départements</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('doyen.enseignants.*') ? 'active' : '' }}">
                    <a href="{{ route('doyen.enseignants.index') }}">
                        <i class="fas fa-chalkboard-teacher"></i> <span>Enseignants</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('doyen.etudiants.*') ? 'active' : '' }}">
                    <a href="{{ route('doyen.etudiants.index') }}">
                        <i class="fas fa-user-graduate"></i> <span>Étudiants</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('doyen.deliberations.*') ? 'active' : '' }}">
                    <a href="{{ route('doyen.deliberations.index') }}">
                        <i class="fas fa-gavel"></i> <span>Délibérations</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('doyen.demandes.*') ? 'active' : '' }}">
                    <a href="{{ route('doyen.demandes.index') }}">
                        <i class="fas fa-envelope-open-text"></i> <span>Demandes</span>
                    </a>
                </li>

                <li class="menu-title"><span>Compte</span></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-doyen-side">@csrf
                        <a href="#" onclick="document.getElementById('logout-doyen-side').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
