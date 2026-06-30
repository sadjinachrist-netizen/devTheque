<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['titre', 'contenu'];

    // Un article APPARTIENT À un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}