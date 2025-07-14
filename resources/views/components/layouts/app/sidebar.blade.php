<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
    @php
        $user = auth()->user();
        $dashboardRoute = $user->role === 'admin' ? 'admin.dashboard' : 'views.dashboard';
    @endphp

    <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <!-- Logo -->
        <a href="{{ route($dashboardRoute) }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route($dashboardRoute)" :current="request()->routeIs($dashboardRoute)" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navlist.item>
            </flux:navlist.group>

            @if($user->role === 'admin')
           <flux:navlist.group expandable heading="Admin Tools" class="grid">
                <flux:navlist.item icon="squares-plus"
                    badge="{{ \App\Models\Product::count() }}"
                    :href="route('manage-product')"
                    :current="request()->routeIs('manage-product')"
                    wire:navigate>
                    Manage Products
                </flux:navlist.item>  

                <flux:navlist.item icon="star"
                    badge="{{ \App\Models\Promotion::count() }}"
                    :href="route('manage-promotion')"
                    :current="request()->routeIs('manage-promotion')"
                    wire:navigate>
                    Manage Promotion
                </flux:navlist.item> 

                <flux:navlist.item icon="list-bullet"
                    badge="{{ \App\Models\Order::count() }}"
                    :href="route('manage-order')"
                    :current="request()->routeIs('manage-order')"
                    wire:navigate>
                    Manage Orders
                </flux:navlist.item>

                @if(in_array($user->position, ['SuperAdmin', 'Manager']))
                    <flux:navlist.item icon="user-plus"
                        badge="{{ \App\Models\User::where('role', 'user')->count() }}"
                        :href="route('manage-customer')"
                        :current="request()->routeIs('manage-customer')"
                        wire:navigate>
                        Manage Customers
                    </flux:navlist.item>
                    <flux:navlist.item icon="building-office-2"
                        badge="{{ \App\Models\User::where('role', 'admin')->count() }}"
                        :href="route('manage-staff')"
                        :current="request()->routeIs('manage-staff')"
                        wire:navigate>
                        Manage Staffs
                    </flux:navlist.item>
                @endif
            </flux:navlist.group>
            @else
            <flux:navlist.group expandable heading="User Tools" class="grid">
                <flux:navlist.item icon="user" href="#">My Profile</flux:navlist.item>
                <flux:navlist.item icon="heart" href="#">Favorites</flux:navlist.item>
                <flux:navlist.item icon="shopping-cart" href="#">My Cart</flux:navlist.item>
            </flux:navlist.group>
            @endif
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="adjustments-horizontal" :href="route('settings.profile')" wire:navigate>
                {{ __('Settings') }}
            </flux:navlist.item>
        </flux:navlist>

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile
                :name="$user->name"
                :initials="$user->initials()"
                icon-trailing="chevrons-up-down"
            />
            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ $user->initials() }}
                                </span>
                            </span>
                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ $user->name }}</span>
                                <span class="truncate text-xs">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile Header -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:dropdown position="top" align="end">
            <flux:profile :initials="$user->initials()" icon-trailing="chevron-down" />
            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ $user->initials() }}
                                </span>
                            </span>
                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ $user->name }}</span>
                                <span class="truncate text-xs">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}
    @fluxScripts
</body>
</html>
