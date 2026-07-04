<?php

namespace App\Http\Controllers;

use App\Models\CmsContent as ContenuCms;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContenuCmsController extends Controller
{
    public function creer(Request $request): View
    {
        $type = $request->string('type')->value() ?: 'article';
        $contenu = new ContenuCms([
            'type' => $type,
            'status' => 'draft',
            'is_featured' => false,
        ]);

        return view('admin.cms.form', compact('contenu', 'type'));
    }

    public function enregistrer(Request $request): RedirectResponse
    {
        $donnees = $this->validerContenu($request);

        $donnees['slug'] = $this->genererSlugUnique($donnees['slug'] ?: $donnees['title']);
        $donnees['author_user_id'] = Auth::id();
        $donnees['published_at'] = $donnees['status'] === 'published' ? now() : null;

        ContenuCms::create($donnees);

        return redirect()->route($this->routeIndexSelonType($donnees['type']))->with('success', 'Contenu créé avec succès.');
    }

    public function modifier(ContenuCms $contenuCms): View
    {
        return view('admin.cms.form', [
            'contenu' => $contenuCms,
            'type' => $contenuCms->type,
        ]);
    }

    public function mettreAJour(Request $request, ContenuCms $contenuCms): RedirectResponse
    {
        $donnees = $this->validerContenu($request, $contenuCms);
        $donnees['slug'] = $this->genererSlugUnique($donnees['slug'] ?: $donnees['title'], $contenuCms->id);
        $donnees['published_at'] = $donnees['status'] === 'published' ? ($contenuCms->published_at ?? now()) : null;

        $contenuCms->update($donnees);

        return redirect()->route($this->routeIndexSelonType($contenuCms->type))->with('success', 'Contenu mis à jour avec succès.');
    }

    public function supprimer(ContenuCms $contenuCms): RedirectResponse
    {
        $type = $contenuCms->type;
        $contenuCms->delete();

        return redirect()->route($this->routeIndexSelonType($type))->with('success', 'Contenu supprimé avec succès.');
    }

    public function pagePublique(): View
    {
        $contenus = ContenuCms::query()
            ->whereIn('type', ['article', 'conseil'])
            ->where('status', 'published')
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('type');

        return view('cms.conseils', [
            'articles' => $contenus->get('article', collect()),
            'conseils' => $contenus->get('conseil', collect()),
        ]);
    }

    public function create(Request $request): View
    {
        return $this->creer($request);
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->enregistrer($request);
    }

    public function edit(ContenuCms $contenuCms): View
    {
        return $this->modifier($contenuCms);
    }

    public function update(Request $request, ContenuCms $contenuCms): RedirectResponse
    {
        return $this->mettreAJour($request, $contenuCms);
    }

    public function destroy(ContenuCms $contenuCms): RedirectResponse
    {
        return $this->supprimer($contenuCms);
    }

    public function publicIndex(): View
    {
        return $this->pagePublique();
    }

    private function validerContenu(Request $request, ?ContenuCms $contenu = null): array
    {
        $valide = $request->validate([
            'type' => ['required', 'in:article,conseil,page'],
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:220'],
            'category' => ['nullable', 'string', 'max:120'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'body' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($contenu) {
            $valide['slug'] = $request->input('slug', $contenu->slug);
        } elseif (! $request->filled('slug')) {
            $valide['slug'] = $valide['title'];
        }

        $valide['is_featured'] = $request->boolean('is_featured');
        $valide['sort_order'] = (int) ($valide['sort_order'] ?? 0);

        return $valide;
    }

    private function routeIndexSelonType(string $type): string
    {
        return match ($type) {
            'page' => 'admin.contenu.pages',
            default => 'admin.contenu.articles',
        };
    }

    private function genererSlugUnique(string $base, ?int $ignoreId = null): string
    {
        $slug = Str::slug($base);
        $original = $slug;
        $index = 2;

        while (
            ContenuCms::query()
                ->where('slug', $slug)
                ->when($ignoreId !== null, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original.'-'.$index;
            $index++;
        }

        return $slug;
    }
}
