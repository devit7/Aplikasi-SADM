@extends('layouts.main-walas')

@section('content')
<div class="container">
    <h1 class="mb-4">Absen</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title text-center">Buat Presensi</h5>
            <form action="{{ route('walas.manajemen-absen.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Pilih Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn btn-success">Buat Presensi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Daftar Presensi</h5>
            
            <div class="row mb-3">
                <div class="col-md-2">
                    <select class="form-select" id="entries-select">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span>entries per page</span>
                </div>
                <div class="col-md-4 ms-auto">
                    <div class="input-group">
                        <span class="input-group-text">Search:</span>
                        <input type="text" class="form-control" id="search-input">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="sortable" data-sort="tanggal">Tanggal <i class="fas fa-sort"></i></th>
                            <th class="sortable" data-sort="hari">Hari <i class="fas fa-sort"></i></th>
                            <th class="sortable" data-sort="status">Status <i class="fas fa-sort"></i></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($presensi as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd') }}</td>
                            <td>
                                @if($item->status == 'belum_diabsen')
                                <span class="badge bg-warning">Belum diabsen</span>
                                @else
                                <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('walas.manajemen-absen.show', $item->tanggal) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data presensi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p>Showing {{ $presensi->firstItem() ?? 0 }} to {{ $presensi->lastItem() ?? 0 }} of {{ $presensi->total() ?? 0 }} entries</p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            @if($presensi->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo;</span>
                                </li>
                                <li class="page-item disabled">
                                    <span class="page-link">&lt;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $presensi->url(1) }}" aria-label="First">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $presensi->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&lt;</span>
                                    </a>
                                </li>
                            @endif

                            @for($i = 1; $i <= $presensi->lastPage(); $i++)
                                <li class="page-item {{ $i == $presensi->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $presensi->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if($presensi->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $presensi->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">&gt;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $presensi->url($presensi->lastPage()) }}" aria-label="Last">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">&gt;</span>
                                </li>
                                <li class="page-item disabled">
                                    <span class="page-link">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Entries per page
        const entriesSelect = document.getElementById('entries-select');
        entriesSelect.addEventListener('change', function() {
            window.location.href = `{{ route('walas.manajemen-absen') }}?per_page=${this.value}`;
        });
    });
</script>
@endpush