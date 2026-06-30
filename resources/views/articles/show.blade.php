<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $article->titre }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if (session('succes'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">{{ session('succes') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <p class="text-sm text-gray-500">par {{ $article->user->name }} · {{ $article->created_at->diffForHumans() }}</p>
                <div class="text-gray-800 mt-4 whitespace-pre-line leading-relaxed">{{ $article->contenu }}</div>

                @auth
                    @if ($article->user_id === auth()->id())
                        <div class="flex items-center gap-3 mt-6 pt-4 border-t">
                            <a href="{{ route('articles.edit', $article) }}" class="px-3 py-1.5 bg-gray-200 rounded-md text-sm hover:bg-gray-300">Modifier</a>
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Supprimer cet article ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-600 text-white rounded-md text-sm hover:bg-red-700">Supprimer</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            <a href="{{ route('articles.index') }}" class="text-indigo-600 text-sm mt-4 inline-block hover:underline">← Retour aux articles</a>
        </div>
    </div>
</x-app-layout>
