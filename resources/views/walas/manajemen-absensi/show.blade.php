@extends('layouts.main-walas')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Absen</h1>

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
        <button type="button" class="absolute top-0 right-0 px-4 py-3" data-bs-dismiss="alert" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6.293 6.293a1 1 0 011.414 0L10 8.586l2.293-2.293a1 1 0 111.414 1.414L11.414 10l2.293 2.293a1 1 0 01-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 10 6.293 7.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-center mb-2">Daftar Presensi</h2>
            <p class="text-center text-gray-600 mb-6">Tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</p>

            <form action="{{ route('walas.manajemen-absen.simpan') }}" method="POST" id="presensiForm">
                @csrf
                <input type="hidden" name="presensi_id" value="{{ $presensi->id }}">
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keterangan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($detailPresensi as $index => $detail)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $index + 1 }}.
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $detail->siswa->nama }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-6">
                                        <div class="flex items-center">
                                            <input id="masuk_{{ $detail->siswa_id }}" 
                                                name="siswa_status[{{ $detail->siswa_id }}]" 
                                                type="radio" 
                                                value="masuk" 
                                                {{ $detail->status == 'masuk' ? 'checked' : '' }}
                                                class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500">
                                            <label for="masuk_{{ $detail->siswa_id }}" class="ml-2 block text-sm text-gray-900">
                                                Masuk
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="sakit_{{ $detail->siswa_id }}" 
                                                name="siswa_status[{{ $detail->siswa_id }}]" 
                                                type="radio" 
                                                value="sakit" 
                                                {{ $detail->status == 'sakit' ? 'checked' : '' }}
                                                class="h-4 w-4 text-yellow-600 border-gray-300 focus:ring-yellow-500">
                                            <label for="sakit_{{ $detail->siswa_id }}" class="ml-2 block text-sm text-gray-900">
                                                Sakit
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="izin_{{ $detail->siswa_id }}" 
                                                name="siswa_status[{{ $detail->siswa_id }}]" 
                                                type="radio" 
                                                value="izin" 
                                                {{ $detail->status == 'izin' ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <label for="izin_{{ $detail->siswa_id }}" class="ml-2 block text-sm text-gray-900">
                                                Izin
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="alpha_{{ $detail->siswa_id }}" 
                                                name="siswa_status[{{ $detail->siswa_id }}]" 
                                                type="radio" 
                                                value="alpha" 
                                                {{ $detail->status == 'alpha' ? 'checked' : '' }}
                                                class="h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500">
                                            <label for="alpha_{{ $detail->siswa_id }}" class="ml-2 block text-sm text-gray-900">
                                                Alpha
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="button" id="simpanBtn" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Simpan Presensi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Using the confirmation-modal component with Tailwind CSS -->
<x-confirmation-modal id="confirmationModal" title="Konfirmasi">
    <p class="text-sm text-gray-500">
        Apakah anda yakin menyimpan presensi?
    </p>
    
    <x-slot name="footer">
        <button type="button" id="confirmSimpan" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
            Simpan
        </button>
        <button type="button" id="cancelSimpan" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-red-700 text-base font-medium text-white hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Batal
        </button>
    </x-slot>
</x-confirmation-modal>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const simpanBtn = document.getElementById('simpanBtn');
        const confirmSimpan = document.getElementById('confirmSimpan');
        const cancelSimpan = document.getElementById('cancelSimpan');
        const presensiForm = document.getElementById('presensiForm');
        const confirmationModal = document.getElementById('confirmationModal');
        
        simpanBtn.addEventListener('click', function() {
            // Show confirmation modal
            confirmationModal.classList.remove('hidden');
        });
        
        confirmSimpan.addEventListener('click', function() {
            // Submit the form
            presensiForm.submit();
        });
        
        cancelSimpan.addEventListener('click', function() {
            // Hide modal
            confirmationModal.classList.add('hidden');
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === confirmationModal) {
                confirmationModal.classList.add('hidden');
            }
        });
    });
</script>
@endpush