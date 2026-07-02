<x-app-layout>
    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-brand-navy mb-8">Notifications</h1>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                @forelse ($notifications as $notif)
                    <a href="{{ route('articles.show', $notif->data['article_id']) }}"
                       class="flex items-start gap-3 p-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition {{ is_null($notif->read_at) ? 'bg-blue-50' : '' }}">
                        <span class="w-10 h-10 shrink-0 rounded-full bg-red-50 flex items-center justify-center">❤️</span>
                        <div class="flex-1">
                            <p class="text-sm text-slate-700">
                                <span class="font-semibold">{{ $notif->data['liker_name'] }}</span> a aimé votre commentaire
                            </p>
                            <p class="text-sm text-slate-500 italic">« {{ $notif->data['extrait'] }} »</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                        </div>
                        @if (is_null($notif->read_at))
                            <span class="w-2 h-2 rounded-full bg-brand-blue shrink-0 mt-2"></span>
                        @endif
                    </a>
                @empty
                    <div class="p-10 text-center text-slate-500">Aucune notification pour l'instant.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>