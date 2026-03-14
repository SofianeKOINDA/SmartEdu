<div class="header">
    <div class="header-left">
        <a href="{{ route('chef_departement.seances.index') }}" class="logo"><img src="{{ asset('templates/assets/img/logo.png') }}" alt="Logo"></a>
        <a href="{{ route('chef_departement.seances.index') }}" class="logo logo-small"><img src="{{ asset('templates/assets/img/logo-small.png') }}" alt="Logo" width="30" height="30"></a>
    </div>
    <div class="menu-toggle"><a href="javascript:void(0);" id="toggle_btn"><i class="fas fa-bars"></i></a></div>
    <a class="mobile_btn" id="mobile_btn"><i class="fas fa-bars"></i></a>
    <ul class="nav user-menu">
        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="{{ asset('templates/assets/img/profiles/avatar-01.jpg') }}" width="31" alt="">
                    <div class="user-text">
                        <h6>{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</h6>
                        <p class="text-muted mb-0">Chef de département</p>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <form action="{{ route('logout') }}" method="POST" id="logout-chef">@csrf
                    <a class="dropdown-item" href="#" onclick="document.getElementById('logout-chef').submit();">
                        <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                    </a>
                </form>
            </div>
        </li>
    </ul>
</div>
