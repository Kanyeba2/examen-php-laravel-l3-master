@auth
    @php
        $navbarUser = auth()->user();
        $photoUrl = $navbarUser->profile_photo_path
            ? \Illuminate\Support\Facades\Storage::url($navbarUser->profile_photo_path)
            : null;
        $initial = strtoupper(substr((string) $navbarUser->nom, 0, 1));
    @endphp

    <style>
        .navbar-user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .35);
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .1);
            color: #ffffff;
            font-weight: 700;
            font-size: .78rem;
            line-height: 1;
        }

        .navbar-user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>

    <div class="text-white-50 small d-flex align-items-center gap-2">
        <span class="navbar-user-avatar" aria-hidden="true">
            @if($photoUrl)
                <img src="{{ $photoUrl }}" alt="Photo de profil de {{ $navbarUser->nom }}">
            @else
                {{ $initial }}
            @endif
        </span>
        <div class="fw-semibold text-white">{{ $navbarUser->nom }}</div>
        <span class="badge text-bg-info text-uppercase">{{ $navbarUser->role }}</span>
    </div>
@endauth
