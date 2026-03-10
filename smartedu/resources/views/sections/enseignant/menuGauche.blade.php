<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li class="menu-title"><span>Menu Principal</span></li>

                <li class="{{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('enseignant.dashboard') }}">
                        <i class="feather-grid"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><span>Mon Espace</span></li>

                <li class="{{ request()->routeIs('enseignant.cours') ? 'active' : '' }}">
                    <a href="{{ route('enseignant.cours') }}">
                        <i class="fas fa-book-reader"></i> <span>Mes Cours</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('enseignant.evaluations') ? 'active' : '' }}">
                    <a href="{{ route('enseignant.evaluations') }}">
                        <i class="fas fa-clipboard-list"></i> <span>Mes Évaluations</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('enseignant.notes') ? 'active' : '' }}">
                    <a href="{{ route('enseignant.notes') }}">
                        <i class="fas fa-star"></i> <span>Mes Notes</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('enseignant.presences') ? 'active' : '' }}">
                    <a href="{{ route('enseignant.presences') }}">
                        <i class="fas fa-calendar-check"></i> <span>Mes Présences</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('enseignant.classes') ? 'active' : '' }}">
                    <a href="{{ route('enseignant.classes') }}">
                        <i class="fas fa-school"></i> <span>Mes Classes</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('enseignant.etudiants') ? 'active' : '' }}">
                    <a href="{{ route('enseignant.etudiants') }}">
                        <i class="fas fa-graduation-cap"></i> <span>Mes Étudiants</span>
                    </a>
                </li>

                <li class="menu-title"><span>Compte</span></li>

                <li>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#profilModal">
                        <i class="fas fa-user-edit"></i> <span>Modifier mon profil</span>
                    </a>
                </li>

                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-enseignant-form">
                        @csrf
                        <a href="#" onclick="document.getElementById('logout-enseignant-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                        </a>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</div>
