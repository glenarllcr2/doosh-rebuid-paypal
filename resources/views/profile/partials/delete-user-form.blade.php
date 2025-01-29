<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            {{ __('Delete Account') }}
        </h2>
        <p class="card-text">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </div>

    <div class="card-body">
        <button class="btn btn-danger"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('Delete Account') }}
        </button>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mt-4 mb-3 form-group">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock"></i> {{ __('Password') }}
                    </label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="{{ __('Password') }}">
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </button>

                    <button type="submit" class="btn btn-danger ms-3">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
</div>
