@extends('layouts.app')

@section('content')
<style>
    .page-formulaire {
        background: linear-gradient(180deg, #f7f9fc 0%, #eef3fa 100%);
        border: 1px solid #dbe4f2;
        border-radius: 18px;
        padding: 1rem;
    }

    .entete-page h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        color: #1f2e4a;
    }

    .entete-page p {
        margin: 0.35rem 0 0;
        color: #62708f;
    }

    .bloc-form {
        border: 1px solid #e3ebf6;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(23, 39, 72, 0.05);
        overflow: hidden;
    }

    .bloc-form .bloc-entete {
        padding: 0.85rem 0.95rem;
        border-bottom: 1px solid #edf2f8;
    }

    .bloc-form .bloc-entete h2 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: #22314f;
    }

    .bloc-form .bloc-corps {
        padding: 0.95rem;
    }

    .form-label {
        font-weight: 700;
        color: #344867;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        border-color: #d7e1ef;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #95afd8;
        box-shadow: 0 0 0 .2rem rgba(89, 128, 210, 0.12);
    }

    .zone-actions {
        display: flex;
        gap: 0.65rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .aide {
        background: #f8fbff;
        border: 1px solid #e5eefb;
        border-radius: 14px;
        padding: 0.9rem;
        color: #5a6c8d;
    }
</style>

<div class="page-formulaire">
    <div class="entete-page mb-3">
        <h1>{{ $contenu->exists ? 'Modifier le contenu' : 'Créer un contenu' }}</h1>
        <p>{{ $contenu->exists ? 'Mettre à jour et republier le contenu depuis la base.' : 'Publier un nouvel article, conseil ou page dans la base CMS.' }}</p>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="bloc-form">
                <div class="bloc-entete">
                    <h2>Informations de contenu</h2>
                </div>
                <div class="bloc-corps">
                    <form method="POST" action="{{ $contenu->exists ? route('admin.cms.update', $contenu) : route('admin.cms.store') }}">
                        @csrf
                        @if($contenu->exists)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="type">Type</label>
                                <select id="type" name="type" class="form-select @error('type') is-invalid @enderror">
                                    @foreach(['article' => 'Article', 'conseil' => 'Conseil', 'page' => 'Page'] as $value => $label)
                                        <option value="{{ $value }}" @selected(old('type', $contenu->type ?? $type ?? 'article') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('type')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label" for="title">Titre</label>
                                <input id="title" type="text" name="title" value="{{ old('title', $contenu->title) }}" class="form-control @error('title') is-invalid @enderror">
                                @error('title')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label" for="slug">Slug</label>
                                <input id="slug" type="text" name="slug" value="{{ old('slug', $contenu->slug) }}" class="form-control @error('slug') is-invalid @enderror" placeholder="slug-du-contenu">
                                @error('slug')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="category">Catégorie</label>
                                <input id="category" type="text" name="category" value="{{ old('category', $contenu->category) }}" class="form-control @error('category') is-invalid @enderror" placeholder="Conseils adoption / Page vitrine / Guide comportement">
                                @error('category')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-12">
                                <label class="form-label" for="summary">Résumé</label>
                                <textarea id="summary" name="summary" rows="3" class="form-control @error('summary') is-invalid @enderror">{{ old('summary', $contenu->summary) }}</textarea>
                                @error('summary')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-12">
                                <label class="form-label" for="body">Contenu</label>
                                <textarea id="body" name="body" rows="8" class="form-control @error('body') is-invalid @enderror">{{ old('body', $contenu->body) }}</textarea>
                                @error('body')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-4">
                                <label class="form-label" for="status">Statut</label>
                                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                    @foreach(['draft' => 'Brouillon', 'published' => 'Publié', 'archived' => 'Archivé'] as $value => $label)
                                        <option value="{{ $value }}" @selected(old('status', $contenu->status ?? 'draft') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="sort_order">Ordre</label>
                                <input id="sort_order" type="number" name="sort_order" min="0" value="{{ old('sort_order', $contenu->sort_order ?? 0) }}" class="form-control @error('sort_order') is-invalid @enderror">
                                @error('sort_order')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check mt-3">
                                    <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $contenu->is_featured))>
                                    <label class="form-check-label" for="is_featured">Mettre en avant</label>
                                </div>
                            </div>
                        </div>

                        <div class="zone-actions">
                            <button class="btn btn-primary" type="submit">{{ $contenu->exists ? 'Enregistrer' : 'Publier le contenu' }}</button>
                            <a href="{{ $contenu->type === 'page' ? route('admin.contenu.pages') : route('admin.contenu.articles') }}" class="btn btn-outline-secondary">Retour</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="aide">
                <h3 class="h6 fw-bold text-dark">Conseils de publication</h3>
                <ul class="mb-0 ps-3">
                    <li>Gardez des titres courts et explicites.</li>
                    <li>Publiez un contenu seulement après validation éditoriale.</li>
                    <li>Utilisez le champ Résumé pour alimenter les cartes client.</li>
                    <li>Les pages publiées peuvent servir aux futures pages du site.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
