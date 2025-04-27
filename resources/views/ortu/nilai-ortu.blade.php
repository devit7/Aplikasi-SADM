@extends('layouts.nilai-kehadiran-ortu')
@section('nilai-kehadiran-content')
    {{-- <x-tables>
    <table class="w-full border-collapse border rounded-md text-sm " id="table">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Mata Pelajaran</th>
                <th class="border p-2">Nilai UTS</th>
                <th class="border p-2">Nilai UAS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matapelajaran as $mapel)
                @php
                    // Find the nilai related to this mata pelajaran
                    $nilaiItem = $nilai->firstWhere('matapelajaran_id', $mapel->id);
                @endphp
                <tr class="text-center">
                    <td class="border p-2">{{ $mapel->nama_mapel }}</td>
                    <td class="border p-2">{{ $nilaiItem->nilai_uts ?? 'N/A' }}</td>
                    <td class="border p-2">{{ $nilaiItem->nilai_uas ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-tables>
<div class="bg-white shadow-lg rounded-xl text-center mr-11 p-1 w-full">
    <div class="text-center flex flex-row justify-between items-center px-6">
        <div class="text-gray-600">Ranking Keseluruhan</div>
        <div class="text-2xl pr-40 font-light ">{{ $studentRanking }}</div>
    </div>

</div> --}}
    {{-- <iframe
src="{{ route("ortu.showReport") }}#toolbar=0&navpanes=0&scrollbar=0"
width="100%"
height="800px"
frameborder="0"
style="border:none;">
</iframe> --}}
<div class="flex justify-center min-h-screen py-8">
    <canvas class="" id="pdf-canvas"></canvas>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script>
        const url = '{{ route('ortu.showRaport') }}'; // Path to your generated PDF file

        // Set up PDF.js worker (to improve performance)
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

        const loadingTask = pdfjsLib.getDocument(url);
        loadingTask.promise.then(function(pdf) {
            console.log('PDF loaded');

            // Fetch the first page
            pdf.getPage(1).then(function(page) {
                console.log('Page loaded');

                const scale = 1.5; // You can adjust this to zoom in/out
                const viewport = page.getViewport({
                    scale: scale
                });

                // Get canvas element and set its dimensions
                const canvas = document.getElementById('pdf-canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render the page into the canvas
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext);
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable(); // Initialize the DataTable
        });
    </script>
@endpush
