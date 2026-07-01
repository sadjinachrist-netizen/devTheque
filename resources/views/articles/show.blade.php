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

            <div class="flex items-center gap-3 mt-6 pb-6 border-b border-slate-200">
                <span class="w-11 h-11 rounded-full bg-brand-blue text-white flex items-center justify-center font-bold text-lg">
                    {{ strtoupper(substr($article->user->name, 0, 1)) }}
                </span>
                <div>
                    <p class="font-semibold text-slate-800">{{ $article->user->name }}</p>
                    <p class="text-sm text-slate-400">{{ $article->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

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

                                @auth
                                    @if ($comment->user_id === auth()->id() || auth()->user()->isAdmin())
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?')" class="mt-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 hover:underline">Supprimer</button>
                                        </form>
                                    @endif
                                @endauth
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