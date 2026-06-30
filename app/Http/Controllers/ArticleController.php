<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // 🌍 Liste publique de tous les articles
    public function index()
    {
        $articles = Article::with('user')->latest()->get();
        return view('articles.index', ['articles' => $articles]);
    }

    // 🔒 Formulaire de création
    public function create()
    {
        return view('articles.create');
    }

    // 🔒 Enregistrer un nouvel article
    public function store(Request $request)
    {
        $donnees = $request->validate([
            'titre'   => 'required|max:255',
            'contenu' => 'required',
        ]);

        // On crée l'article DIRECTEMENT lié à l'utilisateur connecté
        $request->user()->articles()->create($donnees);

        return redirect()->route('articles.index')
                         ->with('succes', 'Article publié avec succès !');
    }

    // 🌍 Afficher un article complet
    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);
    }

    // 🔒 Formulaire d'édition (auteur seulement)
    public function edit(Article $article)
    {
        $this->verifierProprietaire($article);
        return view('articles.edit', ['article' => $article]);
    }

    // 🔒 Enregistrer les modifications (auteur seulement)
    public function update(Request $request, Article $article)
    {
        $this->verifierProprietaire($article);

        $donnees = $request->validate([
            'titre'   => 'required|max:255',
            'contenu' => 'required',
        ]);

        $article->update($donnees);

        return redirect()->route('articles.show', $article)
                         ->with('succes', 'Article modifié !');
    }

    // 🔒 Supprimer (auteur seulement)
    public function destroy(Article $article)
    {
        $this->verifierProprietaire($article);
        $article->delete();

        return redirect()->route('articles.index')
                         ->with('succes', 'Article supprimé.');
    }

    // 🛡️ Petite méthode privée : bloque si l'utilisateur n'est pas l'auteur
    private function verifierProprietaire(Article $article)
    {
        if ($article->user_id !== auth()->id()) {
            abort(403, "Tu n'es pas l'auteur de cet article.");
        }
    }
}