<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"><span>Mon espace</span></li>

                <li class="{{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.dashboard') }}">
                        <i class="feather-grid"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.cours.*') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.cours.index') }}">
                        <i class="fas fa-book-open"></i> <span>Mes cours</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.emploi_du_temps.*') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.emploi_du_temps.index') }}">
                        <i class="fas fa-calendar-alt"></i> <span>Mon emploi du temps</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.notes.*') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.notes.index') }}">
                        <i class="fas fa-star"></i> <span>Mes notes</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.evaluations.*') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.evaluations.index') }}">
                        <i class="fas fa-clipboard-list"></i> <span>Mes évaluations</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.presences.*') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.presences.index') }}">
                        <i class="fas fa-calendar-check"></i> <span>Mes présences</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.echeances.*') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.echeances.index') }}">
                        <i class="fas fa-file-invoice-dollar"></i> <span>Mes paiements</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.demandes.*') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.demandes.index') }}">
                        <i class="fas fa-envelope-open-text"></i> <span>Mes demandes</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.resultats.*') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.resultats.index') }}">
                        <i class="fas fa-trophy"></i> <span>Mes résultats</span>
                    </a>
                </li>

                <li class="menu-title"><span>Compte</span></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-etu-side">@csrf
                        <a href="#" onclick="document.getElementById('logout-etu-side').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
