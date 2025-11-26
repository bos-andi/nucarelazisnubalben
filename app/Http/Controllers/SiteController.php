<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\ContactSetting;
use App\Models\GalleryItem;
use App\Models\OrganizationSetting;
use App\Models\Program;
use App\Models\VisionMissionSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function index(): View
    {
        $featured = Article::with(['category', 'tags'])
            ->where('is_featured', true)
            ->orderByDesc('published_at')
            ->first();

        $latest = Article::with(['category', 'user'])
            ->orderByDesc('published_at')
            ->when($featured, fn ($query) => $query->where('id', '!=', $featured->id))
            ->take(6)
            ->get();

        $highlightCategories = Category::where('is_highlighted', true)
            ->orderBy('name')
            ->take(6)
            ->get();

        $gallery = GalleryItem::orderByDesc('published_at')
            ->take(6)
            ->get();

        $programs = Program::active()->ordered()->get();

        return view('home', [
            'featured' => $featured ?? $latest->first(),
            'latest' => $latest,
            'categories' => $highlightCategories,
            'gallery' => $gallery,
            'programs' => $programs,
        ]);
    }

    public function news(Request $request): View
    {
        $categories = Category::orderBy('name')->get();

        $articles = Article::with(['category', 'tags', 'user'])
            ->when($request->filled('category'), fn ($query) => $query
                ->whereHas('category', fn ($catQuery) => $catQuery
                    ->where('slug', $request->category)))
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('pages.news', compact('articles', 'categories'));
    }

    public function programs(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('pages.programs', compact('categories'));
    }

    public function contact(): View
    {
        $contact = ContactSetting::getSettings();
        return view('pages.contact', compact('contact'));
    }

    public function visiMisi(): View
    {
        $visionMission = VisionMissionSetting::getSettings();
        return view('pages.visi-misi', compact('visionMission'));
    }

    public function authorProfile($userId): View
    {
        $author = \App\Models\User::findOrFail($userId);
        $articles = Article::with(['category', 'tags'])
            ->where('user_id', $userId)
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('pages.author-profile', compact('author', 'articles'));
    }

    public function sambutan(): View
    {
        $welcomeMessage = OrganizationSetting::getByKey('welcome_message');
        
        return view('pages.sambutan', compact('welcomeMessage'));
    }

    public function struktur(): View
    {
        $organizationStructure = OrganizationSetting::getByKey('organization_structure');
        
        return view('pages.struktur', compact('organizationStructure'));
    }

    public function gallery(): View
    {
        $photos = GalleryItem::where('type', 'photo')
            ->orderByDesc('published_at')
            ->get();

        $videos = GalleryItem::where('type', 'video')
            ->orderByDesc('published_at')
            ->get();

        return view('pages.gallery', compact('photos', 'videos'));
    }

    public function galleryShow(GalleryItem $gallery): View
    {
        // Get related items (same type, excluding current)
        $related = GalleryItem::where('type', $gallery->type)
            ->where('id', '!=', $gallery->id)
            ->orderByDesc('published_at')
            ->take(6)
            ->get();

        return view('pages.gallery-detail', compact('gallery', 'related'));
    }

    public function show(Article $article): View
    {
        $article->load(['category', 'tags']);

        // Increment view count
        $article->increment('views');

        $related = Article::with('category')
            ->where('id', '!=', $article->id)
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        return view('article', [
            'article' => $article,
            'related' => $related,
        ]);
    }
}
