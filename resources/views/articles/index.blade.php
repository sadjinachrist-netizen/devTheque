<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Le Blog</h2>
            @auth
                <a href="{{ route('articles.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">+ Nouvel article</a>
            @endauth
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('succes'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
                    {{ session('succes') }}
                </div>
            @endif

            @forelse ($articles as $article)
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900">
                        <a href="{{ route('articles.show', $article) }}" class="hover:text-indigo-600">{{ $article->titre }}</a>
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        par {{ $article->user->name }} · {{ $article->created_at->diffForHumans() }}
                    </p>
                    <p class="text-gray-700 mt-3">{{ \Illuminate\Support\Str::limit($article->contenu, 150) }}</p>
                    <a href="{{ route('articles.show', $article) }}" class="text-indigo-600 text-sm mt-3 inline-block hover:underline">Lire la suite →</a>
                </div>
            @empty
                <div class="bg-white shadow-sm rounded-lg p-6 text-center text-gray-500">
                    Aucun article pour l'instant. @auth Sois le premier à publier ! @endauth
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>