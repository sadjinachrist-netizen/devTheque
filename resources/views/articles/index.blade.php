<x-app-layout>

    {{-- ===== HERO ===== --}}
    <section class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div>
                    <h1 class="text-4xl sm:text-5xl font-extrabold text-brand-navy leading-tight">
                        La bibliothèque du <span class="text-brand-blue">savoir tech</span>
                    </h1>
                    <p class="mt-5 text-lg text-slate-500">
                        Une plateforme collaborative conçue pour les développeurs, par les développeurs.
                        Explorez des tutoriels approfondis et partagez vos découvertes.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="#articles" class="px-6 py-3 bg-brand-blue text-white font-semibold rounded-xl hover:bg-brand-blue-dark transition">
                            Explorer les articles
                        </a>
                        @auth
                            @if (auth()->user()->isAuteur() || auth()->user()->isAdmin())
                                <a href="{{ route('articles.create') }}" class="px-6 py-3 bg-white border border-slate-300 text-brand-navy font-semibold rounded-xl hover:bg-slate-50 transition">Écrire un article</a>
                            @else
                                <a href="{{ route('author-requests.create') }}" class="px-6 py-3 bg-white border border-slate-300 text-brand-navy font-semibold rounded-xl hover:bg-slate-50 transition">Contribuer</a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="px-6 py-3 bg-white border border-slate-300 text-brand-navy font-semibold rounded-xl hover:bg-slate-50 transition">Contribuer</a>
                        @endauth
                    </div>
                </div>

                <div class="hidden lg:flex justify-center">
                    <div class="w-full max-w-md bg-blue-50 rounded-3xl p-12 flex items-center justify-center">
                        <svg width="200" height="150" viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="15" y="20" width="170" height="115" rx="16" fill="#dbeafe"/>
                            <polyline points="55,60 80,82 55,104" fill="none" stroke="#2563eb" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="98" y1="104" x2="150" y2="104" stroke="#2563eb" stroke-width="9" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== ARTICLES ===== --}}
    <section id="articles" class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('succes'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-8">
                    {{ session('succes') }}
                </div>
            @endif

            <h2 class="inline-block text-2xl font-extrabold text-brand-navy border-b-2 border-brand-teal pb-1 mb-8">
                Dernières publications
            </h2>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($articles as $article)
                    <article class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                       @if ($article->image)
                            <img src="{{ $article->image }}" alt="{{ $article->titre }}" class="h-32 w-full object-cover">
                        @else
                            <div class="h-32 bg-gradient-to-br from-blue-500 to-teal-400 flex items-center justify-center">
                                <svg width="44" height="44" viewBox="0 0 84 84" fill="none">
                                    <polyline points="34,26 22,42 34,58" fill="none" stroke="#ffffff" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                                    <polyline points="50,26 62,42 50,58" fill="none" stroke="#ffffff" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        @endif

                        <div class="p-6 flex flex-col flex-1">
                            @if ($article->category)
                                <span class="inline-block self-start text-xs font-semibold uppercase tracking-wide text-teal-700 bg-teal-50 rounded-full px-3 py-1 mb-3">
                                    {{ $article->category->nom }}
                                </span>
                            @endif

                            <h3 class="text-lg font-bold text-brand-navy leading-snug">
                                <a href="{{ route('articles.show', $article) }}" class="hover:text-brand-blue">{{ $article->titre }}</a>
                            </h3>

                            <p class="text-slate-500 text-sm mt-2 flex-1">{{ \Illuminate\Support\Str::limit($article->contenu, 100) }}</p>

                            <div class="flex items-center justify-between mt-5 pt-4 border-t border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-8 h-8 rounded-full bg-brand-blue text-white flex items-center justify-center text-sm font-bold">
                                        {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                    </span>
                                    <div class="leading-tight">
                                        <p class="text-xs font-semibold text-slate-700">{{ $article->user->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $article->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('articles.show', $article) }}" class="text-brand-blue text-sm font-semibold hover:underline">Lire →</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full bg-white border border-slate-200 rounded-2xl p-10 text-center text-slate-500">
                        Aucun article pour l'instant.
                    </div>
                @endforelse
            </div>

        </div>
    </section>

</x-app-layout>