<x-app-layout>
    @php $user = auth()->user(); @endphp

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center gap-4 mb-8">
                <span class="w-16 h-16 rounded-2xl bg-brand-blue text-white flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
                <div>
                    <h1 class="text-2xl font-extrabold text-brand-navy">{{ $user->name }}</h1>
                    <p class="text-slate-500 text-sm">
                        {{ $user->email }}
                        <span class="ml-1 text-xs font-semibold uppercase tracking-wide bg-blue-50 text-brand-blue rounded-full px-2 py-0.5">{{ $user->role }}</span>
                    </p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>