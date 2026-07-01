<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorRequestController;

// Page d'accueil -> on redirige vers la liste des articles
Route::get('/', function () {
    return redirect()->route('articles.index');
});

// 🌍 Route publique : liste des articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// ✍️ Écriture d'articles : réservé aux AUTEURS (l'admin passe aussi, via le middleware)
    Route::middleware(['auth', 'role:auteur'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

// 🌍 Route publique : afficher un article (DOIT être après /articles/create)
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// --- Routes ajoutées par Breeze (ne pas toucher) ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/devenir-auteur', [AuthorRequestController::class, 'create'])->name('author-requests.create');
    Route::post('/devenir-auteur', [AuthorRequestController::class, 'store'])->name('author-requests.store');
});

// ===== Espace ADMIN (réservé au rôle admin) =====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/demandes', [AuthorRequestController::class, 'index'])->name('admin.author-requests.index');
    Route::post('/demandes/{authorRequest}/approuver', [AuthorRequestController::class, 'approve'])->name('admin.author-requests.approve');
    Route::post('/demandes/{authorRequest}/refuser', [AuthorRequestController::class, 'reject'])->name('admin.author-requests.reject');
});

require __DIR__.'/auth.php';