<header>
    <h2>
        {{ __('Delete Account') }}
    </h2>

    <p>
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>
</header>

<div>
    <x-danger-button class="modal-open" onclick="modalOpen(this)">
        <span class="icon-medium">&#9762;</span> {{ __('Delete Account') }}
    </x-danger-button>
    
    <x-modal class="modal-danger" name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
    
            <h2>
                {{ __('Are you sure you want to delete your account?') }}
            </h2>
    
            <p>
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>
    
    
            <x-input-label for="password" value="{{ __('Password') }}" />
    
            <x-text-input
                id="password"
                name="password"
                type="password"
                placeholder="{{ __('Password') }}"
            />
    
            <x-input-error :messages="$errors->userDeletion->get('password')" />
    
            <x-secondary-button onclick="modalClose()">
                {{ __('Cancel') }}
            </x-secondary-button>
    
            <x-danger-button>
                {{ __('Delete Account') }}
            </x-danger-button>
        </form>
    </x-modal>
</div>