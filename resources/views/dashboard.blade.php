<x-app-layout>
    @php $user = auth()->user(); @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-brand-navy">Bonjour {{ $user->name }} </h1>
                    <p class="text-slate-500 mt-1">
                        Ton espace personnel
                        <span class="ml-1 text-xs font-semibold uppercase tracking-wide bg-blue-50 text-brand-blue rounded-full px-2 py-0.5">{{ $user->role }}</span>
                    </p>
                </div>
            
            </div>

            @if (session('succes'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6">{{ session('succes') }}</div>
            @endif

            @if ($user->isLecteur())
                {{-- ===== DASHBOARD LECTEUR ===== --}}
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8 text-center max-w-2xl">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                        <svg width="30" height="30" viewBox="0 0 84 84" fill="none">
                            <polyline points="34,26 22,42 34,58" fill="none" stroke="#2563eb" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="50,26 62,42 50,58" fill="none" stroke="#2563eb" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-brand-navy">Envie de partager ton savoir ?</h2>
                    <p class="text-slate-500 mt-2">
                        Tu es actuellement <strong>lecteur</strong> : tu peux lire et commenter tous les articles.
                        Pour publier les tiens, deviens auteur !
                    </p>
                    <a href="{{ route('author-requests.create') }}" class="inline-block mt-5 px-6 py-3 bg-brand-blue text-white font-semibold rounded-xl hover:bg-brand-blue-dark transition">
                        Devenir auteur
                    </a>
                </div>
            @else
                {{-- ===== DASHBOARD AUTEUR / ADMIN ===== --}}
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-8">
                    <div class="bg-white border border-slate-200 rounded-2xl p-6">
                        <p class="text-sm text-slate-500">Mes articles</p>
                        <p class="text-3xl font-extrabold text-brand-navy mt-1">{{ $nbArticles }}</p>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl p-6">
                        <p class="text-sm text-slate-500">Commentaires reçus</p>
                        <p class="text-3xl font-extrabold text-brand-navy mt-1">{{ $nbCommentaires }}</p>
                    </div>
                    @if ($user->isAdmin())
                        <a href="{{ route('admin.author-requests.index') }}" class="bg-white border border-slate-200 rounded-2xl p-6 hover:border-brand-blue transition">
                            <p class="text-sm text-slate-500">Candidatures en attente</p>
                            <p class="text-3xl font-extrabold text-brand-blue mt-1">{{ $nbDemandesEnAttente }}</p>
                        </a>
                    @endif
                </div>

                <h2 class="text-xl font-bold text-brand-navy mb-4">Mes articles</h2>
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    @forelse ($mesArticles as $article)
                        <div class="flex flex-wrap items-center justify-between gap-3 p-5 border-b border-slate-100 last:border-0">
                            <div class="min-w-0">
                                <a href="{{ route('articles.show', $article) }}" class="font-semibold text-brand-navy hover:text-brand-blue">{{ $article->titre }}</a>
                                <div class="flex items-center gap-2 text-xs text-slate-400 mt-1">
                                    @if ($article->category)
                                        <span class="text-teal-700 bg-teal-50 rounded-full px-2 py-0.5 uppercase tracking-wide font-semibold">{{ $article->category->nom }}</span>
                                    @endif
                                    <span>{{ $article->created_at->format('d/m/Y') }}</span>
                                    <span>· {{ $article->comments_count }} commentaire(s)</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('articles.edit', $article) }}" class="px-3 py-1.5 bg-slate-100 text-slate-700 rounded-lg text-sm hover:bg-slate-200">Modifier</a>
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Supprimer cet article ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-sm hover:bg-red-100">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-slate-500">
                            Tu n'as pas encore publié d'article.
                            <a href="{{ route('articles.create') }}" class="text-brand-blue font-semibold hover:underline">Écris ton premier article !</a>
                        </div>
                    @endforelse
                </div>
            @endif

        </div>
    </div>
</x-app-layout>