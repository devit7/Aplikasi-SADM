@extends('layouts.nilai-kehadiran-ortu')
@section('nilai-kehadiran-content')
    <div class="text-center my-4 print:hidden">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
            <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print Report Card
        </button>
    </div>
    <!-- Main container for the report card -->
    <div class="report-card">
        <!-- Header Section -->
        <header class="pb-4">
            <div class="flex justify-between items-center">
                <!-- Left Logo -->
                <div class="w-24 h-24 flex items-center justify-center">

                     <img src="{{ asset('img/muhammadiyah_logo.jpg') }}" alt="School Logo" class="max-w-full max-h-full">
                </div>

                <!-- School Information -->
                    <div class="text-center">
                        <h1 class="text-sm">MAJELIS PENDIDIKAN DASAR DAN MENENGAH</h1>
                        <h2 class="text-sm">PIMPINAN CABANG MUHAMMADIYAH WONOKROMO</h2>
                        <h3 class="text-xl font-bold">SD MUHAMMADIYAH 6 GADUNG</h3>
                        <p class="text-sm italic">Qur'anic & International Insight</p>
                        <p class="text-sm">"Terakreditasi A"</p>
                    </div>
                    <!-- Right Logo -->
                    <div class="w-32 flex items-center justify-center">
                        <img src="{{ asset('img/cambridge_logo.png') }}" alt="Cambridge Assessment Logo" class="max-w-full max-h-full">
                    </div>
                </div>
                <div class="border-2 border-black w-content w-full">
                    <p class="text-xs text-center font-narrow">Office : Jl. Gadung III/ 7 Telp (031) 8416195 Surabaya 60244 Jawa Timur </p>
                </div>
            <h4 class="text-center font-bold text-lg mt-4">MID-SEMESTER STUDY REPORT</h4>
        </header>

        <!-- Student Information Section -->
        <section class="mt-6">
            <div class="grid grid-cols-[1fr_3fr] gap-y-2 max-w-md">
                <div class="text-sm">Name</div>
                <div>:  </div>
                <div class="text-sm">NISN/NIS</div>
                <div>:  </div>
                <div class="text-sm">Grade/Fase</div>
                <div>:  </div>
                <div class="text-sm">Semester</div>
                <div>:  </div>
                <div class="text-sm">Academic Year</div>
                <div>:  </div>
            </div>
        </section>

        <!-- Main Subjects Table -->
        <section class="mt-6">
            <table class="bordered-table">
                <thead>
                    <tr>
                        <th class="w-[5%]">No.</th>
                        <th class=" w-2/6 ">Subjects</th>
                        <th class=" w-[14%]">Final Score</th>
                        <th>Description of Learning Achievements</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>Islamic Education</td>
                        <td class="text-center"></td>
                        <td class="text-sm">Show good understanding in reading, memorizing, understanding verses of Ad Dhuha, Al Lail, As Syam, Asmaul Husna, Akhlakul karimah, Jum'at praying, tahajud praying, and other sunnah praying and also the history of Prophet Muhammad also able to apply in life.</td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>PPKn/ Civic</td>
                        <td class="text-center"></td>
                        <td class="text-sm">Has good understanding in village and Sub-District Government, need assistance in "Bhinneka Tunggal Ika".</td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>Indonesian</td>
                        <td class="text-center"></td>
                        <td class="text-sm">Has good understanding in "informasi teks" and "Unsur Intrisik Cerita".</td>
                    </tr>
                    <tr>
                        <td class="text-center">10</td>
                        <td>English/ Writting</td>
                        <td class="text-center"></td>
                        <td class="text-sm">Has mastered in quantitative pronoun and quantifiers, need assistance in modal verb and connectives.</td>
                    </tr>
                    <tr>
                         <td class="text-center"></td>
                        <td>English/ Reading</td>
                        <td class="text-center"></td>
                        <td class="text-sm">Need assistance in understanding the reading text..</td>
                    </tr>
                    <tr>
                         <td class="text-center"></td>
                        <td>English/ Listening</td>
                        <td class="text-center"></td>
                        <td class="text-sm">Has good skill in understanding the native speakers.</td>
                    </tr>
                     <tr>
                         <td class="text-center"></td>
                        <td>English/ Speaking</td>
                        <td class="text-center"></td>
                        <td class="text-sm">Has good speaking skill in english</td>
                    </tr>
                    <tr>
                        <td class="text-center">11</td>
                        <td>Arabic</td>
                        <td class="text-center"></td>
                        <td class="text-sm">Show the mastery in using question word, need assistance in family and jobs.</td>
                    </tr>
                    <tr>
                        <td class="text-center">12</td>
                        <td>Java</td>
                        <td class="text-center"></td>
                        <td class="text-sm">Had mastered "Unggah Ungguh Basa", need assistance in "Aksara Jawa".</td>
                    </tr>
                    <tr>
                        <td class="text-center">13</td>
                        <td>Kemuhammadiyahan</td>
                        <td class="text-center"></td>
                        <td class="text-sm">Show the mastery in understanding Muhammadiyah movement, Muhammadiyah otonomous organization and its symbols, also able to apply in life.</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="mt-6 space-y-6">
            <!-- Al-Quran Learning -->
            <div>
                 <table class="bordered-table">
                    <thead>
                        <tr>
                            <th colspan="2" class=" w-[39%]">Al-Quran Learning</th>
                            <th class=" w-[14%] ">Predicate</th>
                            <th class=" w-3/6 ">Explainations</th>
                        </tr>
                        <tr>
                            <td class="w-[5%]">12</td>
                            <td class="font-bold">Tartil Al-Qur'an</td>
                            <td class="text-center"></td>
                            <td></td>
                        </tr>
                         <tr>
                            <td class="w-[5%]"></td>
                            <td class="pl-8">Jilid 5</td>
                            <td class="text-center font-bold"></td>
                             <td></td>
                        </tr>
                         <tr>
                            <td class="w-[5%]">13</td>
                            <td class="font-bold">Tahfidz Al-Qur'an</td>
                             <td class="text-center"></td>
                             <td></td>
                        </tr>
                         <tr>
                            <td class="w-[5%]"></td>
                            <td class="pl-8">Al-Gosiyyah</td>
                             <td class="text-center font-bold"></td>
                             <td></td>
                        </tr>
                    </thead>
                 </table>
                 <p class="text-center font-cursive mt-2 text-2xl border-[3px] border-black">Has a good achivement to reach the target of the class</p>
            </div>

            <!-- Extrakurikuler -->
            <div>
                 <table class="bordered-table">
                    <thead>
                        <tr>
                            <th class="w-[5%]">No.</th>
                            <th class="w-2/6">Extrakurikuler</th>
                            <th class=" w-[14%]">Predicate</th>
                            <th class="">Explainations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Science Club</td>
                            <td class="text-center font-bold"></td>
                            <td></td>
                        </tr>
                         <tr>
                            <td class="text-center">2</td>
                            <td>Hizbul Wathan</td>
                            <td class="text-center font-bold"></td>
                            <td></td>
                        </tr>
                         <tr>
                            <td class="text-center">3</td>
                            <td>Robotik</td>
                            <td class="text-center font-bold"></td>
                            <td></td>
                        </tr>
                    </tbody>
                 </table>
            </div>

             <div class="space-y-6">
                 <!-- Worships and Characters -->
                <div>
                     <table class="bordered-table">
                        <thead>
                            <tr>
                                <th class="w-[5%]">No.</th>
                                <th class="w-2/6">Worships and Characters</th>
                                <th class="w-[14%]">Predicate</th>
                                <th>Explainations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Gen-Q Smart</td>
                                <td class="text-center font-bold"></td>
                                <td></td>
                            </tr>
                        </tbody>
                     </table>
                </div>

                 <!-- Presence -->
                 <div class="w-[53%]">
                     <table class="bordered-table">
                        <thead>
                            <tr>
                                <th class="w-[1%]">No.</th>
                                <th class=" w-[34%]">Presence</th>
                                <th class=" w-[10%]">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Sick</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Permission</td>
                                <td></td>
                            </tr>
                             <tr>
                                <td class="text-center">3</td>
                                <td>No Explainations</td>
                                <td></td>
                            </tr>
                        </tbody>
                     </table>
                 </div>
             </div>
        </section>

        <!-- Notes Section -->
        <section class="mt-6">
            <div class="border-2 border-black p-2">
                <span class="font-bold">Notes:</span>
                Otka Mumtazah B. has good understanding in learning "KMD", need assistance to understand long instruction. Less confident when speaking in the front, but started to be confident.
            </div>
        </section>

         <!-- Signature Section -->
        <footer class="mt-12">
            <div class="flex justify-between text-center">
                <div>
                    <p>Known By</p>
                    <p>Student Guardian,</p>
                    <!-- In Laravel, you can have a space for a signature image or just the name -->
                    <div class="mt-20">
                        <p class="border-b-2 border-black">(.............................)</p>
                    </div>
                </div>
                <div>
                    <p>Surabaya, {{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}</p>
                    <p>Class Teacher of IV-ICP</p>
                    <div class="mt-20">
                        <p class="font-bold underline">Puspitawati, S. Pd</p>
                        <p>NBM : 901.747</p>
                    </div>
                </div>
            </div>
        </footer>

    </div>
@endsection

@push('styles')

<style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
        }
        .font-narrow {
            font-family: 'Arial Narrow', sans-serif;
        }
        .font-cursive {
            font-family: 'Brush Script MT', cursive, sans-serif;
        }
        .report-card {
            /* Simulating a standard Letter paper size (8.5in x 11in) with shadow */
            width: 8.5in;
            min-height: 11in;
            margin: 2rem auto;
            padding: 1.5rem;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        /* Custom border styles for tables to match the PDF */
        .bordered-table {
            border-collapse: collapse;
            width: 100%;
        }
        .bordered-table th,
        .bordered-table td {
            border: 2px solid black;
            padding: 8px;
            text-align: left;
        }
        .bordered-table th {
            background-color: #e5e7eb; /* Light gray for headers */
            font-weight: bold;
            text-align: center;
        }
         /* Media query for smaller screens */
        @media (max-width: 8.5in) {
            .report-card {
                width: 100%;
                min-height: auto;
                margin: 0;
                padding: 1rem;
                box-shadow: none;
            }
        }
        @media print {
            body {
                background-color: white;
            }
            .report-card {
                margin: 0;
                box-shadow: none;
                padding: 0;
                width: 100%;
                min-height: auto;
            }
        }
</style>
@endpush

@push('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.13.216/pdf.min.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    const url = "{{ route('ortu.showRaport') }}";

    // Set the workerSrc (important: match the version)
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.13.216/pdf.worker.min.js';

    const container = document.getElementById('pdf-container');

    // Load PDF
    const loadingTask = pdfjsLib.getDocument(url);
    loadingTask.promise.then(function(pdf) {
        console.log('PDF loaded');

        // Loop all pages
        for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
            pdf.getPage(pageNumber).then(function(page) {
                console.log('Page loaded', pageNumber);

                const viewport = page.getViewport({ scale: 1.5 });

                // Create canvas and render
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Center canvas using Tailwind
                canvas.classList.add('mx-auto', 'my-4', 'shadow-md', 'rounded-lg');

                container.appendChild(canvas);

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext);
            });
        }
    }, function(reason) {
        console.error('Error loading PDF: ', reason);
    });
});
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable(); // Initialize the DataTable
        });
    </script> --}}
@endpush
