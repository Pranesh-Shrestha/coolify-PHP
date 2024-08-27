@props([
    'title' => 'Are you sure?',
    'isErrorButton' => false,
    'buttonTitle' => 'Confirm Action',
    'buttonFullWidth' => false,
    'customButton' => null,
    'disabled' => false,
    'action' => 'delete',
    'content' => null,
])
<div x-data="{ modalOpen: false, step: 1, deleteText: '', selectedActions: [], getActionText(action) { 
    const actionTexts = {
        'delete_volumes': 'Delete associated volumes',
        'delete_connected_networks': 'Delete connected networks',
        'delete_configurations': 'Delete configuration files',
        'delete_images': 'Delete associated unused images'
    };
    return actionTexts[action] || action;
} }" @keydown.escape.window="modalOpen = false; step = 1" :class="{ 'z-40': modalOpen }"
    class="relative w-auto h-auto">
    @if ($customButton)
        <x-forms.button @click="modalOpen=true" class="{{ $buttonFullWidth ? 'w-full' : '' }}">
            {{ $customButton }}
        </x-forms.button>
    @else
        @if ($content)
            <div @click="modalOpen=true">
                {{ $content }}
            </div>
        @else
            <x-forms.button 
                @click="modalOpen=true" 
                class="{{ $buttonFullWidth ? 'w-full' : '' }} {{ $isErrorButton ? 'bg-red-500 hover:bg-red-600 text-white' : '' }}"
                :disabled="$disabled"
                wire:target
            >
                {{ $buttonTitle }}
            </x-forms.button>
        @endif
    @endif
    <template x-teleport="body">
        <div x-show="modalOpen"
            class="fixed top-0 lg:pt-10 left-0 z-[99] flex items-start justify-center w-screen h-screen" x-cloak>
            <div x-show="modalOpen" x-transition:enter="ease-out duration-100" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-100"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false; step=1"
                class="absolute inset-0 w-full h-full bg-black bg-opacity-20 backdrop-blur-sm"></div>
            <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-100"
                x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95"
                class="relative w-full py-6 border rounded min-w-full lg:min-w-[36rem] max-w-fit bg-neutral-100 border-neutral-400 dark:bg-base px-7 dark:border-coolgray-300">
                <div class="flex items-center justify-between pb-3">
                    <h3 class="text-2xl font-bold">{{ $title }}</h3>
                </div>
                <div class="relative w-auto pb-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </template>
</div>
