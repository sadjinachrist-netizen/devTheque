<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user', 'category')->latest()->get();
        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        $categories = Category::orderBy('nom')->get();
        return view('articles.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $donnees = $request->validate([
            'titre'       => 'required|max:255',
            'contenu'     => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $donnees['image'] = $this->uploadImage($request->file('image'));
        } else {
            unset($donnees['image']);
        }

        $request->user()->articles()->create($donnees);

        return redirect()->route('articles.index')->with('succes', 'Article publié avec succès !');
    }

    public function show(Article $article)
    {
        $article->load('user', 'category', 'comments.user', 'comments.likers');
        return view('articles.show', ['article' => $article]);
    }

    public function edit(Article $article)
    {
        $this->verifierProprietaire($article);
        $categories = Category::orderBy('nom')->get();
        return view('articles.edit', ['article' => $article, 'categories' => $categories]);
    }

    public function update(Request $request, Article $article)
    {
        $this->verifierProprietaire($article);

        $donnees = $request->validate([
            'titre'       => 'required|max:255',
            'contenu'     => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $donnees['image'] = $this->uploadImage($request->file('image'));
        } else {
            unset($donnees['image']);
        }

        $article->update($donnees);

        return redirect()->route('articles.show', $article)->with('succes', 'Article modifié !');
    }

    public function destroy(Article $article)
    {
        $this->verifierProprietaire($article);
        $article->delete();

        return redirect()->route('articles.index')->with('succes', 'Article supprimé.');
    }

    private function verifierProprietaire(Article $article)
    {
        if ($article->user_id !== auth()->id()) {
            abort(403, "Tu n'es pas l'auteur de cet article.");
        }
    }

    // Upload vers Cloudinary → renvoie l'URL permanente
    private function uploadImage($fichier): string
    {
        $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
        $resultat = $cloudinary->uploadApi()->upload($fichier->getRealPath(), [
            'folder' => 'devtheque',
        ]);
        return $resultat['secure_url'];
    }
}