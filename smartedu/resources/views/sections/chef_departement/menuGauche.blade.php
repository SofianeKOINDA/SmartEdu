<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"><span>Mon espace</span></li>

                <li class="{{ request()->routeIs('chef_departement.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('chef_departement.dashboard') }}">
                        <i class="feather-grid"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><span>Gestion</span></li>

                <li class="{{ request()->routeIs('chef_departement.promotions.*') ? 'active' : '' }}">
                    <a href="{{ route('chef_departement.promotions.index') }}">
                        <i class="fas fa-users"></i> <span>Promotions</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('chef_departement.etudiants.*') ? 'active' : '' }}">
                    <a href="{{ route('chef_departement.etudiants.index') }}">
                        <i class="fas fa-user-graduate"></i> <span>Étudiants</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('chef_departement.enseignants.*') ? 'active' : '' }}">
                    <a href="{{ route('chef_departement.enseignants.index') }}">
                        <i class="fas fa-chalkboard-teacher"></i> <span>Enseignants</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('chef_departement.filieres.*') ? 'active' : '' }}">
                    <a href="{{ route('chef_departement.filieres.index') }}">
                        <i class="fas fa-sitemap"></i> <span>Filières</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('chef_departement.ues.*') ? 'active' : '' }}">
                    <a href="{{ route('chef_departement.ues.index') }}">
                        <i class="fas fa-layer-group"></i> <span>UEs</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('chef_departement.cours.*') ? 'active' : '' }}">
                    <a href="{{ route('chef_departement.cours.index') }}">
                        <i class="fas fa-book-open"></i> <span>Cours</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('chef_departement.seances.*') ? 'active' : '' }}">
                    <a href="{{ route('chef_departement.seances.index') }}">
                        <i class="fas fa-clock"></i> <span>Séances</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('chef_departement.emploi_du_temps.*') ? 'active' : '' }}">
                    <a href="{{ route('chef_departement.emploi_du_temps.index') }}">
                        <i class="fas fa-calendar-alt"></i> <span>Emploi du temps</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('chef_departement.demandes.*') ? 'active' : '' }}">
                    <a href="{{ route('chef_departement.demandes.index') }}">
                        <i class="fas fa-envelope-open-text"></i> <span>Demandes étudiantes</span>
                    </a>
                </li>

                <li class="menu-title"><span>Compte</span></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-chef-side">@csrf
                        <a href="#" onclick="document.getElementById('logout-chef-side').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
