<section>
    <header>
        <div class="flex items-center space-x-3 mb-1">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ __('Donor Profile') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Update your contact and address details.') }}</p>
            </div>
        </div>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Phone Number') }}</label>
                <input id="phone" name="phone" type="text" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" value="{{ old('phone', $profile->phone ?? '') }}" autocomplete="tel" placeholder="e.g. +94 77 123 4567" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Account Type') }}</label>
                <div class="px-4 py-3 border border-gray-100 rounded-xl bg-gray-50 text-gray-600">
                    🤝 Donor Account
                </div>
            </div>
        </div>

        <div>
            <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Address') }}</label>
            <textarea id="address" name="address" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" placeholder="Enter your full address...">{{ old('address', $profile->address ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-yellow-600 transition-all duration-200 shadow-sm hover:shadow-md">
                {{ __('Save Donor Profile') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium">{{ __('✓ Saved!') }}</p>
            @endif
        </div>
    </form>
</section>
