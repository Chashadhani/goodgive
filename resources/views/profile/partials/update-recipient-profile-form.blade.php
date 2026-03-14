<section>
    <header>
        <div class="flex items-center space-x-3 mb-1">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ __('Recipient Profile') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Update your personal details and needs information.') }}</p>
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
                <input id="phone" name="phone" type="text" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" value="{{ old('phone', $profile->phone ?? '') }}" required autocomplete="tel" placeholder="e.g. +94 77 123 4567" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div>
                <label for="location" class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Location') }}</label>
                <input id="location" name="location" type="text" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" value="{{ old('location', $profile->location ?? '') }}" required placeholder="e.g. Colombo, Sri Lanka" />
                <x-input-error class="mt-2" :messages="$errors->get('location')" />
            </div>
        </div>

        <div>
            <label for="need_category" class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Need Category') }}</label>
            <select id="need_category" name="need_category" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                <option value="">Select a category</option>
                @foreach(['education' => '📚 Education', 'healthcare' => '🏥 Healthcare', 'shelter' => '🏠 Shelter', 'food' => '🍽️ Food Security', 'clothing' => '👕 Clothing', 'emergency' => '🚨 Emergency Relief', 'other' => '📋 Other'] as $value => $label)
                    <option value="{{ $value }}" {{ old('need_category', $profile->need_category ?? '') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('need_category')" />
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Description') }}</label>
            <textarea id="description" name="description" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" placeholder="Briefly describe your situation and what kind of help you need...">{{ old('description', $profile->description ?? '') }}</textarea>
            <p class="mt-1 text-xs text-gray-400">Max 1000 characters</p>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-yellow-600 transition-all duration-200 shadow-sm hover:shadow-md">
                {{ __('Save Recipient Profile') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium">{{ __('✓ Saved!') }}</p>
            @endif
        </div>
    </form>
</section>
