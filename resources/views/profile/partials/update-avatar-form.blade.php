<section>
    <header>
        <h2 class="text-lg font-medium text-neutral-100">
            {{ __('Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-neutral-400">
            {{ __('Here you can change your avatar. It will be displayed on your profile.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.avatar.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf @method('patch')

        <div class="flex flex-col space-y-2">
            <x-avatar :user="$user" class="w-20 h-20"></x-avatar>

            <div class="">
                <label for="avatar" class="block text-sm font-medium text-neutral-200">
                    {{ __('Avatar') }}
                </label>

                <div class="mt-1">
                    <input type="file" name="avatar" id="avatar"
                        class="block w-full rounded-md shadow-sm sm:text-sm dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-200 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:placeholder-neutral-400 dark:focus:ring-opacity-50 dark:focus:ring-offset-neutral-800 dark:focus:ring-offset-opacity-50 dark:ring-offset-neutral-800 dark:ring-offset-opacity-50 dark:ring-neutral-500 dark:ring-opacity-50" />
                </div>

                <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-neutral-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
