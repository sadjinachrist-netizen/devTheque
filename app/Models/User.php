<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        // Un utilisateur A PLUSIEURS articles
    public function articles()
    {
        return $this->hasMany(Article::class);
    }


        // Un utilisateur peut faire des demandes pour devenir auteur
    public function authorRequests()
    {
        return $this->hasMany(AuthorRequest::class);
    }

    // --- Raccourcis pour tester le rôle ---
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAuteur(): bool
    {
        return $this->role === 'auteur';
    }

    public function isLecteur(): bool
    {
        return $this->role === 'lecteur';
    }

}
