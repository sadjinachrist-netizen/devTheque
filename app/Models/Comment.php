<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['contenu', 'user_id'];

    // Un commentaire appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un commentaire appartient à un article
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

        // Les utilisateurs qui ont liké ce commentaire (many-to-many)
    public function likers()
    {
        return $this->belongsToMany(User::class, 'comment_likes')->withTimestamps();
    }
}