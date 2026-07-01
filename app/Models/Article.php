<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['titre', 'contenu', 'category_id'];

    // Un article appartient à un utilisateur (auteur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un article appartient à une catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}