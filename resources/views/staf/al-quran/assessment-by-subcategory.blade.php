@extends('layouts.main-staf')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
   <div class="flex justify-between items-center mb-6">
      <div>
         <h1 class="text-2xl font-bold">Al-Quran Assessment</h1>
         <p class="text-gray-600">{{ $subcategory->category->nama }} - {{ $subcategory->sub_nama }}</p>
         @if($subcategory->tahun_ajaran)
         <p class="text-sm text-gray-500">Tahun Ajaran: {{ $subcategory->tahun_ajaran }}</p>
         @endif
      </div>
      <a href="{{ route('staff.al-quran.create-assessment') }}?subcategory_id={{ $subcategory->id }}"
         class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
         </svg>
         Tambah Assessment
      </a>
   </div>

   <!-- Students without assessment -->
   @if($students->whereNull('alQuranAssessments.0')->count() > 0)
   <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
      <h3 class="text-lg font-semibold text-yellow-800 mb-2">Siswa Belum Dinilai</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
         @foreach($students->whereNull('alQuranAssessments.0') as $student)
         <div class="bg-white border border-yellow-300 rounded-md p-3">
            <p class="font-medium text-gray-900">{{ $student->nama }}</p>
            <p class="text-sm text-gray-600">{{ $student->nisn }}</p>
         </div>
         @endforeach
      </div>
   </div>
   @endif

   <!-- Assessments Table -->
   <div class="bg-white shadow rounded-lg">
      <div class="p-4 border-b border-gray-200">
         <h2 class="text-lg font-semibold">Daftar Assessment</h2>
      </div>
      <div class="overflow-x-auto p-4">
         @if($assessments->count() > 0)
         <table class="w-full border rounded-md border-collapse text-sm" id="assessmentTable">
            <thead>
               <tr class="bg-gray-50 border-b">
                  <th class="p-3 text-left font-medium text-gray-600">No</th>
                  <th class="p-3 text-left font-medium text-gray-600">Siswa</th>
                  <th class="p-3 text-left font-medium text-gray-600">NISN</th>
                  <th class="p-3 text-left font-medium text-gray-600">Predicate</th>
                  <th class="p-3 text-left font-medium text-gray-600">Explanation</th>
                  <th class="p-3 text-left font-medium text-gray-600">Tanggal</th>
                  <th class="p-3 text-left font-medium text-gray-600">Aksi</th>
               </tr>
            </thead>
            <tbody>
               @foreach($assessments as $index => $assessment)
               <tr class="border-b hover:bg-gray-50">
                  <td class="p-3">{{ $index + 1 }}</td>
                  <td class="p-3 font-medium">{{ $assessment->siswa->nama }}</td>
                  <td class="p-3">{{ $assessment->siswa->nisn }}</td>
                  <td class="p-3">
                     <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                {{ $assessment->predicate == 'A' ? 'bg-green-100 text-green-800' : 
                                   ($assessment->predicate == 'B' ? 'bg-blue-100 text-blue-800' : 
                                   ($assessment->predicate == 'C' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($assessment->predicate == 'D' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'))) }}">
                        {{ $assessment->predicate }}
                     </span>
                  </td>
                  <td class="p-3 max-w-xs truncate">{{ $assessment->explanation }}</td>
                  <td class="p-3">{{ $assessment->created_at->format('d/m/Y') }}</td>
                  <td class="p-3">
                     <div class="flex space-x-2">
                        <!-- Edit and Delete buttons -->
                        <button class="text-blue-600 hover:text-blue-900">Edit</button>
                        <button class="text-red-600 hover:text-red-900">Delete</button>
                     </div>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         @else
         <div class="text-center py-8">
            <p class="text-gray-500">Belum ada assessment untuk subcategory ini</p>
         </div>
         @endif
      </div>
   </div>
</div>

@push('scripts')
<script>
   $(document).ready(function() {
      if (!$.fn.DataTable.isDataTable('#assessmentTable')) {
         $('#assessmentTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "responsive": true,
            "language": {
               "paginate": {
                  "previous": "Sebelumnya",
                  "next": "Selanjutnya",
               }
            }
         });
      }
   });
</script>
@endpush
@endsection