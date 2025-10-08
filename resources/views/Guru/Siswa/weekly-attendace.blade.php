@extends('layouts.admin.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Absensi Siswa PKL
                </div>
                <h2 class="page-title">
                    {{ $title }}
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <!-- Week Navigation -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <h3 class="card-title mb-0">
                            Minggu: {{ $startDate->format('d M Y') }} - {{ $startDate->copy()->addDays(6)->format('d M Y') }}
                        </h3>
                    </div>
                    <div class="col-auto ms-auto">
                        <div class="btn-list">
                            <a href="{{ route('weekly.attendance', ['start_date' => $startDate->copy()->subWeek()->format('Y-m-d')] + request()->except('start_date')) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="m0 0h24v24H0z" fill="none"/><path d="m15 6l-6 6l6 6" /></svg>
                                <span class="d-none d-sm-inline">Sebelumnya</span>
                            </a>
                            <a href="{{ route('weekly.attendance', ['start_date' => Carbon\Carbon::now()->startOfWeek()->format('Y-m-d')] + request()->except('start_date')) }}" 
                               class="btn btn-primary btn-sm">
                                Minggu Ini
                            </a>
                            <a href="{{ route('weekly.attendance', ['start_date' => $startDate->copy()->addWeek()->format('Y-m-d')] + request()->except('start_date')) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <span class="d-none d-sm-inline">Selanjutnya</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="m0 0h24v24H0z" fill="none"/><path d="m9 6l6 6l-6 6" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Filter Data</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('weekly.attendance') }}">
                    <input type="hidden" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Cari Siswa</label>
                            <input type="text" class="form-control" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama siswa...">
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Kelas</label>
                            <select class="form-select" name="kelas">
                                <option value="">Semua Kelas</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas }}" {{ ($filters['kelas'] ?? '') == $kelas ? 'selected' : '' }}>
                                        {{ $kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Perusahaan</label>
                            <select class="form-select" name="perusahaan">
                                <option value="">Semua Perusahaan</option>
                                @foreach($perusahaanList as $company)
                                    <option value="{{ $company->id }}" {{ ($filters['perusahaan'] ?? '') == $company->id ? 'selected' : '' }}>
                                        {{ $company->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="btn-list">
                                <button type="submit" class="btn btn-primary w-100">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-12">
                            <a href="{{ route('weekly.attendance', ['start_date' => $startDate->format('Y-m-d')]) }}" class="btn btn-link btn-sm p-0">
                                Reset Filter
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Legend -->
        <div class="card mb-3">
            <div class="card-body py-2">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <span class="text-muted">Keterangan:</span>
                            <span class="text-success fw-bold">Hadir</span>
                            <span class="text-info fw-bold">WFH</span>
                            <span class="text-danger fw-bold">Tidak Hadir</span>
                            <span class="text-warning fw-bold">Izin</span>
                            <span class="text-muted">Belum Absen</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-muted">
                                Total: <strong>{{ $totalSiswa }}</strong> siswa
                            </span>
                            <span class="text-muted">
                                Halaman: <strong>{{ $siswa->currentPage() }}</strong> dari <strong>{{ $siswa->lastPage() }}</strong>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="card-title">Tabel Absensi Mingguan</h3>
                        <p class="card-subtitle">
                            Menampilkan {{ $siswa->firstItem() ?? 0 }} - {{ $siswa->lastItem() ?? 0 }} dari {{ $siswa->total() }} siswa
                        </p>
                    </div>
                    <div class="col-auto">
                        <div class="btn-list">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    {{ $siswa->perPage() }} per halaman
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item {{ request('per_page') == 10 ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['per_page' => 10]) }}">10 per halaman</a></li>
                                    <li><a class="dropdown-item {{ request('per_page', 20) == 20 ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['per_page' => 20]) }}">20 per halaman</a></li>
                                    <li><a class="dropdown-item {{ request('per_page') == 50 ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}">50 per halaman</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th class="w-1">No</th>
                            <th>Siswa</th>
                            <th class="d-none d-md-table-cell">Kelas</th>
                            <th class="d-none d-lg-table-cell">Perusahaan</th>
                            @foreach($weekDates as $date)
                                <th class="text-center" style="min-width: 80px;">
                                    <div class="small fw-bold">{{ $date->format('D') }}</div>
                                    <div class="text-muted small">{{ $date->format('d/m') }}</div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $index => $student)
                            <tr>
                                <td>{{ ($siswa->currentPage() - 1) * $siswa->perPage() + $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div>{{ $student->user->nama }}</div>
                                            <div class="text-muted small d-md-none">{{ $student->kelas }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <span class="badge bg-blue">{{ $student->kelas }}</span>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    {{ $student->perusahaan->nama ?? 'Tidak Ada' }}
                                </td>
                                @foreach($attendanceData[$student->id] as $status)
                                    <td class="text-center">
                                        @if($status == 'Hadir')
                                            <span class="text-success fw-bold">Hadir</span>
                                        @elseif($status == 'WFH')
                                            <span class="text-info fw-bold">WFH</span>
                                        @elseif($status == 'Tidak Hadir')
                                            <span class="text-danger fw-bold">Tidak Hadir</span>
                                        @elseif($status == 'Izin')
                                            <span class="text-warning fw-bold">Izin</span>
                                        @else
                                            <span class="text-muted">Belum Absen</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 4 + count($weekDates) }}" class="text-center py-5">
                                    <div class="empty">
                                        <div class="empty-img">
                                            <img src="{{ asset('assets/static/illustrations/undraw_printing_invoices_5r4r.svg') }}" height="128" alt="">
                                        </div>
                                        <p class="empty-title">Tidak ada data siswa</p>
                                        <p class="empty-subtitle text-muted">
                                            Tidak ada data siswa yang ditemukan dengan filter yang dipilih
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($siswa->hasPages())
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-0 text-muted">
                                Menampilkan <span>{{ $siswa->firstItem() }}</span> sampai <span>{{ $siswa->lastItem() }}</span> 
                                dari <span>{{ $siswa->total() }}</span> siswa
                            </p>
                        </div>
                        <div class="col-auto">
                            {{ $siswa->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Add loading state for pagination links
    $('.pagination a').on('click', function() {
        $(this).addClass('disabled').append(' <div class="spinner-border spinner-border-sm ms-1" role="status"></div>');
    });
    
    // Add loading state for filter form
    $('form').on('submit', function() {
        $(this).find('button[type="submit"]').prop('disabled', true).html('Loading...');
    });
});
</script>
@endpush
