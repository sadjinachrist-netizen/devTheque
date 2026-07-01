<x-app-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-start justify-between mb-8">
                <div>
                    <p class="text-sm text-slate-400 mb-1">Admin › Auteurs</p>
                    <h1 class="text-3xl font-extrabold text-brand-navy">Gestion des candidatures</h1>
                    <p class="text-slate-500 mt-1">Examinez et validez les demandes d'expertise pour la plateforme.</p>
                </div>
                <span class="shrink-0 inline-flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm font-semibold text-brand-blue">
                    {{ $demandes->where('statut', 'en_attente')->count() }} <span class="text-slate-500 font-normal">En attente</span>
                </span>
            </div>

            @if (session('succes'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6">
                    {{ session('succes') }}
                </div>
            @endif

            <div class="space-y-5">
                @forelse ($demandes as $demande)
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                        <div class="flex flex-col sm:flex-row gap-6">

                            <div class="sm:w-56 sm:shrink-0 sm:border-r sm:border-slate-100 sm:pr-6">
                                <div class="flex items-center gap-3">
                                    <span class="w-11 h-11 rounded-full bg-brand-blue text-white flex items-center justify-center font-bold text-lg">
                                        {{ strtoupper(substr($demande->user->name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <h3 class="font-bold text-slate-900 leading-tight">{{ $demande->user->name }}</h3>
                                        <p class="text-xs text-slate-500">{{ $demande->user->email }}</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="inline-block text-xs font-medium bg-teal-50 text-teal-700 rounded-full px-2.5 py-1">
                                        {{ $demande->domaine }}
                                    </span>
                                </div>
                                <div class="flex gap-3 mt-3 text-sm">
                                    @if ($demande->github)
                                        <a href="{{ $demande->github }}" target="_blank" class="text-brand-blue hover:underline">GitHub</a>
                                    @endif
                                    @if ($demande->linkedin)
                                        <a href="{{ $demande->linkedin }}" target="_blank" class="text-brand-blue hover:underline">LinkedIn</a>
                                    @endif
                                </div>
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Motivation</p>
                                    @if ($demande->statut === 'en_attente')
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700">EN ATTENTE</span>
                                    @elseif ($demande->statut === 'approuvee')
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700">APPROUVÉ</span>
                                    @else
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-50 text-red-700">REFUSÉ</span>
                                    @endif
                                </div>
                                <p class="text-slate-600 whitespace-pre-line">{{ $demande->bio }}</p>

                                @if ($demande->statut === 'en_attente')
                                    <div class="flex items-center justify-end gap-3 mt-4">
                                        <form action="{{ route('admin.author-requests.reject', $demande) }}" method="POST"
                                              onsubmit="return confirm('Refuser cette demande ?')">
                                            @csrf
                                            <button type="submit" class="px-5 py-2 border border-red-300 text-red-600 font-semibold rounded-xl hover:bg-red-50 transition">Rejeter</button>
                                        </form>
                                        <form action="{{ route('admin.author-requests.approve', $demande) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-5 py-2 bg-brand-teal text-white font-semibold rounded-xl hover:opacity-90 transition">Approuver</button>
                                        </form>
                                    </div>
                                @else
                                    <p class="text-right text-xs text-slate-400 italic mt-3">Décision prise le {{ $demande->updated_at->format('d/m/Y') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 rounded-2xl p-10 text-center text-slate-500">
                        Aucune candidature pour l'instant.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>