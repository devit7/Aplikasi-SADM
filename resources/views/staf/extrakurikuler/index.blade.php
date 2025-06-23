@extends('layouts.main-staf')

@section('content')
<div class="w-full bg-gray-100 p-6">
    <div class="flex justify-between justify-items-center items-center mb-4">
        <h1 class="text-2xl font-bold">Extrakurikuler Assessment</h1>
        <a href="{{ route('staff.extrakurikuler.create-assessment') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-base px-3 py-3 rounded-lg transition-colors flex text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                    clip-rule="evenodd" />
            </svg>
            New Assessment
        </a>
    </div>

    @if (session('success'))
    <div class="mb-6 bg-green-200 border-spacing-1 border-green-400 p-4 rounded-md">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-green-700" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-lg font-medium text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div class="mb-6 bg-red-200 border-l border-red-400 p-4 rounded-md">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-red-700" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
            </div>
            <div class="ml-3">
                <p class="text-lg font-medium text-red-700">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white shadow rounded-lg">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">List Assessments</h2>
        </div>
        <div class="overflow-x-auto p-4">
            <x-tables>
                <table class="w-full border rounded-md border-collapse text-sm p-4" id="table">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="p-3 text-left font-medium text-gray-600 cursor-pointer whitespace-nowrap">
                                <div class="flex items-center">
                                    No
                                </div>
                            </th>

                            <th class="p-3 text-left font-medium text-gray-600 cursor-pointer whitespace-nowrap">
                                <div class="flex items-center">
                                    Siswa
                                </div>
                            </th>
                            <th class="p-3 text-left font-medium text-gray-600 cursor-pointer whitespace-nowrap">
                                <div class="flex items-center">
                                    Category
                                </div>
                            </th>
                            <th class="p-3 text-left font-medium text-gray-600 cursor-pointer whitespace-nowrap">
                                <div class="flex items-center">
                                    Predicate
                                </div>
                            </th>
                            <th class="p-3 text-left font-medium text-gray-600 cursor-pointer whitespace-nowrap">
                                <div class="flex items-center">
                                    Updated At
                                </div>
                            </th>
                            <th class="p-3 text-left font-medium text-gray-600 cursor-pointer whitespace-nowrap">
                                <div class="flex items-center">
                                    Created By
                                </div>
                            </th>
                            <th class="p-3 text-center font-medium text-gray-600 whitespace-nowrap">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAssessments as $index => $assessment)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="p-3 whitespace-nowrap font-medium text-base">{{ $index + 1 }}</td>
                            <td class="p-3 whitespace-nowrap font-medium text-base">
                                {{ $assessment->siswa->nama ?? 'N/A' }}
                            </td>
                            <td class="p-3 whitespace-nowrap font-medium text-base">
                                {{ $assessment->category->nama ?? 'N/A' }}
                            </td>
                            <td class="p-3 whitespace-nowrap text-center font-semibold text-base">
                                <span
                                    class="px-8 py-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                                       {{ $assessment->predicate == 'A'
                                           ? 'bg-green-100 text-green-800'
                                           : ($assessment->predicate == 'B'
                                               ? 'bg-blue-100 text-blue-800'
                                               : ($assessment->predicate == 'C'
                                                   ? 'bg-yellow-100 text-yellow-800'
                                                   : ($assessment->predicate == 'D'
                                                       ? 'bg-orange-100 text-orange-800'
                                                       : 'bg-red-100 text-red-800'))) }}">
                                    {{ $assessment->predicate }}
                                </span>
                            </td>
                            <td class="p-3 whitespace-nowrap font-medium text-base">
                                {{ $assessment->updated_at->format('d M Y') }}
                            </td>
                            <td class="p-3 whitespace-nowrap font-medium text-base">
                                {{ $assessment->created_by ?? 'N/A' }}
                            </td>
                            <td class="p-3 whitespace-nowrap font-medium text-base">
                                <span class="text-gray-700 hover:underline flex gap-4 justify-center">
                                    <!-- Modal Edit Form -->
                                    <div x-data="{ openEditModal: false }">
                                        <div @click="openEditModal = true"
                                            class="p-2 hover:bg-gray-200 rounded-md transition-all duration-300 ease-in-out cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-7 text-orange-500">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </div>

                                        <div x-show="openEditModal" x-cloak class="fixed z-50 inset-0 overflow-y-auto"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0">
                                            <div class="flex items-center justify-center min-h-screen px-4">
                                                <!-- Modal Backdrop -->
                                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                                    @click="openEditModal = false"></div>

                                                <!-- Modal Content -->
                                                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full md:max-w-xl">
                                                    <!-- Modal Header -->
                                                    <div class="bg-blue-600 py-4 px-6 text-white flex justify-between">
                                                        <h3 class="text-lg font-semibold">Edit Assessment</h3>
                                                        <button @click="openEditModal = false"
                                                            class="text-white hover:text-gray-200 focus:outline-none">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <!-- Modal Body -->
                                                    <form action="{{ route('staff.extrakurikuler.update-assessment', $assessment->id) }}"
                                                        method="POST" class="p-6 edit-form">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-4">
                                                            <div class="flex flex-col md:flex-col justify-between mb-4">
                                                                <div class="mb-4 md:mb-0 flex flex-col md:flex-col w-full gap-3">
                                                                    <input type="text"
                                                                        class="shadow-sm p-2 border border-gray-300 bg-gray-50 text-gray-700 block w-full rounded-md cursor-not-allowed"
                                                                        value="{{ $assessment->siswa->nama ?? 'N/A' }}"
                                                                        readonly>
                                                                    <input type="text"
                                                                        class="shadow-sm p-2 border border-gray-300 bg-gray-50 text-gray-700 block w-full rounded-md cursor-not-allowed"
                                                                        value="{{ $assessment->category->nama ?? 'N/A' }}"
                                                                        readonly>
                                                                    <input type="hidden" name="category_id" value="{{ $assessment->category->id }}">
                                                                    <input type="hidden" name="siswa_id" value="{{ $assessment->siswa->id }}">
                                                                </div>
                                                            </div>

                                                            <!-- Predicate Selection -->
                                                            <div class="mb-4">
                                                                <label class="block text-sm font-medium text-gray-700 mb-2">Predicate
                                                                    <span class="text-red-600">*</span></label>
                                                                <div class="grid grid-cols-4 gap-2">
                                                                    @foreach (['A', 'B', 'C', 'D'] as $predicate)
                                                                    <label
                                                                        class="inline-flex items-center border rounded-md p-2 cursor-pointer {{ $assessment->predicate == $predicate ? 'bg-blue-50 border-blue-500' : 'hover:bg-gray-50' }}">
                                                                        <input type="radio" name="predicate"
                                                                            value="{{ $predicate }}"
                                                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                                                            {{ $assessment->predicate == $predicate ? 'checked' : '' }}
                                                                            required>
                                                                        <span class="ml-2 text-sm">{{ $predicate }}</span>
                                                                    </label>
                                                                    @error('predicate')
                                                                    <p id="outlined_error_help" class="mt-2 text-xs text-red-700">
                                                                        {{ $message }}
                                                                    </p>
                                                                    @enderror
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                            <!-- Explanation Field -->
                                                            <div class="mb-4">
                                                                <label for="explanation-{{ $assessment->id }}"
                                                                    class="block text-sm font-medium text-gray-700 mb-2">Explanation<span
                                                                        class="text-red-600">*</span></label>
                                                                <textarea id="explanation-{{ $assessment->id }}" name="explanation" rows="3"
                                                                    class="shadow-sm p-3 w-full border border-gray-500 rounded-md resize-none ring-gray-500"
                                                                    placeholder="Add details about the student's performance" required>{{ $assessment->explanation }}</textarea>
                                                                @error('explanation')
                                                                <p id="outlined_error_help" class="mt-2 text-xs text-red-700">
                                                                    {{ $message }}
                                                                </p>
                                                                @enderror
                                                            </div>

                                                            <!-- Pengajar Field (Read-only) -->
                                                            <div>
                                                                <label for="created_by" class="block text-base font-medium text-gray-700 mb-1">Pengajar</label>
                                                                <input type="text" id="created_by" name="created_by"
                                                                    class="shadow-sm p-2 border ring-gray-500 border-gray-500 bg-gray-50 text-gray-500 block w-full sm:text-base rounded-md cursor-not-allowed"
                                                                    value="{{ session('staff')->nama }}" readonly>
                                                                <input type="hidden" name="created_by_id" value="{{ session('staff')->id }}">
                                                            </div>
                                                        </div>

                                                        <!-- Form Buttons -->
                                                        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                                                            <button type="button" @click="openEditModal = false"
                                                                class="px-4 py-2 text-base font-medium bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                                                Cancel
                                                            </button>
                                                            <button type="submit"
                                                                class="px-4 py-2 text-base font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 update-btn">
                                                                Update Assessment
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Button -->
                                    <div x-data="{ openDeleteModal: false }"
                                        class="p-2 hover:bg-gray-200 rounded-md transition-all duration-300 ease-in-out cursor-pointer"
                                        @click="openDeleteModal = true">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="#ef4444"
                                            class="size-7 text-red-500">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>

                                        <!-- Delete Confirmation Modal -->
                                        <div x-show="openDeleteModal" x-cloak
                                            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                                            @keydown.escape.window="openDeleteModal = false">
                                            <!-- Dialog backdrop untuk menutup modal saat klik di luar -->
                                            <div class="fixed inset-0" @click="openDeleteModal = false"></div>

                                            <!-- Dialog content -->
                                            <div class="relative top-40 mx-auto p-5 border w-1/3 shadow-lg rounded-md bg-white"
                                                @click.stop>
                                                <div class="mt-3 text-center">
                                                    <div
                                                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                                                        <svg class="h-6 w-6 text-red-600"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-xl leading-6 font-semibold text-gray-900">
                                                        Delete
                                                        Assessment</h3>
                                                    <p class="text-base mt-1 text-gray-600">
                                                        Are you sure you want to delete this assessment for:
                                                    </p>
                                                    <div class="mt-2 px-7 py-3">
                                                        <p class="font-medium text-gray-800 mt-3">
                                                            {{ $assessment->siswa->nama ?? 'N/A' }} -
                                                            {{ $assessment->category->nama ?? 'N/A' }}
                                                        </p>
                                                        <p class="text-base text-gray-600 mt-1">
                                                            This action can't be undone.
                                                        </p>
                                                    </div>
                                                    <div class="flex justify-center mt-4 gap-4">
                                                        <form
                                                            action="{{ route('staff.extrakurikuler.delete-assessment', $assessment->id) }}"
                                                            method="POST" class="inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="confirm-delete-btn px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                                Delete
                                                            </button>
                                                        </form>
                                                        <button type="button" @click="openDeleteModal = false"
                                                            class="px-4 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Delete Confirmation Modal -->
                                    </div>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-tables>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('input[name="predicate"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove styling from all labels in the same form
            const form = this.closest('form');
            form.querySelectorAll('input[name="predicate"]').forEach(r => {
                r.closest('label').classList.remove('bg-blue-50',
                    'border-blue-500');
                r.closest('label').classList.add('hover:bg-gray-50');
            });

            // Add styling to selected label
            if (this.checked) {
                this.closest('label').classList.add('bg-blue-50', 'border-blue-500');
                this.closest('label').classList.remove('hover:bg-gray-50');
            }
        });
    });

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = this.querySelector('.confirm-delete-btn');

            // Show loading state without disabling the button
            // which would prevent form submission
            button.innerHTML =
                '<svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Deleting...';

            // Let form submit complete - don't use disabled=true
            return true;
        });
    });

    document.querySelectorAll('.edit-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = this.querySelector('.update-btn');

            // Show loading state without disabling the button
            button.innerHTML =
                '<svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Updating...';
        });
    });
</script>
@endpush
@endsection