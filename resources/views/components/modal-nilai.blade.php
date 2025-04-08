<div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <div class="flex items-center justify-center min-h-screen">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="relative bg-white rounded-lg w-96 mx-auto">
            <div class="px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900 flex justify-start">{{ $title }}</h3>
                <div class="mt-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
