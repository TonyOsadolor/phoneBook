<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
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

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
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

        <!-- Username -->
        <flux:input
            wire:model="username" :label="__('Username')" type="text" required autocomplete="off"
            :placeholder="__('JohnxxDoe')"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
