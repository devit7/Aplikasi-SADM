@extends('layouts.main-staf')

@section('content')
<div class="w-full bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Al-Quran Learning - Assessment</h1>

    <div class="bg-white p-6 shadow-md rounded-lg">
        @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('staff.al-quran.store-new-assessment') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Two-column layout for larger screens -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left column -->
                <div class="space-y-6">
                    <!-- Subcategory Selection -->
                    <div>
                        <label for="sub-Category_id" class="block text-base font-medium text-gray-700 mb-1">Sub-Category
                            <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <select id="subcategory_id" name="subcategory_id"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required>
                                <option value="Undefined">-- Select Data --</option>
                                @foreach ($subcategories->groupBy('category.nama') as $category => $subs)
                                <optgroup label="{{ $category }}">
                                    @foreach ($subs as $subcategory)
                                    <option value="{{ $subcategory->id }}"
                                        {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->sub_nama }}
                                    </option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                        @error('subcategory_id')
                        <p id="outlined_error_help" class="mt-2 text-xs text-red-700">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Student Selection -->
                    <div>
                        <label for="siswa_id" class="block text-base font-medium text-gray-700 mb-1">Student <span
                                class="text-red-600">*</span></label>
                        <div class="relative">
                            <select id="siswa_id" name="siswa_id"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required>
                                <option value="">-- Select Data --</option>
                                @foreach ($students as $student)
                                <option value="{{ $student->id }}"
                                    {{ old('siswa_id') == $student->id ? 'selected' : '' }}>{{ $student->nama }}
                                    ({{ $student->nisn }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('subcategory_id')
                        <p id="outlined_error_help" class="mt-2 text-xs text-red-700">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <!-- Right column -->
                <div class="space-y-6">
                    <!-- Predicate Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Predicate <span
                                class="text-red-600">*</span></label>
                        <div class="grid grid-cols-5 gap-2">
                            @foreach (['A', 'B', 'C', 'D', 'E'] as $predicate)
                            <label
                                class="inline-flex items-center border rounded-md p-2 cursor-pointer {{ old('predicate') == $predicate ? 'bg-blue-50 border-blue-500' : 'hover:bg-gray-50' }}">
                                <input type="radio" name="predicate" value="{{ $predicate }}"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                    {{ old('predicate') == $predicate || ($loop->first && old('predicate') === null) ? 'checked' : '' }}
                                    required>
                                <span class="ml-2 text-sm">{{ $predicate }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('subcategory_id')
                        <p id="outlined_error_help" class="mt-2 text-xs text-red-700">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Full-width elements -->
            <div class="space-y-6 pt-4">
                <!-- Explanation Field -->
                <div>
                    <label for="explanation" class="block text-base font-medium text-gray-700 mb-1">Explanation<span
                            class="text-red-600">*</span></label>
                    <textarea id="explanation" name="explanation" rows="4"
                        class="shadow-sm p-4 border ring-gray-500 border-gray-500 block w-full sm:text-base rounded-md"
                        placeholder="Add details about the student's performance">{{ old('explanation') }}</textarea>
                    @error('subcategory_id')
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
    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-400">
        <a href="{{ route('staff.al-quran.index') }}"
            class="px-4 py-2 text-base font-medium bg-red-600 text-white hover:text-gray-100 rounded-md hover:bg-red-500">
            Cancel
        </a>
        <button type="submit"
            class="px-4 py-2 text-base font-medium bg-green-700 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
            Save Assessment
        </button>
    </div>
    </form>
</div>
</div>

@push('scripts')
<script>
    // Predicate selection visual enhancement
    const predicateLabels = document.querySelectorAll('input[name="predicate"]');
    predicateLabels.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove styling from all labels
            document.querySelectorAll('input[name="predicate"]').forEach(r => {
                r.closest('label').classList.remove('bg-blue-50', 'border-blue-500');
                r.closest('label').classList.add('hover:bg-gray-50');
            });

            // Add styling to selected label
            if (this.checked) {
                this.closest('label').classList.add('bg-blue-50', 'border-blue-500');
                this.closest('label').classList.remove('hover:bg-gray-50');
            }
        });
    });

    // Show loading state on form submit
    document.querySelector('form').addEventListener('submit', function() {
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML =
            '<svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
    });
</script>
@endpush
@endsection