<section>
    <header>
        <div class="flex items-center space-x-3 mb-1">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ __('Organization Profile') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Update your NGO details. Registration number and documents are managed by admin.') }}</p>
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
                <label for="organization_name" class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Organization Name') }}</label>
                <input id="organization_name" name="organization_name" type="text" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" value="{{ old('organization_name', $profile->organization_name ?? '') }}" required />
                <x-input-error class="mt-2" :messages="$errors->get('organization_name')" />
            </div>

            <div>
                <label for="contact_person" class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Contact Person') }}</label>
                <input id="contact_person" name="contact_person" type="text" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" value="{{ old('contact_person', $profile->contact_person ?? '') }}" required />
                <x-input-error class="mt-2" :messages="$errors->get('contact_person')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Phone Number') }}</label>
                <input id="phone" name="phone" type="text" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" value="{{ old('phone', $profile->phone ?? '') }}" required autocomplete="tel" placeholder="e.g. +94 77 123 4567" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Registration Number') }}</label>
                <div class="px-4 py-3 border border-gray-100 rounded-xl bg-gray-50 text-gray-600">
                    🏛️ {{ $profile->registration_number ?? 'N/A' }}
                </div>
            </div>
        </div>

        <div>
            <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Organization Address') }}</label>
            <textarea id="address" name="address" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" required placeholder="Enter your organization's full address...">{{ old('address', $profile->address ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-yellow-600 transition-all duration-200 shadow-sm hover:shadow-md">
                {{ __('Save Organization Profile') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium">{{ __('✓ Saved!') }}</p>
            @endif
        </div>
    </form>
</section>
