<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Menu Principal</span>
                </li>

                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="feather-grid"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('etudiants.*') ? 'active' : '' }}">
                    <a href="{{ route('etudiants.index') }}">
                        <i class="fas fa-graduation-cap"></i> <span>Étudiants</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('enseignants.*') ? 'active' : '' }}">
                    <a href="{{ route('enseignants.index') }}">
                        <i class="fas fa-chalkboard-teacher"></i> <span>Enseignants</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('classes.*') ? 'active' : '' }}">
                    <a href="{{ route('classes.index') }}">
                        <i class="fas fa-building"></i> <span>Classes</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('cours.*') ? 'active' : '' }}">
                    <a href="{{ route('cours.index') }}">
                        <i class="fas fa-book-reader"></i> <span>Cours</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('evaluations.*') ? 'active' : '' }}">
                    <a href="{{ route('evaluations.index') }}">
                        <i class="fas fa-clipboard-list"></i> <span>Évaluations</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('notes.*') ? 'active' : '' }}">
                    <a href="{{ route('notes.index') }}">
                        <i class="fas fa-star"></i> <span>Notes</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('presences.*') ? 'active' : '' }}">
                    <a href="{{ route('presences.index') }}">
                        <i class="fas fa-calendar-check"></i> <span>Présences</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('paiements.*') ? 'active' : '' }}">
                    <a href="{{ route('paiements.index') }}">
                        <i class="fas fa-file-invoice-dollar"></i> <span>Paiements</span>
                    </a>
                </li>

                <li class="menu-title">
                    <span>Administration</span>
                </li>

                <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-users-cog"></i> <span>Utilisateurs</span>
                    </a>
                </li>

                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <a href="#" onclick="document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                        </a>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</div>
