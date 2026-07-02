<?php

namespace App\Http\Controllers;

use App\Models\AuthorRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [];

        // Données pour auteurs & admin : leurs articles + stats
        if ($user->isAuteur() || $user->isAdmin()) {
            $mesArticles = $user->articles()->withCount('comments')->latest()->get();
            $data['mesArticles']    = $mesArticles;
            $data['nbArticles']     = $mesArticles->count();
            $data['nbCommentaires'] = $mesArticles->sum('comments_count');
        }

        // Donnée en plus pour l'admin
        if ($user->isAdmin()) {
            $data['nbDemandesEnAttente'] = AuthorRequest::where('statut', 'en_attente')->count();
        }

        return view('dashboard', $data);
    }
}