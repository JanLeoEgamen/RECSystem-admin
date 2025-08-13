<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- First Name -->
                <div>
                    <x-input-label :value="__('First Name')" />
                    <div class="mt-1 text-gray-900 dark:text-gray-100">
                        {{ $user->first_name }}
                    </div>
                    <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                </div>

                <!-- Last Name -->
                <div>
                    <x-input-label :value="__('Last Name')" />
                    <div class="mt-1 text-gray-900 dark:text-gray-100">
                        {{ $user->last_name }}
                    </div>
                    <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                </div>

                <!-- Email -->
                <div>
                    <x-input-label :value="__('Email')" />
                    <div class="mt-1 text-gray-900 dark:text-gray-100">
                        {{ $user->email }}
                    </div>
                    <input type="hidden" name="email" value="{{ $user->email }}">
                </div>
            </div>
        </div>

        <!-- <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div> -->
    </form>
</section>