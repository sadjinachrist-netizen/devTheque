<x-app-layout>
    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('succes'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6">
                    {{ session('succes') }}
                </div>
            @endif

            <div class="text-sm text-slate-400 mb-4">
                <a href="{{ route('articles.index') }}" class="hover:text-brand-blue">Le Blog</a>
                @if ($article->category)
                    <span class="mx-1">›</span>
                    <span class="uppercase tracking-wide">{{ $article->category->nom }}</span>
                @endif
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-brand-navy leading-tight">{{ $article->titre }}</h1>

            @if ($article->category)
                <span class="inline-block text-xs font-semibold uppercase tracking-wide text-teal-700 bg-teal-50 rounded-full px-3 py-1 mt-4">
                    {{ $article->category->nom }}
                </span>
            @endif

            <div class="flex items-center justify-between gap-3 mt-6 pb-6 border-b border-slate-200">
                <div class="flex items-center gap-3">
                    <span class="w-11 h-11 rounded-full bg-brand-blue text-white flex items-center justify-center font-bold text-lg">
                        {{ strtoupper(substr($article->user->name, 0, 1)) }}
                    </span>
                    <div>
                        <p class="font-semibold text-slate-800">{{ $article->user->name }}</p>
                        <p class="text-sm text-slate-400">{{ $article->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
                @auth
                    @if (auth()->id() !== $article->user_id)
                        <a href="{{ route('messages.show', $article->user) }}" class="shrink-0 px-4 py-2 bg-blue-50 text-brand-blue text-sm font-semibold rounded-xl hover:bg-blue-100 transition">
                            Contacter l'auteur
                        </a>
                    @endif
                @endauth
            </div>

            @if ($article->image)
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre }}" class="w-full rounded-2xl mt-8 object-cover max-h-96">
            @endif

            <div class="text-slate-700 mt-8 whitespace-pre-line leading-relaxed">{{ $article->contenu }}</div>

            @auth
                @if ($article->user_id === auth()->id() || auth()->user()->isAdmin())
                    <div class="flex items-center gap-3 mt-8 pt-6 border-t border-slate-200">
                        @if ($article->user_id === auth()->id())
                            <a href="{{ route('articles.edit', $article) }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200">Modifier</a>
                        @endif
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Supprimer cet article ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700">Supprimer</button>
                        </form>
                    </div>
                @endif
            @endauth

            {{-- ===== COMMENTAIRES ===== --}}
            <div class="mt-12">
                <h2 class="text-xl font-bold text-brand-navy mb-6">Commentaires ({{ $article->comments->count() }})</h2>

                @auth
                    <form action="{{ route('comments.store', $article) }}" method="POST" class="mb-8">
                        @csrf
                        <textarea name="contenu" rows="3" placeholder="Publier un commentaire…"
                                  class="w-full rounded-xl border-slate-300 focus:border-brand-blue focus:ring-brand-blue">{{ old('contenu') }}</textarea>
                        @error('contenu') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        <div class="flex justify-end mt-2">
                            <button type="submit" class="px-5 py-2 bg-brand-blue text-white font-semibold rounded-xl hover:bg-brand-blue-dark transition">Publier</button>
                        </div>
                    </form>
                @else
                    <p class="text-slate-500 text-sm mb-8">
                        <a href="{{ route('login') }}" class="text-brand-blue font-semibold hover:underline">Connecte-toi</a> pour laisser un commentaire.
                    </p>
                @endauth

                <div class="space-y-5">
                    @forelse ($article->comments->sortByDesc('created_at') as $comment)
                        <div class="flex gap-3">
                            <span class="w-9 h-9 shrink-0 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </span>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <p class="font-semibold text-slate-800 text-sm">{{ $comment->user->name }}</p>
                                    <span class="text-xs text-slate-400">· {{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-slate-600 text-sm mt-1 whitespace-pre-line">{{ $comment->contenu }}</p>

                                <div class="flex items-center gap-4 mt-2">
                                    @auth
                                        @php($aLike = $comment->likers->contains('id', auth()->id()))
                                        <form action="{{ route('comments.like', $comment) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-1 text-xs {{ $aLike ? 'text-red-500' : 'text-slate-400 hover:text-red-500' }} transition">
                                                <svg class="w-4 h-4" fill="{{ $aLike ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                                {{ $comment->likers->count() }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="flex items-center gap-1 text-xs text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                            {{ $comment->likers->count() }}
                                        </span>
                                    @endauth

                                    @auth
                                        @if ($comment->user_id === auth()->id() || auth()->user()->isAdmin())
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-500 hover:underline">Supprimer</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm">Aucun commentaire. Sois le premier à réagir !</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>