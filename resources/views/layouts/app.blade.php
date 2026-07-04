<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopte un ami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Adopte un ami</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            @auth
                @php
                    $unreadCount = auth()->user()->unreadNotifications()->count();
                    $latestNotifications = auth()->user()->notifications()->latest()->take(5)->get();
                @endphp
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item me-lg-2">
                        @include('partials.user-identity')
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn btn-link nav-link position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Notifications
                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $unreadCount }}</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 340px;">
                            @forelse($latestNotifications as $notification)
                                <li class="px-3 py-2 border-bottom">
                                    <div class="fw-semibold small">{{ $notification->data['title'] ?? 'Notification' }}</div>
                                    <div class="small text-muted">{{ $notification->data['message'] ?? '' }}</div>
                                    <div class="mt-1 d-flex gap-2">
                                        @if(!empty($notification->data['url']))
                                            <a href="{{ $notification->data['url'] }}" class="small">Voir</a>
                                        @endif
                                        @if(is_null($notification->read_at))
                                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                                @csrf
                                                <button class="btn btn-link p-0 small">Marquer lue</button>
                                            </form>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="px-3 py-2 text-muted small">Aucune notification.</li>
                            @endforelse
                            <li><hr class="dropdown-divider"></li>
                            <li class="px-3 pb-2">
                                <a href="{{ route('notifications.index') }}" class="small">Toutes les notifications</a>
                            </li>
                        </ul>
                    </li>
                    @role('admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
                    @elserole('manager')
                        <li class="nav-item"><a class="nav-link" href="{{ route('manager.dashboard') }}">Manager</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('payments.index') }}">Paiements</a></li>
                    @endrole
                    <li class="nav-item"><a class="nav-link" href="{{ route('cms.public.index') }}">Conseils</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('animals.index') }}">Animaux</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('profile.show') }}">Profil</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-link nav-link">Déconnexion</button>
                        </form>
                    </li>
                </ul>
            @else
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Inscription</a></li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
<div class="container py-4">
    @include('partials.alerts')
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
