<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartEdu — Connexion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Variables & base ─────────────────────────────────────────── */
        :root {
            --brand: #6366f1;
            --brand-dark: #4f46e5;
        }

        /* Particules flottantes */
        @keyframes float-up {
            0%   { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10%  { opacity: .6; }
            90%  { opacity: .6; }
            100% { transform: translateY(-120px) rotate(720deg); opacity: 0; }
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            animation: float-up linear infinite;
            pointer-events: none;
        }

        /* Shake sur erreur */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
        .shake { animation: shake .4s ease; }

        /* Pulse bouton submit */
        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(99,102,241,.5); }
            70%  { box-shadow: 0 0 0 12px rgba(99,102,241,0); }
            100% { box-shadow: 0 0 0 0 rgba(99,102,241,0); }
        }
        .btn-submit:not(:disabled):hover { animation: pulse-ring 1.2s infinite; }

        /* Input focus line */
        .input-field {
            transition: border-color .25s, box-shadow .25s;
        }
        .input-field:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(99,102,241,.18);
        }

        /* Logo pulsation */
        @keyframes logo-pop {
            0%, 100% { transform: scale(1); }
            50%       { transform: scale(1.06); }
        }
        .logo-icon { animation: logo-pop 3s ease-in-out infinite; }

        /* Slide-in carte */
        @keyframes slide-in {
            from { opacity: 0; transform: translateY(28px) scale(.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .card-login { animation: slide-in .55s cubic-bezier(.22,1,.36,1) both; }

        /* Gradient BG animé */
        @keyframes bg-shift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animated-bg {
            background: linear-gradient(-45deg, #0f172a, #1e1b4b, #312e81, #1e40af, #0f172a);
            background-size: 400% 400%;
            animation: bg-shift 12s ease infinite;
        }
        .dark .animated-bg {
            background: linear-gradient(-45deg, #020617, #0f0c29, #1e1b4b, #0f172a, #020617);
            background-size: 400% 400%;
            animation: bg-shift 12s ease infinite;
        }

        /* Toggle thumb */
        #theme-toggle:checked ~ label .toggle-thumb {
            transform: translateX(1.5rem);
            background-color: #fbbf24;
        }
    </style>
</head>

{{-- La classe "dark" est gérée via JS sur <html> --}}
<body class="h-full min-h-screen relative overflow-hidden bg-slate-900 dark:bg-gray-950 transition-colors duration-300">

    {{-- ── Background animé ──────────────────────────────────────────────── --}}
    <div class="animated-bg absolute inset-0 z-0"></div>

    {{-- ── Particules ────────────────────────────────────────────────────── --}}
    <div id="particles" class="absolute inset-0 z-[1] overflow-hidden pointer-events-none"></div>

    {{-- ── Grille décorative (glassmorphism) ────────────────────────────── --}}
    <div class="absolute inset-0 z-[1] opacity-10"
         style="background-image: linear-gradient(rgba(255,255,255,.07) 1px, transparent 1px),
                                  linear-gradient(90deg, rgba(255,255,255,.07) 1px, transparent 1px);
                background-size: 40px 40px;">
    </div>

    {{-- ── Blobs décoratifs ─────────────────────────────────────────────── --}}
    <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full opacity-20 z-[1]"
         style="background: radial-gradient(circle, #818cf8, transparent 70%); filter: blur(60px);">
    </div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full opacity-20 z-[1]"
         style="background: radial-gradient(circle, #38bdf8, transparent 70%); filter: blur(60px);">
    </div>

    {{-- ── Toggle Dark/Light ─────────────────────────────────────────────── --}}
    <div class="absolute top-5 right-5 z-50 flex items-center gap-2">
        <span class="text-xs text-white/60 font-medium select-none" id="theme-label">Mode sombre</span>
        <button id="theme-btn"
                onclick="toggleTheme()"
                class="relative w-12 h-6 rounded-full bg-white/20 backdrop-blur border border-white/20
                       flex items-center px-1 cursor-pointer transition-all duration-300 hover:bg-white/30"
                title="Basculer le thème">
            {{-- Thumb --}}
            <span id="theme-thumb"
                  class="w-4 h-4 rounded-full bg-yellow-400 shadow-md transition-all duration-300 flex items-center justify-center text-[8px]">
                ☀️
            </span>
        </button>
    </div>

    {{-- ── Carte principale ──────────────────────────────────────────────── --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="card-login w-full max-w-md">

            {{-- Glassmorphism card --}}
            <div class="rounded-3xl p-8 sm:p-10
                        bg-white/10 dark:bg-white/5
                        backdrop-blur-xl
                        border border-white/20 dark:border-white/10
                        shadow-2xl shadow-black/40">

                {{-- ── Logo & titre ──────────────────────────────────────── --}}
                <div class="text-center mb-8">
                    {{-- Logo animé --}}
                    <div class="logo-icon inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-4
                                bg-gradient-to-br from-indigo-500 to-violet-600
                                shadow-lg shadow-indigo-500/40">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 14l6.16-3.422A12.083 12.083 0 0112 21a12.083 12.083 0 01-6.16-10.422L12 14z"/>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-bold text-white tracking-tight">SmartEdu</h1>
                    <p class="mt-1 text-sm text-white/50">Plateforme de gestion universitaire</p>
                </div>

                {{-- ── Erreur globale ──────────────────────────────────────── --}}
                @if ($errors->any())
                    <div id="error-banner"
                         class="shake mb-5 flex items-start gap-3 rounded-xl px-4 py-3
                                bg-red-500/20 border border-red-400/40 text-red-200 text-sm">
                        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><circle cx="12" cy="16" r="1" fill="currentColor"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- ── Formulaire ──────────────────────────────────────────── --}}
                <form id="login-form" method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    {{-- Email --}}
                    <div class="mb-5">
                        <label for="email" class="block text-xs font-semibold text-white/70 uppercase tracking-widest mb-2">
                            Adresse email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4.5 h-4.5 text-white/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   placeholder="vous@universite.edu"
                                   class="input-field w-full pl-10 pr-4 py-3 rounded-xl text-sm text-white
                                          bg-white/10 border border-white/20
                                          placeholder-white/30
                                          @error('email') border-red-400/60 @enderror">
                        </div>
                    </div>

                    {{-- Mot de passe --}}
                    <div class="mb-6">
                        <label for="password" class="block text-xs font-semibold text-white/70 uppercase tracking-widest mb-2">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4.5 h-4.5 text-white/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path stroke-linecap="round" d="M7 11V7a5 5 0 0110 0v4"/>
                                </svg>
                            </div>
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="input-field w-full pl-10 pr-12 py-3 rounded-xl text-sm text-white
                                          bg-white/10 border border-white/20
                                          placeholder-white/30
                                          @error('password') border-red-400/60 @enderror">
                            {{-- Toggle visibilité --}}
                            <button type="button"
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-white/40 hover:text-white/80 transition-colors">
                                <svg id="eye-icon" class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Se souvenir + lien oublié --}}
                    <div class="flex items-center justify-between mb-7">
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="remember" id="remember" class="sr-only peer">
                                <div class="w-4 h-4 rounded border border-white/30 bg-white/10
                                            peer-checked:bg-indigo-500 peer-checked:border-indigo-500
                                            transition-all duration-200 flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white hidden peer-checked:block" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                </div>
                            </div>
                            <span class="text-xs text-white/60 group-hover:text-white/80 transition-colors select-none">
                                Se souvenir de moi
                            </span>
                        </label>
                    </div>

                    {{-- Bouton submit --}}
                    <button type="submit"
                            id="submit-btn"
                            class="btn-submit w-full py-3.5 rounded-xl font-semibold text-sm text-white
                                   bg-gradient-to-r from-indigo-500 to-violet-600
                                   hover:from-indigo-400 hover:to-violet-500
                                   active:scale-[.98]
                                   transition-all duration-200
                                   flex items-center justify-center gap-2
                                   disabled:opacity-60 disabled:cursor-not-allowed">
                        <span id="btn-text">Se connecter</span>
                        <svg id="btn-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        <svg id="btn-arrow" class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </form>

                {{-- ── Footer ──────────────────────────────────────────────── --}}
                <div class="mt-8 pt-6 border-t border-white/10 text-center">
                    <p class="text-xs text-white/30">
                        &copy; {{ date('Y') }} SmartEdu — Tous droits réservés
                    </p>
                    <div class="mt-3 flex items-center justify-center gap-1.5">
                        <span class="inline-flex items-center gap-1 text-xs text-white/25">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            Connexion sécurisée SSL
                        </span>
                    </div>
                </div>
            </div>

            {{-- Badge rôles (démo) --}}
            <div class="mt-5 flex flex-wrap justify-center gap-2">
                @foreach(['Super Admin', 'Recteur', 'Doyen', 'Chef Dpt', 'Enseignant', 'Étudiant'] as $role)
                    <span class="px-2.5 py-1 text-[10px] font-medium rounded-full
                                 bg-white/8 border border-white/15 text-white/45 backdrop-blur-sm
                                 hover:bg-white/15 hover:text-white/70 transition-all duration-200 cursor-default">
                        {{ $role }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Scripts ────────────────────────────────────────────────────────── --}}
    <script>
        /* ── Dark / Light mode ─────────────────────────────────────────── */
        const html       = document.documentElement;
        const btn        = document.getElementById('theme-btn');
        const thumb      = document.getElementById('theme-thumb');
        const label      = document.getElementById('theme-label');
        let isDark       = true; // Défaut : dark

        // Init depuis localStorage
        if (localStorage.getItem('theme') === 'light') {
            isDark = false;
            applyTheme();
        }

        function toggleTheme() {
            isDark = !isDark;
            applyTheme();
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        function applyTheme() {
            if (isDark) {
                html.classList.add('dark');
                thumb.textContent = '☀️';
                thumb.style.transform = 'translateX(0)';
                label.textContent = 'Mode sombre';
            } else {
                html.classList.remove('dark');
                thumb.textContent = '🌙';
                thumb.style.transform = 'translateX(1.5rem)';
                label.textContent = 'Mode clair';
                // Adapter le fond en mode clair
                document.body.style.background = '';
            }
        }

        /* ── Toggle visibilité mot de passe ───────────────────────────── */
        function togglePassword() {
            const pwd  = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>`;
            } else {
                pwd.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
            }
        }

        /* ── Loading state sur submit ──────────────────────────────────── */
        document.getElementById('login-form').addEventListener('submit', function () {
            const btn     = document.getElementById('submit-btn');
            const text    = document.getElementById('btn-text');
            const spinner = document.getElementById('btn-spinner');
            const arrow   = document.getElementById('btn-arrow');

            btn.disabled     = true;
            text.textContent = 'Connexion...';
            spinner.classList.remove('hidden');
            arrow.classList.add('hidden');
        });

        /* ── Particules flottantes ─────────────────────────────────────── */
        (function spawnParticles() {
            const container = document.getElementById('particles');
            const colors = ['#818cf8','#a78bfa','#38bdf8','#34d399','#fb7185'];

            function createParticle() {
                const p = document.createElement('div');
                p.classList.add('particle');

                const size    = Math.random() * 6 + 2;
                const left    = Math.random() * 100;
                const delay   = Math.random() * 8;
                const dur     = Math.random() * 12 + 10;
                const color   = colors[Math.floor(Math.random() * colors.length)];
                const opacity = Math.random() * .4 + .15;

                p.style.cssText = `
                    width: ${size}px; height: ${size}px;
                    left: ${left}%;
                    bottom: -20px;
                    background: ${color};
                    opacity: ${opacity};
                    animation-duration: ${dur}s;
                    animation-delay: ${delay}s;
                    filter: blur(${size > 5 ? 1 : 0}px);
                `;
                container.appendChild(p);

                setTimeout(() => p.remove(), (dur + delay) * 1000);
            }

            // Créer 30 particules initiales + interval
            for (let i = 0; i < 30; i++) createParticle();
            setInterval(createParticle, 600);
        })();

        /* ── Checkbox custom (accessibilité) ───────────────────────────── */
        document.getElementById('remember').addEventListener('change', function () {
            const box = this.nextElementSibling;
            const check = box.querySelector('svg');
            if (this.checked) {
                box.classList.add('bg-indigo-500', 'border-indigo-500');
                check.classList.remove('hidden');
            } else {
                box.classList.remove('bg-indigo-500', 'border-indigo-500');
                check.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
