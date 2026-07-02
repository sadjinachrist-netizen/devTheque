<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        // On récupère toutes les notifs (avant de les marquer lues, pour garder le surlignage)
        $notifications = auth()->user()->notifications()->latest()->get();

        // Puis on marque toutes les non-lues comme lues
        auth()->user()->unreadNotifications->markAsRead();

        return view('notifications.index', ['notifications' => $notifications]);
    }
}