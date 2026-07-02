<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Notifications\CommentLiked;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate(['contenu' => 'required|min:2|max:2000']);

        $article->comments()->create([
            'contenu' => $request->contenu,
            'user_id' => auth()->id(),
        ]);

        return back()->with('succes', 'Commentaire publié !');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            abort(403, "Tu ne peux pas supprimer ce commentaire.");
        }

        $comment->delete();

        return back()->with('succes', 'Commentaire supprimé.');
    }

    public function like(Comment $comment)
    {
        $resultat = $comment->likers()->toggle(auth()->id());

        // Uniquement pour un NOUVEAU like, et pas sur son propre commentaire
        if (in_array(auth()->id(), $resultat['attached']) && $comment->user_id != auth()->id()) {
            $comment->user->notify(new CommentLiked(auth()->user(), $comment));
        }

        return back();
    }
}