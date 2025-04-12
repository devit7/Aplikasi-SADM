<div class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden flex items-center justify-center z-50" id="{{ $id }}" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="{{ $id }}Label">
                        {{ $title }}
                    </h3>
                    <div class="mt-2">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse justify-center">
            {{ $footer }}
        </div>
    </div>
</div>