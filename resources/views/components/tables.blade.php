@push('styles')
<link href="{{ asset('data_tables/datatables.min.css') }}" rel="stylesheet">
@endpush

{{ $slot }}

@push('scripts')
<script src="{{ asset('data_tables/datatables.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableId = 'table';
        // Destroy existing instance if it exists
        if ($.fn.DataTable.isDataTable('#' + tableId)) {
            $('#' + tableId).DataTable().destroy();
        }

        // Initialize DataTable
        $('#' + tableId).DataTable({
            "pageLength": 10,
            "searching": true,
            "ordering": true,
            "order": [
                [0, 'desc']
            ],
            "responsive": true,
            "language": {
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
    });
</script>
@endpush