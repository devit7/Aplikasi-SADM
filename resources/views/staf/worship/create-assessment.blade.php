@extends('layouts.main-staf')

@section('content')
<div class="flex-1 p-6 bg-white text-gray-800 min-h-screen">
   <div class="mb-6 flex items-center">
      <h1 class="text-2xl font-bold">Worship and Character - Assessment</h1>
   </div>

   @if(session('success'))
   <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
      <p>{{ session('success') }}</p>
   </div>
   @endif

   @if(session('error'))
   <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
      <p>{{ session('error') }}</p>
   </div>
   @endif

   <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
      <div class="p-6">
         <form action="{{ route('staff.worship.store-new-assessment') }}" method="POST" class="space-y-6">
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
                     <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                     @enderror
                  </div>

                  <!-- Student Selection -->
                  <div>
                     <label for="siswa_id" class="block text-base font-medium text-gray-700 mb-1">Student<span
                           class="text-red-600">*</span></label>
                     <div class="relative">
                        <select id="siswa_id" name="siswa_id"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm"
                           required>
                           <option value="">Select Student</option>
                           @foreach ($students as $student)
                           <option value="{{ $student->id }}"
                              {{ old('siswa_id') == $student->id ? 'selected' : '' }}>{{ $student->nama }}
                              ({{ $student->nisn }})
                           </option>
                           @endforeach
                        </select>
                     </div>
                     @error('siswa_id')
                     <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                     @enderror
                  </div>
               </div>

               <!-- Right column -->
               <div class="space-y-6">
                  <!-- Predicate Selection -->
                  <div>
                     <label class="block text-sm font-medium text-gray-700 mb-3">Predicate<span
                           class="text-red-600">*</span></label>
                     <div class="grid grid-cols-4 gap-2">
                        @foreach (['A', 'B', 'C', 'D'] as $predicate)
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
                     @error('predicate')
                     <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
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
                     class="shadow-sm p-4 font-medium text-gray-700 border focus:outline-none focus:ring-gray-500 focus:border-gray-500 block w-full sm:text-base rounded-md"
                     placeholder="Add details about the student's worship and character performance">{{ old('explanation') }}</textarea>
                  @error('explanation')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
               </div>

               <!-- Pengajar Field (Read-only) -->
               <div>
                  <label for="created_by" class="block text-base font-medium text-gray-700 mb-1">Pengajar</label>
                  <input type="text" id="created_by" name="created_by"
                     class="shadow-sm p-2 border ring-gray-500 border-gray-500 bg-gray-50 text-gray-500 block w-full sm:text-base rounded-md cursor-not-allowed"
                     value="{{ session('staff')->nama }}" readonly>
               </div>
            </div>

            <!-- Form Buttons -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
               <a href="{{ route('staff.worship.index') }}"
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
</div>

@push('scripts')
<script>
   document.addEventListener('DOMContentLoaded', function() {
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

      // Form validation
      document.querySelector('form').addEventListener('submit', function(e) {
         const categorySelect = document.getElementById('category_id');
         const siswaSelect = document.getElementById('siswa_id');
         const explanation = document.getElementById('explanation');

         if (categorySelect.value === '') {
            e.preventDefault();
            alert('Please select a category');
            categorySelect.focus();
            return false;
         }

         if (siswaSelect.value === '') {
            e.preventDefault();
            alert('Please select a student');
            siswaSelect.focus();
            return false;
         }

         if (!explanation.value.trim()) {
            e.preventDefault();
            alert('Explanation is required');
            explanation.focus();
            return false;
         }

         if (explanation.value.trim().length > 255) {
            e.preventDefault();
            alert('Explanation should not exceed 255 characters');
            explanation.focus();
            return false;
         }

         const predicate = document.querySelector('input[name="predicate"]:checked');
         if (!predicate) {
            e.preventDefault();
            alert('Please select a predicate');
            return false;
         }

         // Show loading state
         const submitButton = this.querySelector('button[type="submit"]');
         submitButton.disabled = true;
         submitButton.innerHTML =
            '<svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
      });
   });
</script>
@endpush
@endsection