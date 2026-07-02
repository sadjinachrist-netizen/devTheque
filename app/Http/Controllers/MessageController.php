<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Boîte de réception : la liste des conversations
    public function index()
    {
        $userId = auth()->id();

        // Tous mes messages (envoyés ou reçus), le plus récent d'abord
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with('sender', 'receiver')
            ->latest()
            ->get();

        // Regrouper par interlocuteur, garder le dernier message de chaque conversation
        $conversations = $messages->groupBy(function ($message) use ($userId) {
            return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
        })->map(function ($groupe) use ($userId) {
            $dernier = $groupe->first();
            return [
                'user'    => $dernier->sender_id === $userId ? $dernier->receiver : $dernier->sender,
                'dernier' => $dernier,
                'nonLus'  => $groupe->where('receiver_id', $userId)->whereNull('read_at')->count(),
            ];
        });

        return view('messages.index', ['conversations' => $conversations]);
    }

    // Afficher une conversation avec un utilisateur
    public function show(User $user)
    {
        $userId = auth()->id();

        // Marquer comme lus les messages reçus de cette personne
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Le fil complet (dans les deux sens), du plus ancien au plus récent
        $messages = Message::where(function ($q) use ($userId, $user) {
                $q->where('sender_id', $userId)->where('receiver_id', $user->id);
            })
            ->orWhere(function ($q) use ($userId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $userId);
            })
            ->orderBy('created_at')
            ->get();

        return view('messages.show', ['interlocuteur' => $user, 'messages' => $messages]);
    }

    // Envoyer un message
    public function store(Request $request, User $user)
    {
        $request->validate([
            'contenu' => 'required|max:2000',
        ]);

        if ($user->id === auth()->id()) {
            return back()->with('succes', "Tu ne peux pas t'envoyer un message.");
        }

        Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $user->id,
            'contenu'     => $request->contenu,
        ]);

        return redirect()->route('messages.show', $user)->with('succes', 'Message envoyé !');
    }
}