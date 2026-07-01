<?php

namespace App\Http\Controllers;

use App\Models\AuthorRequest;
use Illuminate\Http\Request;

class AuthorRequestController extends Controller
{
    // ===== CÔTÉ LECTEUR =====

    public function create()
    {
        $user = auth()->user();

        if ($user->isAuteur() || $user->isAdmin()) {
            return redirect()->route('articles.index')
                ->with('succes', 'Tu es déjà auteur, tu peux publier !');
        }

        $demandeEnAttente = $user->authorRequests()
            ->where('statut', 'en_attente')->exists();

        return view('author_requests.create', ['demandeEnAttente' => $demandeEnAttente]);
    }

    public function store(Request $request)
    {
        $donnees = $request->validate([
            'bio'      => 'required|min:20',
            'domaine'  => 'required|max:255',
            'github'   => 'nullable|url|required_without:linkedin',
            'linkedin' => 'nullable|url|required_without:github',
        ], [
            'github.required_without'   => 'Donne au moins un lien : GitHub ou LinkedIn.',
            'linkedin.required_without' => 'Donne au moins un lien : GitHub ou LinkedIn.',
        ]);

        $user = $request->user();

        if ($user->authorRequests()->where('statut', 'en_attente')->exists()) {
            return redirect()->route('articles.index')
                ->with('succes', 'Tu as déjà une demande en attente.');
        }

        $user->authorRequests()->create($donnees);

        return redirect()->route('articles.index')
            ->with('succes', "Ta demande pour devenir auteur a été envoyée ! Un admin va l'examiner.");
    }

    // ===== CÔTÉ ADMIN =====

    public function index()
    {
        $demandes = AuthorRequest::with('user')->latest()->get();
        return view('admin.author_requests.index', ['demandes' => $demandes]);
    }

    public function approve(AuthorRequest $authorRequest)
    {
        $authorRequest->update(['statut' => 'approuvee']);
        $authorRequest->user->update(['role' => 'auteur']); // promotion !

        return back()->with('succes', $authorRequest->user->name . " est désormais AUTEUR ! 🎉");
    }

    public function reject(AuthorRequest $authorRequest)
    {
        $authorRequest->update(['statut' => 'refusee']);

        return back()->with('succes', "La demande de " . $authorRequest->user->name . " a été refusée.");
    }
}