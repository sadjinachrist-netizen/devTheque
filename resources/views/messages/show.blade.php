<x-app-layout>
    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('messages.index') }}" class="text-slate-400 hover:text-brand-blue text-xl">←</a>
                <span class="w-10 h-10 rounded-full bg-brand-blue text-white flex items-center justify-center font-bold">
                    {{ strtoupper(substr($interlocuteur->name, 0, 1)) }}
                </span>
                <div>
                    <p class="font-bold text-brand-navy">{{ $interlocuteur->name }}</p>
                    <p class="text-xs text-slate-400 uppercase tracking-wide">{{ $interlocuteur->role }}</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-3 mb-4">
                @forelse ($messages as $msg)
                    @if ($msg->sender_id === auth()->id())
                        <div class="flex justify-end">
                            <div class="max-w-[75%]">
                                <div class="bg-brand-blue text-white rounded-2xl rounded-br-sm px-4 py-2 whitespace-pre-line">{{ $msg->contenu }}</div>
                                <p class="text-[11px] text-slate-400 text-right mt-1">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex justify-start">
                            <div class="max-w-[75%]">
                                <div class="bg-slate-100 text-slate-800 rounded-2xl rounded-bl-sm px-4 py-2 whitespace-pre-line">{{ $msg->contenu }}</div>
                                <p class="text-[11px] text-slate-400 mt-1">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-center text-slate-400 text-sm py-6">Aucun message. Écris le premier !</p>
                @endforelse
            </div>

            <form action="{{ route('messages.store', $interlocuteur) }}" method="POST" class="flex items-end gap-2">
                @csrf
                <textarea name="contenu" rows="1" placeholder="Écris ton message…" required
                          class="flex-1 rounded-xl border-slate-300 focus:border-brand-blue focus:ring-brand-blue resize-none"></textarea>
                <button type="submit" class="px-5 py-2.5 bg-brand-blue text-white font-semibold rounded-xl hover:bg-brand-blue-dark transition">Envoyer</button>
            </form>
            @error('contenu') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

        </div>
    </div>
</x-app-layout>