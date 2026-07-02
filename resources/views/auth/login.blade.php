<x-guest-layout>
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8">
        <h2 class="text-2xl font-bold text-brand-navy">Se connecter</h2>
        <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase mt-1">Heureux de vous revoir</p>

        <x-auth-session-status class="mt-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Adresse e-mail</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/></svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           placeholder="nom@exemple.com"
                           class="w-full pl-10 pr-3 py-2.5 rounded-xl border-slate-300 focus:border-brand-blue focus:ring-brand-blue">
                </div>
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-medium text-slate-700">Mot de passe</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-brand-blue hover:underline">Mot de passe oublié ?</a>
                    @endif
                </div>
                <div class="relative" x-data="{ show: false }">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11v4m-6 5h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4"/></svg>
                    </span>
                    <input :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                           placeholder="••••••••"
                           class="w-full pl-10 pr-10 py-2.5 rounded-xl border-slate-300 focus:border-brand-blue focus:ring-brand-blue">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="show" style="display:none;" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                    </button>
                </div>
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full py-3 bg-brand-blue text-white font-semibold rounded-xl hover:bg-brand-blue-dark transition">
                Se connecter
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-6">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-brand-blue font-semibold hover:underline">S'inscrire</a>
        </p>
    </div>
</x-guest-layout>