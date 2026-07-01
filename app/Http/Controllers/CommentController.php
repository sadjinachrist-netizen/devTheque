<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Poster un commentaire sur un article
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'contenu' => 'required|min:2|max:2000',
        ]);

        $article->comments()->create([
            'contenu' => $request->contenu,
            'user_id' => auth()->id(),
        ]);

        return back()->with('succes', 'Commentaire publié !');
    }

    // Supprimer un commentaire (son auteur OU l'admin)
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            abort(403, "Tu ne peux pas supprimer ce commentaire.");
        }

        $comment->delete();

        return back()->with('succes', 'Commentaire supprimé.');
    }
}