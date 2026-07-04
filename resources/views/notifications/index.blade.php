@extends('layouts.app')

@section('content')
<style>
    .notifications-coquille {
        background: #f7f9f8;
        border: 1px solid #e5ece7;
        border-radius: 16px;
        padding: 1rem;
    }

    .notifications-entete {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: .8rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .notifications-titre {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .notifications-sous-titre {
        color: #5c6a62;
        margin: .15rem 0 0;
        font-size: .92rem;
    }

    .notifications-stats-resume {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .pastille-stat {
        border: 1px solid #d8e3da;
        border-radius: 999px;
        padding: .25rem .65rem;
        font-size: .78rem;
        font-weight: 600;
        background: #fff;
        color: #405045;
    }

    .pastille-stat.non-lue {
        background: #e8f5eb;
        border-color: #cce5d2;
        color: #246238;
    }

    .liste-notifications {
        display: grid;
        gap: .7rem;
    }

    .element-notification {
        border: 1px solid #dee8e0;
        border-radius: 12px;
        padding: .85rem .95rem;
        background: #fff;
        box-shadow: 0 2px 8px rgba(27, 40, 31, .05);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: .8rem;
    }

    .element-notification.non-lue {
        border-color: #b9dec4;
        background: linear-gradient(180deg, #f6fff8 0%, #ffffff 100%);
    }

    .titre-notification {
        font-weight: 700;
        color: #1d2b21;
    }

    .message-notification {
        color: #4d5e53;
        margin-top: .2rem;
        font-size: .92rem;
    }

    .meta-notification {
        color: #74837a;
        font-size: .8rem;
        margin-top: .3rem;
    }

    .actions-notification {
        display: flex;
        align-items: center;
        gap: .45rem;
        flex-wrap: wrap;
    }

    .etat-vide {
        border: 1px dashed #cedbcf;
        border-radius: 12px;
        background: #fbfdfb;
        padding: 1.2rem;
        color: #5a675e;
        text-align: center;
    }

    @media (max-width: 767px) {
        .notifications-titre { font-size: 1.6rem; }
        .element-notification {
            flex-direction: column;
            align-items: stretch;
        }
        .actions-notification {
            justify-content: flex-start;
        }
    }
</style>

<div class="notifications-coquille">
    <div class="notifications-entete">
        <div>
            <h2 class="notifications-titre">Notifications</h2>
            <p class="notifications-sous-titre">Suivez les mises a jour de vos demandes, paiements et actions importantes.</p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="notifications-stats-resume">
                <span class="pastille-stat">{{ $totalCount }} total</span>
                <span class="pastille-stat non-lue">{{ $unreadCount }} non lue(s)</span>
            </div>
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm" {{ $unreadCount === 0 ? 'disabled' : '' }}>Tout marquer comme lu</button>
            </form>
        </div>
    </div>

    @if($notifications->isEmpty())
        <div class="etat-vide">Aucune notification pour le moment.</div>
    @else
        <div class="liste-notifications">
            @foreach($notifications as $notification)
                @php
                    $estNonLue = is_null($notification->read_at);
                @endphp
                <article class="element-notification {{ $estNonLue ? 'non-lue' : '' }}">
                    <div>
                        <div class="titre-notification">{{ $notification->data['title'] ?? 'Notification' }}</div>
                        <div class="message-notification">{{ $notification->data['message'] ?? '' }}</div>
                        <div class="meta-notification">{{ $notification->created_at?->format('d/m/Y H:i') }}</div>
                    </div>

                    <div class="actions-notification">
                        @if(!empty($notification->data['url']))
                            <a href="{{ $notification->data['url'] }}" class="btn btn-sm btn-outline-success">Acceder</a>
                        @endif

                        @if($estNonLue)
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Marquer lue</button>
                            </form>
                        @else
                            <span class="badge text-bg-light border">Lue</span>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
