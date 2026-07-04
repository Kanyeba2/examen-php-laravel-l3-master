@extends('layouts.app')

@section('content')
<style>
    .page-creation-animal {
        max-width: 980px;
        margin: 0 auto;
    }

    .carte-creation-animal {
        border: 1px solid #dce6f2;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 8px 24px rgba(22, 36, 70, 0.06);
        overflow: hidden;
    }

    .entete-creation-animal {
        padding: 1rem 1.15rem;
        border-bottom: 1px solid #e8eef8;
        background: linear-gradient(180deg, #f7faff 0%, #ffffff 100%);
    }

    .entete-creation-animal h2 {
        margin: 0;
        font-size: 1.55rem;
        font-weight: 700;
        color: #192747;
    }

    .entete-creation-animal p {
        margin: 0.35rem 0 0;
        color: #657494;
        font-size: 0.92rem;
    }

    .contenu-creation-animal {
        padding: 1.1rem;
    }

    .bloc-formulaire {
        border: 1px solid #e2e9f5;
        border-radius: 12px;
        padding: 0.85rem;
        margin-bottom: 0.85rem;
        background: #fbfdff;
    }

    .bloc-formulaire h3 {
        margin: 0 0 0.7rem;
        font-size: 1rem;
        font-weight: 700;
        color: #23345a;
    }

    .carte-creation-animal .form-control,
    .carte-creation-animal .form-select,
    .carte-creation-animal .btn {
        border-radius: 10px;
    }

    .carte-creation-animal .form-label {
        font-weight: 600;
        color: #304367;
        font-size: 0.88rem;
    }

    .indice-obligatoire {
        color: #a6384a;
    }

    .aide-fichier {
        color: #6b7a99;
        font-size: 0.8rem;
    }

    .zone-apercu-image {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.5rem;
        padding: 0.5rem;
        border: 1px dashed #cfdcf1;
        border-radius: 10px;
        background: #f9fbff;
    }

    .zone-apercu-image img {
        width: 96px;
        height: 96px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #d5e1f3;
        display: none;
    }

    .zone-apercu-image .texte-apercu {
        color: #5f7093;
        font-size: 0.84rem;
    }

    .actions-formulaire {
        display: flex;
        gap: 0.55rem;
        flex-wrap: wrap;
        margin-top: 0.3rem;
    }

    .champ-invalide {
        border-color: #d65268 !important;
        box-shadow: 0 0 0 0.15rem rgba(214, 82, 104, 0.12);
    }

    @media (max-width: 768px) {
        .entete-creation-animal,
        .contenu-creation-animal {
            padding: 0.85rem;
        }
    }
</style>

<div class="page-creation-animal">
    <div class="carte-creation-animal">
        <div class="entete-creation-animal">
            <h2>Ajouter un animal</h2>
            <p>Completez le dossier de l'animal puis ajoutez sa photo et, si necessaire, un document PDF.</p>
        </div>

        <div class="contenu-creation-animal">
            <form method="POST" action="{{ route('animals.store') }}" enctype="multipart/form-data">
                @csrf

                <section class="bloc-formulaire">
                    <h3>Informations generales</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="nom">Nom <span class="indice-obligatoire">*</span></label>
                            <input
                                id="nom"
                                type="text"
                                name="nom"
                                value="{{ old('nom') }}"
                                class="form-control @error('nom') champ-invalide @enderror"
                                required
                            >
                            @error('nom')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="espece">Espece <span class="indice-obligatoire">*</span></label>
                            <input
                                id="espece"
                                type="text"
                                name="espece"
                                value="{{ old('espece') }}"
                                class="form-control @error('espece') champ-invalide @enderror"
                                required
                            >
                            @error('espece')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="race">Race</label>
                            <input
                                id="race"
                                type="text"
                                name="race"
                                value="{{ old('race') }}"
                                class="form-control @error('race') champ-invalide @enderror"
                            >
                            @error('race')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="age">Age</label>
                            <input
                                id="age"
                                type="number"
                                name="age"
                                min="0"
                                value="{{ old('age') }}"
                                class="form-control @error('age') champ-invalide @enderror"
                            >
                            @error('age')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="genre">Genre <span class="indice-obligatoire">*</span></label>
                            <select id="genre" name="genre" class="form-select @error('genre') champ-invalide @enderror" required>
                                <option value="male" @selected(old('genre', 'male') === 'male')>Male</option>
                                <option value="female" @selected(old('genre') === 'female')>Femelle</option>
                            </select>
                            @error('genre')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="taille">Taille</label>
                            <input
                                id="taille"
                                type="text"
                                name="taille"
                                value="{{ old('taille') }}"
                                placeholder="Petite, moyenne, grande..."
                                class="form-control @error('taille') champ-invalide @enderror"
                            >
                            @error('taille')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="localisation">Localisation</label>
                            <input
                                id="localisation"
                                type="text"
                                name="localisation"
                                value="{{ old('localisation') }}"
                                class="form-control @error('localisation') champ-invalide @enderror"
                            >
                            @error('localisation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="statut">Statut <span class="indice-obligatoire">*</span></label>
                            <select id="statut" name="statut" class="form-select @error('statut') champ-invalide @enderror" required>
                                <option value="disponible" @selected(old('statut', 'disponible') === 'disponible')>Disponible</option>
                                <option value="en_attente" @selected(old('statut') === 'en_attente')>En attente</option>
                                <option value="adopte" @selected(old('statut') === 'adopte')>Adopte</option>
                            </select>
                            @error('statut')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="prix_adoption">Prix d'adoption</label>
                            <input id="prix_adoption" type="number" name="prix_adoption" min="0" step="0.01" value="{{ old('prix_adoption') }}" class="form-control @error('prix_adoption') champ-invalide @enderror" placeholder="Montant fixe ou laissez vide">
                            <div class="aide-fichier mt-1">Si ce champ est vide, le tarif par défaut sera applique.</div>
                            @error('prix_adoption')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="description">Description</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="form-control @error('description') champ-invalide @enderror"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </section>

                <section class="bloc-formulaire">
                    <h3>Pieces jointes</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="image">Photo de l'animal</label>
                            <input
                                id="image"
                                type="file"
                                name="image"
                                class="form-control @error('image') champ-invalide @enderror"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            >
                            <div class="aide-fichier mt-1">Formats acceptes: JPG, PNG, WEBP · Taille max: 4 Mo.</div>
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <div class="zone-apercu-image" id="zone-apercu-image">
                                <img id="apercu-image" alt="Apercu de la photo de l'animal">
                                <div class="texte-apercu" id="texte-apercu-image">Aucun fichier image selectionne.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="document">Document PDF (optionnel)</label>
                            <input
                                id="document"
                                type="file"
                                name="document"
                                class="form-control @error('document') champ-invalide @enderror"
                                accept=".pdf,application/pdf"
                            >
                            <div class="aide-fichier mt-1">Format accepte: PDF · Taille max: 5 Mo.</div>
                            @error('document')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </section>

                <div class="actions-formulaire">
                    <button type="submit" class="btn btn-success">Enregistrer l'animal</button>
                    <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const champImage = document.getElementById('image');
    const apercuImage = document.getElementById('apercu-image');
    const texteApercuImage = document.getElementById('texte-apercu-image');

    champImage?.addEventListener('change', () => {
        const fichier = champImage.files?.[0];

        if (!fichier) {
            apercuImage.style.display = 'none';
            apercuImage.removeAttribute('src');
            texteApercuImage.textContent = 'Aucun fichier image selectionne.';
            return;
        }

        const url = URL.createObjectURL(fichier);
        apercuImage.src = url;
        apercuImage.style.display = 'block';
        texteApercuImage.textContent = `${fichier.name} · ${(fichier.size / (1024 * 1024)).toFixed(2)} Mo`;
    });
</script>
@endsection
