<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class CommentLiked extends Notification
{
    public function __construct(public User $liker, public Comment $comment) {}

    // Canal : base de données (PAS mail)
    public function via($notifiable): array
    {
        return ['database'];
    }

    // Les données enregistrées
    public function toArray($notifiable): array
    {
        return [
            'liker_id'   => $this->liker->id,
            'liker_name' => $this->liker->name,
            'comment_id' => $this->comment->id,
            'article_id' => $this->comment->article_id,
            'extrait'    => Str::limit($this->comment->contenu, 50),
        ];
    }
}