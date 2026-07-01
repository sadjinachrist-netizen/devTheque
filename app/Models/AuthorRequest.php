<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorRequest extends Model
{
    protected $fillable = ['bio', 'domaine', 'github', 'linkedin', 'statut'];

    // Une demande APPARTIENT À un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}