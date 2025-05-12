<div>
Admin dashboard
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
               <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>

@props([
    'id' => uniqid(),
])

<svg {{ $attributes }} fill="none">
    <defs>
        <pattern id="pattern-{{ $id }}" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
            <path d="M-1 5L5 -1M3 9L8.5 3.5" stroke-width="0.5"></path>
        </pattern>
    </defs>
    <rect stroke="none" fill="url(#pattern-{{ $id }})" width="100%" height="100%"></rect>
</svg>
</div>