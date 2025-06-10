@extends('layouts.main-staf')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="w-24 mx-1 border-collapse border rounded-md bg-red-600 hover:bg-red-500 p-2 text-center mb-2">
        <a href="{{ route('staff.dashboard') }}" class="text-white hover:text-gray-100 font-medium text-base">
            < Kembali</a>
    </div>
    <h1 class="text-2xl font-bold mb-6 ml-1">Absensi</h1>

    @if (session('success'))
    <div class="bg-green-100 border border-green-40 text-green-700 px-4 py-3 rounded relative mb-4" role="alert" id="success-alert">
        <span class="block font-semibold sm:inline">{{ session('success') }}</span>
        <button type="button" class="absolute top-1/2 right-2 transform -translate-y-1/2 px-4 py-3" onclick="document.getElementById('success-alert').remove()">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M6.293 6.293a1 1 0 011.414 0L10 8.586l2.293-2.293a1 1 0 111.414 1.414L11.414 10l2.293 2.293a1 1 0 01-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 10 6.293 7.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert" id="error-alert">
        <span class="block sm:inline font-semibold">{{ session('error') }}</span>
        <button type="button" class="absolute top-1/2 right-2 transform -translate-y-1/2 px-4 py-3" onclick="document.getElementById('error-alert').remove()">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M6.293 6.293a1 1 0 011.414 0L10 8.586l2.293-2.293a1 1 0 111.414 1.414L11.414 10l2.293 2.293a1 1 0 01-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 10 6.293 7.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    @endif

    <!-- Buat Presensi Card -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-center mb-4">Buat Presensi</h2>
            <form action="{{ route('staff.manajemen-absen.store') }}" method="POST">
                @csrf
                <div class="flex flex-col md:flex-row md:items-end">
                    <div class="flex-1 mb-4 md:mb-0">
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Pilih Tanggal</label>
                        <input type="date"
                            class="w-full px-3 py-2 border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                            id="tanggal" name="tanggal" required>
                    </div>
                    <div class="md:ml-4">
                        <button type="submit"
                            class="w-full md:w-auto px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Buat Presensi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Presensi Card -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-center mb-6">Daftar Presensi</h2>

            <div class="mb-4">
                <div class="flex flex-col md:flex-row md:space-x-2">
                    <div class="w-full md:w-1/4">
                        <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                            Awal:</label>
                        <input type="text" id="startDate"
                            class="px-3 py-2 border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="w-full md:w-1/4">
                        <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                            Akhir:</label>
                        <input type="text" id="endDate"
                            class="px-3 py-2 border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-lg p-1 gap-1">
                <table class="w-full rounded-md mx-3 py-2" id="absenTable">
                    <thead>
                        <tr class="bg-gray-200">
                            <th
                                class="border px-6 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Tanggal</th>
                            <th
                                class="border px-6 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Hari</th>
                            <th
                                class="border px-6 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="border px-6 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($presensi as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 whitespace-wrap font-medium text-base border text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                            </td>
                            <td class="p-3 whitespace-wrap font-medium text-base border text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd') }}
                            </td>
                            <td class="p-3 whitespace-wrap font-medium text-base border text-center">
                                @if ($item->status == 'belum_diabsen')
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Belum diabsen
                                </span>
                                @else
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Selesai
                                </span>
                                @endif
                            </td>
                            <td class="p-3 whitespace-wrap font-medium text-base border text-center">
                                <a href="{{ route('staff.manajemen-absen.show', $item->tanggal) }}"
                                    class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-md">
                                    ✏️
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4"
                                class="px-6 py-6 whitespace-nowrap text-medium text-base text-gray-500 text-center">
                                Tidak ada data presensi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize date inputs
        let minDate = new DateTime('#startDate', {
            format: 'DD/MM/YYYY'
        });
        let maxDate = new DateTime('#endDate', {
            format: 'DD/MM/YYYY'
        });

        // Destroy existing DataTable if it exists
        if ($.fn.DataTable.isDataTable('#absenTable')) {
            $('#absenTable').DataTable().destroy();
        }

        // Initialize DataTable
        let table = $('#absenTable').DataTable({
            order: [
                [0, 'desc']
            ],
            pageLength: 10,
            responsive: true,
            language: {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });

        // Custom date range filter
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            let min = minDate.val();
            let max = maxDate.val();
            let date = moment(data[0], 'DD/MM/YYYY');

            if (
                (min === null && max === null) ||
                (min === null && date <= moment(max)) ||
                (moment(min) <= date && max === null) ||
                (moment(min) <= date && date <= moment(max))
            ) {
                return true;
            }
            return false;
        });

        // Redraw table when date inputs change
        $('#startDate, #endDate').on('change', function() {
            table.draw();
        });
    });
</script>
@endpush