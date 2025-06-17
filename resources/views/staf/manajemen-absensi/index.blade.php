@extends('layouts.main-staf')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 ml-1">Absensi</h1>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
        <button type="button" class="absolute top-0 right-0 px-4 py-3" data-bs-dismiss="alert" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M6.293 6.293a1 1 0 011.414 0L10 8.586l2.293-2.293a1 1 0 111.414 1.414L11.414 10l2.293 2.293a1 1 0 01-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 10 6.293 7.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    @endif

    @if (session('info'))
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('info') }}</span>
        <button type="button" class="absolute top-0 right-0 px-4 py-3" data-bs-dismiss="alert" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M6.293 6.293a1 1 0 011.414 0L10 8.586l2.293-2.293a1 1 0 111.414 1.414L11.414 10l2.293 2.293a1 1 0 01-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 10 6.293 7.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    @endif

    <!-- Buat Presensi Card -->
    <div class="bg-gradient-to-r from-blue-500 to-green-500 rounded-lg shadow-md mb-6">
        <div class="p-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <div class="text-white">
                    <h3 class="font-semibold text-lg">Presensi Hari Ini</h3>
                    <p class="text-sm opacity-80">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, DD MMM YYYY') }}
                    </p>
                    <!-- Tambahan info kelas untuk Staff -->
                    <p class="text-xs opacity-70">
                        Kelas: {{ $kelas->nama_kelas ?? 'Tidak ada kelas' }}
                    </p>
                </div>
            </div>

            @if ($presensiHariIni)
            <div class="flex items-center space-x-3">
                @if ($presensiHariIni->status == 'belum_diabsen')
                <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">
                    Belum Selesai
                </span>
                <a href="{{ route('staff.manajemen-absen.show', $presensiHariIni->tanggal) }}"
                    class="bg-white text-blue-600 hover:bg-gray-50 font-medium py-2 px-4 rounded-md shadow transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50">
                    Lanjutkan
                </a>
                @else
                <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                    Sudah Selesai
                </span>
                @endif
            </div>
            @else
            <form action="{{ route('staff.manajemen-absen.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                <input type="hidden" name="tanggal" value="{{ now()->format('Y-m-d') }}">
                <input type="hidden" name="status" value="belum_diabsen">
                <span class="bg-red-100 mr-2 text-red-800 text-sm font-medium px-3 py-1 rounded-full">
                    Belum Buat Presensi
                </span>
                <button type="submit"
                    class="bg-white text-blue-600 hover:bg-gray-50 font-medium py-2 px-4 rounded-md shadow transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50">
                    Mulai Presensi
                </button>
            </form>
            @endif
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
                            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="w-full md:w-1/4">
                        <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                            Akhir:</label>
                        <input type="text" id="endDate"
                            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap border text-center">
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium border text-center">
                                <a href="{{ route('staff.manajemen-absen.show', $item->tanggal) }}"
                                    class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-md">
                                    ✏️
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4"
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
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