<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>
            <!-- from here -->
            <div class="mt-4">
                <x-label for="city" value="{{ __('city') }}" />
                <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autocomplete="city" />
            </div>

            <div class="mt-4">
                <x-label for="country" value="{{ __('country') }}" />
                <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')" required autocomplete="country" />
            </div>

            <div class="mt-4">
                <x-label for="neighborhood" value="{{ __('neighborhood') }}" />
                <x-input id="neighborhood" class="block mt-1 w-full" type="text" name="neighborhood" :value="old('neighborhood')" required autocomplete="neighborhood" />
            </div>

            <div class="mt-4">
                <x-label for="building" value="{{ __('building') }}" />
                <x-input id="building" class="block mt-1 w-full" type="text" name="building" :value="old('building')" required autocomplete="building" />
            </div>

            <div class="mt-4">
                <x-label for="apartment" value="{{ __('apartment') }}" />
                <x-input id="apartment" class="block mt-1 w-full" type="text" name="apartment" :value="old('apartment')" required autocomplete="apartment" />
            </div>

            <div class="mt-4">
                <x-label for="other_specif" value="{{ __('other_specif') }}" />
                <x-input id="other_specif" class="block mt-1 w-full" type="text" name="other_specif" :value="old('other_specif')"  autocomplete="other_specif" />
            </div>
            <!-- end here -->
            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <x-label for="terms">
                    <div class="flex items-center">
                        <x-checkbox name="terms" id="terms" required />

                        <div class="ml-2">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-label>
            </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>