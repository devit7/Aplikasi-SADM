@extends('layouts.main-staf')

@section('content')
<div class="w-full bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Extrakurikuler - Assessment</h1>

    <div class="bg-white p-6 shadow-md rounded-lg">
        @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
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
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('staff.extrakurikuler.store-new-assessment') }}" method="POST" class="space-y-6"
            id="assessmentForm">
            @csrf
            <!-- Two-column layout for larger screens -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left column -->
                <div class="space-y-6">
                    <!-- Category Selection -->
                    <div>
                        <label for="category_id" class="block text-base font-medium text-gray-700 mb-1">Category
                            <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <select id="category_id" name="category_id"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm"
                                required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                        <p id="outlined_error_help" class="mt-2 text-xs text-red-700">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Student Selection -->
                    <div>
                        <label for="siswa_id" class="block text-base font-medium text-gray-700 mb-1">Student<span
                                class="text-red-600">*</span></label>
                        <div class="relative">
                            <select id="siswa_id" name="siswa_id"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm cursor-not-allowed"
                                required disabled>
                                <option value="">Select Category first</option>
                            </select>
                            <!-- Loading indicator -->
                            <div id="student-loading" class="hidden absolute right-5 top-3">
                                <svg class="animate-spin h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        @error('siswa_id')
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
                        <label class="block text-sm font-medium text-gray-700 mb-3">Predicate<span
                                class="text-red-600">*</span></label>
                        <div class="grid grid-cols-4 gap-2" id="predicate-container">
                            @foreach (['A', 'B', 'C', 'D'] as $predicate)
                            <label
                                class="inline-flex items-center border rounded-md p-2 cursor-not-allowed bg-gray-100 opacity-50 predicate-label">
                                <input type="radio" name="predicate" value="{{ $predicate }}"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                    {{ old('predicate') == $predicate || ($loop->first && old('predicate') === null) ? 'checked' : '' }}
                                    required disabled>
                                <span class="ml-2 text-sm">{{ $predicate }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('predicate')
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
                        class="shadow-sm p-4 font-medium text-gray-700 border bg-gray-100 cursor-not-allowed focus:outline-none focus:ring-gray-500 focus:border-gray-500 block w-full sm:text-base rounded-md"
                        placeholder="Select category first to enable this field" disabled>{{ old('explanation') }}</textarea>
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
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-400">
                <a href="{{ route('staff.extrakurikuler.index') }}"
                    class="px-4 py-2 text-base font-medium bg-red-600 text-white hover:text-gray-100 rounded-md hover:bg-red-500">
                    Cancel
                </a>
                <button type="submit" id="submit-btn"
                    class="px-4 py-2 text-base font-medium bg-gray-400 text-white rounded-md cursor-not-allowed"
                    disabled>
                    Save Assessment
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category_id');
        const studentSelect = document.getElementById('siswa_id');
        const explanationTextarea = document.getElementById('explanation');
        const predicateContainer = document.getElementById('predicate-container');
        const predicateLabels = predicateContainer.querySelectorAll('.predicate-label');
        const predicateInputs = predicateContainer.querySelectorAll('input[name="predicate"]');
        const submitBtn = document.getElementById('submit-btn');
        const studentLoading = document.getElementById('student-loading');

        // Function to enable/disable form elements
        function toggleFormElements(enabled) {
            // Student select
            studentSelect.disabled = !enabled;
            studentSelect.classList.toggle('bg-gray-100', !enabled);
            studentSelect.classList.toggle('cursor-not-allowed', !enabled);
            studentSelect.classList.toggle('bg-white', enabled);
            studentSelect.classList.toggle('cursor-pointer', enabled);

            // Predicate radio buttons
            predicateInputs.forEach(input => {
                input.disabled = !enabled;
            });
            predicateLabels.forEach(label => {
                label.classList.toggle('cursor-not-allowed', !enabled);
                label.classList.toggle('bg-gray-100', !enabled);
                label.classList.toggle('opacity-50', !enabled);
                label.classList.toggle('cursor-pointer', enabled);
                label.classList.toggle('hover:bg-gray-50', enabled);
            });

            // Explanation textarea
            explanationTextarea.disabled = !enabled;
            explanationTextarea.classList.toggle('bg-gray-100', !enabled);
            explanationTextarea.classList.toggle('cursor-not-allowed', !enabled);
            explanationTextarea.classList.toggle('bg-white', enabled);

            if (!enabled) {
                explanationTextarea.placeholder = 'Select category first to enable this field';
            } else {
                explanationTextarea.placeholder = 'Add details about the student\'s performance';
            }

            // Submit button
            submitBtn.disabled = !enabled;
            submitBtn.classList.toggle('bg-gray-400', !enabled);
            submitBtn.classList.toggle('cursor-not-allowed', !enabled);
            submitBtn.classList.toggle('bg-green-700', enabled);
            submitBtn.classList.toggle('hover:bg-green-600', enabled);
        }

        // Function to check if form is valid
        function checkFormValidity() {
            const categorySelected = categorySelect.value !== '';
            const studentSelected = studentSelect.value !== '';
            const predicateSelected = document.querySelector('input[name="predicate"]:checked') !== null;
            const explanationFilled = explanationTextarea.value.trim() !== '';

            const isValid = categorySelected && studentSelected && predicateSelected && explanationFilled;

            submitBtn.disabled = !isValid;
            submitBtn.classList.toggle('bg-gray-400', !isValid);
            submitBtn.classList.toggle('cursor-not-allowed', !isValid);
            submitBtn.classList.toggle('bg-green-700', isValid);
            submitBtn.classList.toggle('hover:bg-green-600', isValid);
        }

        // Category change handler
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;

            if (categoryId) {
                // Show loading indicator
                studentLoading.classList.remove('hidden');

                // Reset student select
                studentSelect.innerHTML = '<option value="">Loading students...</option>';
                studentSelect.disabled = true;

                // Fetch students for selected category
                fetch(
                        `{{ route('staff.extrakurikuler.students-by-category') }}?category_id=${categoryId}`
                    )
                    .then(response => response.json())
                    .then(data => {
                        studentLoading.classList.add('hidden');

                        if (data.error) {
                            console.error('Error:', data.error);
                            studentSelect.innerHTML =
                                '<option value="">Error loading students</option>';
                            return;
                        }

                        // Populate student options
                        studentSelect.innerHTML = '<option value="">Select Student</option>';
                        if (data.students.length === 0) {
                            studentSelect.innerHTML = '<option value="">No students available for assessment</option>';
                        } else {
                            data.students.forEach(student => {
                                const option = document.createElement('option');
                                option.value = student.id;
                                option.textContent = `${student.nama} (${student.nisn})`;
                                studentSelect.appendChild(option);
                            });
                        }

                        // Enable form elements
                        toggleFormElements(true);
                        checkFormValidity();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        studentLoading.classList.add('hidden');
                        studentSelect.innerHTML =
                            '<option value="">Error loading students</option>';
                    });
            } else {
                // Reset and disable form elements
                studentSelect.innerHTML = '<option value="">Select Category first</option>';
                toggleFormElements(false);
                checkFormValidity();
            }
        });

        // Add event listeners for form validation
        studentSelect.addEventListener('change', checkFormValidity);
        explanationTextarea.addEventListener('input', checkFormValidity);

        predicateInputs.forEach(input => {
            input.addEventListener('change', function() {
                checkFormValidity();

                // Update visual styling for predicate selection
                predicateLabels.forEach(label => {
                    label.classList.remove('bg-blue-50', 'border-blue-500');
                    label.classList.add('hover:bg-gray-50');
                });

                if (this.checked && !this.disabled) {
                    this.closest('label').classList.add('bg-blue-50', 'border-blue-500');
                    this.closest('label').classList.remove('hover:bg-gray-50');
                }
            });
        });

        // Form submit handler
        document.getElementById('assessmentForm').addEventListener('submit', function() {
            const submitButton = submitBtn;
            submitButton.disabled = true;
            submitButton.innerHTML =
                '<svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">' +
                '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>' +
                '<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>' +
                '</svg> Saving...';
        });

        // Initial form state check
        if (categorySelect.value) {
            categorySelect.dispatchEvent(new Event('change'));
        } else {
            toggleFormElements(false);
        }
    });
</script>
@endpush
@endsection