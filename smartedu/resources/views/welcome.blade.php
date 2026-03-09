<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>SmartEdu - Connexion</title>

<link rel="shortcut icon" href="{{ asset('templates/assets/img/favicon.png') }}">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('templates/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('templates/assets/plugins/feather/feather.css') }}">
<link rel="stylesheet" href="{{ asset('templates/assets/plugins/icons/flags/flags.css') }}">
<link rel="stylesheet" href="{{ asset('templates/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('templates/assets/plugins/fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('templates/assets/css/style.css') }}">
</head>
<body>

<div class="main-wrapper login-body">
<div class="login-wrapper">
<div class="container">
<div class="loginbox">
<div class="login-left">
    <img class="img-fluid" src="{{ asset('templates/assets/img/login.png') }}" alt="Logo">
</div>
<div class="login-right">
<div class="login-right-wrap">
    <h1>Bienvenue sur SmartEdu</h1>
    <h2>Connexion</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Email <span class="login-danger">*</span></label>
            <input class="form-control @error('email') is-invalid @enderror"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus>
            <span class="profile-views"><i class="fas fa-envelope"></i></span>
        </div>
        <div class="form-group">
            <label>Mot de passe <span class="login-danger">*</span></label>
            <input class="form-control pass-input @error('password') is-invalid @enderror"
                   type="password"
                   name="password"
                   required>
            <span class="profile-views feather-eye toggle-password"></span>
        </div>
        <div class="forgotpass">
            <div class="remember-me">
                <label class="custom_check mr-2 mb-0 d-inline-flex remember-me">Se souvenir de moi
                    <input type="checkbox" name="remember">
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">Se connecter</button>
        </div>
    </form>

</div>
</div>
</div>
</div>
</div>
</div>

<script src="{{ asset('templates/assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('templates/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('templates/assets/js/feather.min.js') }}"></script>
<script src="{{ asset('templates/assets/js/script.js') }}"></script>
</body>
</html>
