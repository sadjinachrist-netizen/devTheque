<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['nom', 'slug'];

    // Une catégorie a plusieurs articles
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}