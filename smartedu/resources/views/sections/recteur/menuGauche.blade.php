<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"><span>Menu Principal</span></li>

                <li class="{{ request()->routeIs('recteur.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('recteur.dashboard') }}">
                        <i class="feather-grid"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('recteur.tarifs.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.tarifs.index') }}">
                        <i class="fas fa-file-invoice-dollar"></i> <span>Tarifs & Scolarité</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('recteur.echeances.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.echeances.index') }}">
                        <i class="fas fa-calendar-check"></i> <span>Échéances</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('recteur.transactions.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.transactions.index') }}">
                        <i class="fas fa-exchange-alt"></i> <span>Transactions</span>
                    </a>
                </li>

                <li class="menu-title"><span>Structure</span></li>

                <li class="{{ request()->routeIs('recteur.facultes.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.facultes.index') }}">
                        <i class="fas fa-building"></i> <span>Facultés</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('recteur.departements.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.departements.index') }}">
                        <i class="fas fa-sitemap"></i> <span>Départements</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('recteur.filieres.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.filieres.index') }}">
                        <i class="fas fa-project-diagram"></i> <span>Filières</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('recteur.annees-scolaires.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.annees-scolaires.index') }}">
                        <i class="fas fa-calendar"></i> <span>Années scolaires</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('recteur.semestres.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.semestres.index') }}">
                        <i class="fas fa-calendar-alt"></i> <span>Semestres</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('recteur.ues.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.ues.index') }}">
                        <i class="fas fa-layer-group"></i> <span>UEs</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('recteur.cours.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.cours.index') }}">
                        <i class="fas fa-book-open"></i> <span>Cours</span>
                    </a>
                </li>

                <li class="menu-title"><span>Personnes</span></li>
                <li class="{{ request()->routeIs('recteur.enseignants.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.enseignants.index') }}">
                        <i class="fas fa-chalkboard-teacher"></i> <span>Enseignants</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('recteur.etudiants.*') ? 'active' : '' }}">
                    <a href="{{ route('recteur.etudiants.index') }}">
                        <i class="fas fa-user-graduate"></i> <span>Étudiants</span>
                    </a>
                </li>

                <li class="menu-title"><span>Compte</span></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-recteur-side">@csrf
                        <a href="#" onclick="document.getElementById('logout-recteur-side').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
