<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <!-- Name Group -->
            <flux:input.group>
                <!-- First Name -->
                <flux:input
                    wire:model="first_name" :label="__('First Name')" type="text" required autofocus autocomplete="off"
                    :placeholder="__('John')"
                />

                <!-- Last Name -->
                <flux:input
                    wire:model="last_name" :label="__('Last Name')" type="text" required autocomplete="off"
                    :placeholder="__('Doe')"
                />
            </flux:input.group>

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Username -->
            <flux:input
                wire:model="username" :label="__('Username')" type="text" required autocomplete="off"
                :placeholder="__('JohnxxDoe')"
            />

            <!-- Phone Number -->
            <flux:input.group :label="__('Phone Number')">
                <flux:select searchable wire:model="phonecode" placeholder="Phone Code...">
                    @foreach (\App\Models\Country::where('is_active', 1)->get() as $country)
                        <flux:select.option value="+{{ $country->phonecode }}">{{ $country->name }} [+{{ $country->phonecode }}]</flux:select.option>
                    @endforeach
                </flux:select>
                
                <flux:input  class="max-w-fit"
                    wire:model="phone" type="tel" 
                    autocomplete="off"
                    placeholder="9036-57-4839"
                />
            </flux:input.group>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
