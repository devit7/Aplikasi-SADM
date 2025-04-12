@extends('layouts.main-walas')

@section('content')
<div class="container">
    <h1 class="mb-4">Absen</h1>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Daftar Presensi</h5>
            <p class="text-center">Tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</p>

            <form action="{{ route('walas.manajemen-absen.simpan') }}" method="POST" id="presensiForm">
                @csrf
                <input type="hidden" name="presensi_id" value="{{ $presensi->id }}">
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="80">No</th>
                                <th>Nama</th>
                                <th width="400">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detailPresensi as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}.</td>
                                <td>{{ $detail->siswa->nama }}</td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="siswa_status[{{ $detail->siswa_id }}]" 
                                                id="masuk_{{ $detail->siswa_id }}" 
                                                value="masuk" 
                                                {{ $detail->status == 'masuk' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="masuk_{{ $detail->siswa_id }}">Masuk</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="siswa_status[{{ $detail->siswa_id }}]" 
                                                id="sakit_{{ $detail->siswa_id }}" 
                                                value="sakit" 
                                                {{ $detail->status == 'sakit' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sakit_{{ $detail->siswa_id }}">Sakit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="siswa_status[{{ $detail->siswa_id }}]" 
                                                id="izin_{{ $detail->siswa_id }}" 
                                                value="izin" 
                                                {{ $detail->status == 'izin' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="izin_{{ $detail->siswa_id }}">Izin</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="siswa_status[{{ $detail->siswa_id }}]" 
                                                id="alpha_{{ $detail->siswa_id }}" 
                                                value="alpha" 
                                                {{ $detail->status == 'alpha' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="alpha_{{ $detail->siswa_id }}">Alpha</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-success" id="simpanBtn">Simpan Presensi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<x-confirmation-modal id="confirmationModal" title="Konfirmasi">
    <p class="text-center">Apakah anda yakin menyimpan presensi?</p>
    
    <x-slot:footer>
        <div class="d-flex justify-content-center w-100">
            <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-success" id="confirmSimpan">Simpan</button>
        </div>
    </x-slot:footer>
</x-confirmation-modal>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const simpanBtn = document.getElementById('simpanBtn');
        const confirmSimpan = document.getElementById('confirmSimpan');
        const presensiForm = document.getElementById('presensiForm');
        
        simpanBtn.addEventListener('click', function() {
            // Show confirmation modal
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();
        });
        
        confirmSimpan.addEventListener('click', function() {
            // Submit the form
            presensiForm.submit();
        });
    });
</script>
@endpush