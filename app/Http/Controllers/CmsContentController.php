<?php

namespace App\Http\Controllers;

use App\Models\CmsContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CmsContentController extends Controller
{
	// Version anglaise de la gestion des contenus CMS en back-office.
	public function create(Request $request): View
	{
		$type = $request->string('type')->value() ?: 'article';
		$content = new CmsContent([
			'type' => $type,
			'status' => 'draft',
			'is_featured' => false,
		]);

		return view('admin.cms.form', compact('content', 'type'));
	}

	public function store(Request $request): RedirectResponse
	{
		$data = $this->validateContent($request);

		$data['slug'] = Str::slug($data['slug'] ?: $data['title']);
		$data['author_user_id'] = Auth::id();
		$data['published_at'] = $data['status'] === 'published' ? now() : null;

		CmsContent::create($data);

		return redirect()
			->route($this->indexRouteForType($data['type']))
			->with('success', 'Contenu créé avec succès.');
	}

	public function edit(CmsContent $cmsContent): View
	{
		return view('admin.cms.form', [
			'content' => $cmsContent,
			'type' => $cmsContent->type,
		]);
	}

	public function update(Request $request, CmsContent $cmsContent): RedirectResponse
	{
		$data = $this->validateContent($request, $cmsContent);

		$data['slug'] = Str::slug($data['slug'] ?: $data['title']);
		$data['published_at'] = $data['status'] === 'published'
			? ($cmsContent->published_at ?? now())
			: null;

		$cmsContent->update($data);

		return redirect()
			->route($this->indexRouteForType($cmsContent->type))
			->with('success', 'Contenu mis à jour avec succès.');
	}

	public function destroy(CmsContent $cmsContent): RedirectResponse
	{
		$type = $cmsContent->type;
		$cmsContent->delete();

		return redirect()
			->route($this->indexRouteForType($type))
			->with('success', 'Contenu supprimé avec succès.');
	}

	public function publicIndex(): View
	{
		$contents = CmsContent::query()
			->whereIn('type', ['article', 'conseil'])
			->where('status', 'published')
			->orderByDesc('is_featured')
			->orderByDesc('published_at')
			->orderByDesc('created_at')
			->get()
			->groupBy('type');

		return view('cms.conseils', [
			'articles' => $contents->get('article', collect()),
			'conseils' => $contents->get('conseil', collect()),
		]);
	}

	private function validateContent(Request $request, ?CmsContent $content = null): array
	{
		$validated = $request->validate([
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

		if ($content) {
			$validated['slug'] = $request->input('slug', $content->slug);
		} elseif (! $request->filled('slug')) {
			$validated['slug'] = $validated['title'];
		}

		$validated['is_featured'] = $request->boolean('is_featured');
		$validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

		return $validated;
	}

	private function indexRouteForType(string $type): string
	{
		return match ($type) {
			'page' => 'admin.contenu.pages',
			default => 'admin.contenu.articles',
		};
	}
}
