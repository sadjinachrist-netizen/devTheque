<x-app-layout>
    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-brand-navy mb-8">Messages</h1>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                @forelse ($conversations as $conv)
                    <a href="{{ route('messages.show', $conv['user']) }}" class="flex items-center gap-4 p-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition">
                        <span class="w-12 h-12 shrink-0 rounded-full bg-brand-blue text-white flex items-center justify-center font-bold text-lg">
                            {{ strtoupper(substr($conv['user']->name, 0, 1)) }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <p class="font-semibold text-slate-800 truncate">{{ $conv['user']->name }}</p>
                                <span class="text-xs text-slate-400 shrink-0">{{ $conv['dernier']->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-slate-500 truncate">
                                @if ($conv['dernier']->sender_id === auth()->id())<span class="text-slate-400">Vous : </span>@endif
                                {{ $conv['dernier']->contenu }}
                            </p>
                        </div>
                        @if ($conv['nonLus'] > 0)
                            <span class="shrink-0 bg-brand-blue text-white text-xs font-bold rounded-full px-2 py-0.5">{{ $conv['nonLus'] }}</span>
                        @endif
                    </a>
                @empty
                    <div class="p-10 text-center text-slate-500">
                        Aucune conversation. Contacte un auteur depuis un de ses articles !
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>