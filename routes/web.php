<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorRequestController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;

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
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/devenir-auteur', [AuthorRequestController::class, 'create'])->name('author-requests.create');
    Route::post('/devenir-auteur', [AuthorRequestController::class, 'store'])->name('author-requests.store');
});


// 💬 Commentaires (tout utilisateur connecté peut commenter)
    Route::middleware('auth')->group(function () {
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
});

// 💬 Messagerie privée (utilisateurs connectés)
    Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

// ===== Espace ADMIN (réservé au rôle admin) =====
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/demandes', [AuthorRequestController::class, 'index'])->name('admin.author-requests.index');
    Route::post('/demandes/{authorRequest}/approuver', [AuthorRequestController::class, 'approve'])->name('admin.author-requests.approve');
    Route::post('/demandes/{authorRequest}/refuser', [AuthorRequestController::class, 'reject'])->name('admin.author-requests.reject');
});

require __DIR__.'/auth.php';