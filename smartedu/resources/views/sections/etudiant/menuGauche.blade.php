<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li class="menu-title"><span>Menu Principal</span></li>

                <li class="{{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.dashboard') }}">
                        <i class="feather-grid"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><span>Mon Espace</span></li>

                <li class="{{ request()->routeIs('etudiant.cours') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.cours') }}">
                        <i class="fas fa-book-reader"></i> <span>Mes Cours</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.notes') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.notes') }}">
                        <i class="fas fa-star"></i> <span>Mes Notes</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.presences') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.presences') }}">
                        <i class="fas fa-calendar-check"></i> <span>Mes Présences</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.paiements') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.paiements') }}">
                        <i class="fas fa-file-invoice-dollar"></i> <span>Mes Paiements</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiant.classe') ? 'active' : '' }}">
                    <a href="{{ route('etudiant.classe') }}">
                        <i class="fas fa-users"></i> <span>Ma Classe</span>
                    </a>
                </li>

                <li class="menu-title"><span>Compte</span></li>

                <li>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#profilModal">
                        <i class="fas fa-user-edit"></i> <span>Modifier mon profil</span>
                    </a>
                </li>

                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-etudiant-form">
                        @csrf
                        <a href="#" onclick="document.getElementById('logout-etudiant-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                        </a>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</div>
