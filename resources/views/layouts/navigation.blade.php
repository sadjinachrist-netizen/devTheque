<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50">
       @auth
        @php($nonLusMessages = auth()->user()->receivedMessages()->whereNull('read_at')->count())
        @php($nonLuesNotifs = auth()->user()->unreadNotifications->count())
    @endauth
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('articles.index') }}" class="flex items-center gap-2">
                        <svg width="36" height="36" viewBox="0 0 82 82" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="4" y="4" width="58" height="58" rx="15" fill="#2563eb"/>
                            <rect x="16" y="20" width="34" height="6" rx="3" fill="#ffffff"/>
                            <rect x="16" y="31" width="34" height="6" rx="3" fill="#ffffff"/>
                            <rect x="16" y="42" width="22" height="6" rx="3" fill="#ffffff"/>
                            <circle cx="62" cy="62" r="15" fill="#14b8a6"/>
                        </svg>
                        <span class="text-xl font-bold text-brand-navy">DevThèque</span>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                    <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">{{ __('Le Blog') }}</x-nav-link>
                    @auth
                                                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                            {{ __('Messages') }}
                            @if ($nonLusMessages > 0)
                                <span class="ml-1 bg-red-500 text-white text-xs font-bold rounded-full px-1.5 py-0.5">{{ $nonLusMessages }}</span>
                            @endif
                        </x-nav-link>

                                                <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                            {{ __('Notifications') }}
                            @if ($nonLuesNotifs > 0)
                                <span class="ml-1 bg-red-500 text-white text-xs font-bold rounded-full px-1.5 py-0.5">{{ $nonLuesNotifs }}</span>
                            @endif
                        </x-nav-link>
                    
                        @if (auth()->user()->isLecteur())
                            <x-nav-link :href="route('author-requests.create')" :active="request()->routeIs('author-requests.*')">{{ __('Devenir auteur') }}</x-nav-link>
                        @endif
                        @if (auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.author-requests.index')" :active="request()->routeIs('admin.author-requests.*')">{{ __('Demandes') }}</x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                @auth
                    @if (auth()->user()->isAuteur() || auth()->user()->isAdmin())
                        <a href="{{ route('articles.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-blue text-white text-sm font-semibold rounded-lg hover:bg-brand-blue-dark transition">+ Nouvel article</a>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 focus:outline-none">
                                <span class="w-9 h-9 rounded-full bg-brand-blue text-white flex items-center justify-center font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                <span class="hidden lg:block">{{ Auth::user()->name }}</span>
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-slate-100">
                                <p class="text-sm font-medium text-slate-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500">{{ ucfirst(Auth::user()->role) }}</p>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Mon profil') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Se déconnecter') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ __('Connexion') }}</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-brand-blue text-white text-sm font-semibold rounded-lg hover:bg-brand-blue-dark transition">{{ __('Inscription') }}</a>
                @endguest
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">{{ __('Le Blog') }}</x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                    {{ __('Messages') }} @if ($nonLusMessages > 0) ({{ $nonLusMessages }}) @endif
                </x-responsive-nav-link>
                @if (auth()->user()->isAuteur() || auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('articles.create')">{{ __('+ Nouvel article') }}</x-responsive-nav-link>
                @endif
                @if (auth()->user()->isLecteur())
                    <x-responsive-nav-link :href="route('author-requests.create')" :active="request()->routeIs('author-requests.*')">{{ __('Devenir auteur') }}</x-responsive-nav-link>
                @endif
                @if (auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.author-requests.index')" :active="request()->routeIs('admin.author-requests.*')">{{ __('Demandes') }}</x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-slate-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">{{ __('Mon profil') }}</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Se déconnecter') }}</x-responsive-nav-link>
                    </form>
                </div>
            @endauth
            @guest
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('login')">{{ __('Connexion') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">{{ __('Inscription') }}</x-responsive-nav-link>
                </div>
            @endguest
        </div>
    </div>
</nav>