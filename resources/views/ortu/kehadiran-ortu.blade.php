@extends('layouts.nilai-kehadiran-ortu')
@section('nilai-kehadiran-content')
    <div class="container mx-auto p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Total Absences -->
            <div class="bg-white shadow-lg rounded-2xl p-6 text-center">
                <h2 class="text-xl font-semibold">Masuk</h2>
                <p class="text-3xl font-bold text-blue-500">{{ $statusCount['masuk'] }}</p>
            </div>

            <!-- Excused Absences -->
            <div class="bg-white shadow-lg rounded-2xl p-6 text-center">
                <h2 class="text-xl font-semibold">Izin</h2>
                <p class="text-3xl font-bold text-green-500">{{ $statusCount['izin'] }}</p>
            </div>

            <!-- Unexcused Absences -->
            <div class="bg-white shadow-lg rounded-2xl p-6 text-center">
                <h2 class="text-xl font-semibold">Sakit</h2>
                <p class="text-3xl font-bold text-yellow-500">{{ $statusCount['sakit'] }}</p>
            </div>

            <!-- Late Arrivals -->
            <div class="bg-white shadow-lg rounded-2xl p-6 text-center">
                <h2 class="text-xl font-semibold">Alpha</h2>
                <p class="text-3xl font-bold text-red-500">{{ $statusCount['alpha'] }}</p>
            </div>
            
        </div>
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-center mb-6">Daftar Presensi</h2>

                <div class="mb-4">
                    <div class="flex flex-col md:flex-row md:space-x-2">
                        <div class="w-full md:w-1/4">
                            <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Awal:</label>
                            <input type="text" id="startDate" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="w-full md:w-1/4">
                            <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir:</label>
                            <input type="text" id="endDate" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto bg-white rounded-lg p-1 gap-1">
                    <table class="w-full rounded-md mx-3 py-2" id="absenTable">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-6 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Tanggal</th>
                                <th class="border px-6 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Hari</th>
                                <th class="border px-6 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($absences as $absen)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border text-center">
                                    {{ \Carbon\Carbon::parse($absen->presensi->tanggal)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border text-center">
                                    {{ \Carbon\Carbon::parse($absen->presensi->tanggal)->locale('id')->isoFormat('dddd') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border text-center">
                                    @if (
                                    $absen->status == 'masuk')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $absen->status }}
                                        </span>
                                    @elseif ($absen->status == 'izin')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $absen->status }}
                                        </span>
                                    @elseif ($absen->status == 'sakit')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $absen->status }}
                                        </span>
                                    @elseif ($absen->status == 'alpha')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $absen->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
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
