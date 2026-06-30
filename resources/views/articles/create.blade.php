<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouvel article</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form action="{{ route('articles.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                        <input type="text" name="titre" value="{{ old('titre') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('titre') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contenu</label>
                        <textarea name="contenu" rows="8" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('contenu') }}</textarea>
                        @error('contenu') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Publier</button>
                        <a href="{{ route('articles.index') }}" class="text-gray-600 hover:underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>