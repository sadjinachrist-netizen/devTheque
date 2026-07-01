<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Devenir auteur sur DevThèque</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if ($demandeEnAttente)
                <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 rounded mb-4">
                    ⏳ Tu as déjà une demande <strong>en attente</strong>. Un admin va l'examiner bientôt.
                </div>
                <a href="{{ route('articles.index') }}" class="text-indigo-600 text-sm hover:underline">← Retour au blog</a>
            @else
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-gray-600 mb-6 text-sm">
                        Tu veux partager ton savoir sur DevThèque ? Remplis cette candidature.
                        Un admin l'examinera — pense à donner des preuves (GitHub, LinkedIn).
                    </p>

                    <form action="{{ route('author-requests.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ton domaine d'expertise</label>
                            <input type="text" name="domaine" value="{{ old('domaine') }}"
                                   placeholder="Ex : Développement web, IA, Cybersécurité…"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('domaine') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Présente-toi / ta motivation</label>
                            <textarea name="bio" rows="5"
                                      placeholder="Parle de ton expérience, de ce que tu veux partager…"
                                      class="w-full border-gray-300 rounded-md shadow-sm">{{ old('bio') }}</textarea>
                            @error('bio') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <p class="text-sm bg-yellow-100 border border-yellow-300 text-yellow-800 rounded px-3 py-2 mb-4">
                            ⚠️ Donne <strong>au moins un</strong> lien (GitHub <em>ou</em> LinkedIn) pour prouver ton expertise.
                        </p>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lien GitHub</label>
                            <input type="url" name="github" value="{{ old('github') }}"
                                   placeholder="https://github.com/ton-pseudo"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('github') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lien LinkedIn</label>
                            <input type="url" name="linkedin" value="{{ old('linkedin') }}"
                                   placeholder="https://linkedin.com/in/ton-profil"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('linkedin') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Envoyer ma candidature</button>
                            <a href="{{ route('articles.index') }}" class="text-gray-600 hover:underline">Annuler</a>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>