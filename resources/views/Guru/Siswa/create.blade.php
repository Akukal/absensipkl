@extends('layouts.admin.tabler')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="page-body">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header d-print-none">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <div class="page-pretitle">
                                Manajemen Siswa
                            </div>
                            <h2 class="page-title">
                                {{ $title }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Form Card -->
            <div class="col-lg-5 col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light">
                        <h4 class="card-title mb-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Tambah Siswa Baru
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h4 class="alert-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    </svg>
                                    Terdapat Kesalahan!
                                </h4>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <h4 class="alert-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l5 5l10 -10"></path>
                                    </svg>
                                    Berhasil!
                                </h4>
                                <div class="text-muted">{{ session('success') }}</div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="/siswa/create" method="POST" class="needs-validation" novalidate>
                            @csrf
                            
                            <div class="mb-4">
                                <label for="nama" class="form-label required">Nama Siswa</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" id="nama" name="nama" 
                                           value="{{ old('nama') }}" placeholder="Masukkan nama lengkap siswa" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="form-label required">Email</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                            <polyline points="3,7 12,13 21,7"></polyline>
                                        </svg>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email') }}" placeholder="contoh@email.com" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="kelas" class="form-label required">Kelas</label>
                                <select class="form-select" id="kelas" name="kelas" required>
                                    <option value="">Pilih Kelas</option>
                                    <optgroup label="Kelas XI">
                                        <option value="XI TJKT 1" {{ old('kelas') == 'XI TJKT 1' ? 'selected' : '' }}>XI TJKT 1</option>
                                        <option value="XI TJKT 2" {{ old('kelas') == 'XI TJKT 2' ? 'selected' : '' }}>XI TJKT 2</option>
                                        <option value="XI PPLG 1" {{ old('kelas') == 'XI PPLG 1' ? 'selected' : '' }}>XI PPLG 1</option>
                                        <option value="XI PPLG 2" {{ old('kelas') == 'XI PPLG 2' ? 'selected' : '' }}>XI PPLG 2</option>
                                        <option value="XI BCF 1" {{ old('kelas') == 'XI BCF 1' ? 'selected' : '' }}>XI BCF 1</option>
                                        <option value="XI BCF 2" {{ old('kelas') == 'XI BCF 2' ? 'selected' : '' }}>XI BCF 2</option>
                                    </optgroup>
                                    <optgroup label="Kelas XII">
                                        <option value="XII DKV 1" {{ old('kelas') == 'XII DKV 1' ? 'selected' : '' }}>XII DKV 1</option>
                                        <option value="XII DKV 2" {{ old('kelas') == 'XII DKV 2' ? 'selected' : '' }}>XII DKV 2</option>
                                        <option value="XII DKV 3" {{ old('kelas') == 'XII DKV 3' ? 'selected' : '' }}>XII DKV 3</option>
                                        <option value="XII TJKT 1" {{ old('kelas') == 'XII TJKT 1' ? 'selected' : '' }}>XII TJKT 1</option>
                                        <option value="XII TJKT 2" {{ old('kelas') == 'XII TJKT 2' ? 'selected' : '' }}>XII TJKT 2</option>
                                        <option value="XII PPLG 1" {{ old('kelas') == 'XII PPLG 1' ? 'selected' : '' }}>XII PPLG 1</option>
                                        <option value="XII PPLG 2" {{ old('kelas') == 'XII PPLG 2' ? 'selected' : '' }}>XII PPLG 2</option>
                                        <option value="XII PPLG 3" {{ old('kelas') == 'XII PPLG 3' ? 'selected' : '' }}>XII PPLG 3</option>
                                        <option value="XII BCF 1" {{ old('kelas') == 'XII BCF 1' ? 'selected' : '' }}>XII BCF 1</option>
                                        <option value="XII BCF 2" {{ old('kelas') == 'XII BCF 2' ? 'selected' : '' }}>XII BCF 2</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="id_perusahaan" class="form-label required">Perusahaan</label>
                                <select class="form-select" id="id_perusahaan" name="id_perusahaan" required>
                                    <option value="">Pilih Perusahaan</option>
                                    @foreach($perusahaan as $company)
                                        <option value="{{ $company->id }}" 
                                                {{ old('id_perusahaan') == $company->id ? 'selected' : '' }}>
                                            {{ $company->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="d-flex justify-content-end gap-2">
                                <a href="/siswa" class="btn btn-ghost-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
                                    </svg>
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                        <circle cx="12" cy="14" r="2"></circle>
                                        <polyline points="14,4 14,8 8,8 8,4"></polyline>
                                    </svg>
                                    Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- DataTable Card -->
            <div class="col-lg-7 col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light">
                        <h4 class="card-title mb-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 11h6m-6 4h6m-6 -8h6m-8 8v.01m0 -4v.01m0 -4v.01m0 -4v.01"></path>
                                <path d="M3 3l18 0"></path>
                            </svg>
                            Data Siswa Terbaru
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table id="siswaTable" class="table table-vcenter table-mobile-md card-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="w-30">Nama / Email</th>
                                        <th class="w-15">Kelas</th>
                                        <th class="w-20">Perusahaan</th>
                                        <th class="w-15">Tanggal</th>
                                        <th class="w-20">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentSiswa as $siswa)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div class="fw-bold text-dark">{{ $siswa->user ? $siswa->user->nama : 'No Name' }}</div>
                                                    <small class="text-muted">{{ $siswa->user ? $siswa->user->email : 'No Email' }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-blue-lt">{{ $siswa->kelas ?? 'No Class' }}</span>
                                            </td>
                                            <td>
                                                <div class="small text-muted">{{ $siswa->perusahaan ? $siswa->perusahaan->nama : 'No Company' }}</div>
                                            </td>
                                            <td data-order="{{ $siswa->created_at ? \Carbon\Carbon::parse($siswa->created_at)->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s') }}">
                                                <div class="small text-muted">{{ $siswa->created_at ? \Carbon\Carbon::parse($siswa->created_at)->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            onclick="editSiswa({{ $siswa->id }})" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top" 
                                                            title="Edit Siswa">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                            <path d="M16 5l3 3"></path>
                                                        </svg>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="deleteSiswa({{ $siswa->id }}, '{{ $siswa->user ? $siswa->user->nama : 'Siswa' }}')" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top" 
                                                            title="Hapus Siswa">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <line x1="4" y1="7" x2="20" y2="7"></line>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-5">
                                                <div class="empty">
                                                    <div class="empty-img">
                                                        <img src="./static/illustrations/undraw_printing_invoices_5r4r.svg" height="128" alt="">
                                                    </div>
                                                    <p class="empty-title">Belum ada data siswa</p>
                                                    <p class="empty-subtitle text-muted">
                                                        Silakan tambahkan siswa baru menggunakan form di sebelah kiri.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal modal-blur fade" id="editSiswaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSiswaForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label required">Nama Siswa</label>
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                </svg>
                            </span>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_email" class="form-label required">Email</label>
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                    <polyline points="3,7 12,13 21,7"></polyline>
                                </svg>
                            </span>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_kelas" class="form-label required">Kelas</label>
                        <select class="form-select" id="edit_kelas" name="kelas" required>
                            <option value="">Pilih Kelas</option>
                            <optgroup label="Kelas XI">
                                <option value="XI TJKT 1">XI TJKT 1</option>
                                <option value="XI TJKT 2">XI TJKT 2</option>
                                <option value="XI PPLG 1">XI PPLG 1</option>
                                <option value="XI PPLG 2">XI PPLG 2</option>
                                <option value="XI BCF 1">XI BCF 1</option>
                                <option value="XI BCF 2">XI BCF 2</option>
                            </optgroup>
                            <optgroup label="Kelas XII">
                                <option value="XII DKV 1">XII DKV 1</option>
                                <option value="XII DKV 2">XII DKV 2</option>
                                <option value="XII DKV 3">XII DKV 3</option>
                                <option value="XII TJKT 1">XII TJKT 1</option>
                                <option value="XII TJKT 2">XII TJKT 2</option>
                                <option value="XII PPLG 1">XII PPLG 1</option>
                                <option value="XII PPLG 2">XII PPLG 2</option>
                                <option value="XII PPLG 3">XII PPLG 3</option>
                                <option value="XII BCF 1">XII BCF 1</option>
                                <option value="XII BCF 2">XII BCF 2</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_id_perusahaan" class="form-label required">Perusahaan</label>
                        <select class="form-select" id="edit_id_perusahaan" name="id_perusahaan" required>
                            <option value="">Pilih Perusahaan</option>
                            @foreach($perusahaan as $company)
                                <option value="{{ $company->id }}">{{ $company->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateSiswa()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                        <circle cx="12" cy="14" r="2"></circle>
                        <polyline points="14,4 14,8 8,8 8,4"></polyline>
                    </svg>
                    Update Data
                </button>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    /* Enhanced Styling */
    .page-body {
        padding: 1.5rem 0;
    }

    .card {
        border: 1px solid rgba(98, 105, 118, 0.16);
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: box-shadow 0.15s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .card-header.bg-light {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid rgba(98, 105, 118, 0.16);
        padding: 1.25rem 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .form-label.required::after {
        content: " *";
        color: #d63384;
    }

    .input-icon {
        position: relative;
    }

    .input-icon .input-icon-addon {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        color: #626976;
        background-color: #f8f9fa;
        border: 1px solid #dadce0;
        border-right: 0;
        border-radius: 0.375rem 0 0 0.375rem;
    }

    .input-icon .form-control {
        padding-left: 2.5rem;
    }

    .form-control, .form-select {
        border: 1px solid #dadce0;
        padding: 0.6875rem 0.75rem;
        font-size: 0.875rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0054a6;
        box-shadow: 0 0 0 0.25rem rgba(32, 107, 196, 0.25);
    }

    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: all 0.15s ease-in-out;
    }

    .btn-primary {
        background-color: #206bc4;
        border-color: #206bc4;
    }

    .btn-primary:hover {
        background-color: #0054a6;
        border-color: #0054a6;
        transform: translateY(-1px);
    }

    .btn-ghost-secondary {
        color: #626976;
        background-color: transparent;
        border-color: transparent;
    }

    .btn-ghost-secondary:hover {
        color: #495057;
        background-color: #f8f9fa;
        border-color: #f8f9fa;
    }

    .table-vcenter td {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }

    .bg-blue-lt {
        background-color: rgba(32, 107, 196, 0.06) !important;
        color: #206bc4 !important;
    }

    .alert {
        border: 0;
        border-radius: 0.5rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }

    .alert-title {
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .alert-title .icon {
        margin-right: 0.5rem;
    }

    /* DataTables Styling */
    .dt-container {
        width: 100% !important;
    }
    
    .dt-container .dt-paging {
        margin-top: 1.5rem;
        text-align: center;
    }

    .dt-container .dt-paging .dt-paging-button {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        margin: 0 0.125rem;
        border: 1px solid #dadce0;
        background-color: #fff;
        color: #495057;
        border-radius: 0.375rem;
        text-decoration: none;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .dt-container .dt-paging .dt-paging-button:hover {
        background-color: #f8f9fa;
        border-color: #adb5bd;
    }

    .dt-container .dt-paging .dt-paging-button.current {
        background-color: #206bc4 !important;
        border-color: #206bc4 !important;
        color: #fff !important;
    }

    .dt-container .dt-length {
        margin-bottom: 1rem;
    }

    .dt-container .dt-search {
        margin-bottom: 1rem;
        text-align: right;
    }

    .dt-container .dt-search input {
        padding: 0.375rem 0.75rem;
        border: 1px solid #dadce0;
        border-radius: 0.375rem;
        margin-left: 0.5rem;
        font-size: 0.875rem;
    }

    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }

    .btn-group .btn .icon {
        width: 16px;
        height: 16px;
    }

    .w-30 { width: 30% !important; }
    .w-15 { width: 15% !important; }
    .w-20 { width: 20% !important; }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .page-body {
            padding: 1rem 0;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .d-flex.gap-2 {
            flex-direction: column;
        }
        
        .d-flex.gap-2 .btn {
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection

@section('scripts')
<!-- DataTables JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize DataTable
    if (typeof DataTable !== 'undefined') {
        const tableElement = document.querySelector('#siswaTable');
        if (tableElement) {
            try {
                let table = new DataTable('#siswaTable', {
                    pageLength: 5,
                    lengthMenu: [5, 10, 25, 50],
                    order: [[3, 'desc']],
                    columnDefs: [
                        { targets: 0, orderable: true, searchable: true },
                        { targets: 3, type: 'date' },
                        { targets: 4, orderable: false, searchable: false }
                    ],
                    language: {
                        search: 'Cari:',
                        lengthMenu: 'Tampilkan _MENU_ data per halaman',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                        infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
                        infoFiltered: '(difilter dari _MAX_ total data)',
                        paginate: {
                            first: 'Pertama',
                            last: 'Terakhir',
                            next: '›',
                            previous: '‹'
                        },
                        emptyTable: 'Belum ada data siswa',
                        zeroRecords: 'Tidak ditemukan data yang cocok'
                    },
                    responsive: true,
                    searching: true,
                    ordering: true,
                    paging: true,
                    info: true
                });
            } catch (error) {
                console.error('Error initializing DataTable:', error);
            }
        }
    }

    // Auto-reload after success
    @if(session('success'))
        setTimeout(function() {
            window.location.reload();
        }, 2000);
    @endif
});

// Edit Siswa Function
function editSiswa(id) {
    // Show loading
    Swal.fire({
        title: 'Memuat data...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Fetch siswa data
    fetch(`/siswa/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            Swal.close();
            
            if (data.success) {
                // Populate form
                document.getElementById('edit_nama').value = data.siswa.user.nama;
                document.getElementById('edit_email').value = data.siswa.user.email;
                document.getElementById('edit_kelas').value = data.siswa.kelas;
                document.getElementById('edit_id_perusahaan').value = data.siswa.id_perusahaan;
                
                // Set form action
                document.getElementById('editSiswaForm').action = `/siswa/${id}`;
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('editSiswaModal'));
                modal.show();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message || 'Gagal memuat data siswa',
                    confirmButtonColor: '#d33'
                });
            }
        })
        .catch(error => {
            Swal.close();
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat memuat data',
                confirmButtonColor: '#d33'
            });
        });
}

// Update Siswa Function
function updateSiswa() {
    const form = document.getElementById('editSiswaForm');
    const formData = new FormData(form);

    // Show loading
    Swal.fire({
        title: 'Menyimpan perubahan...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        
        if (data.success) {
            // Hide modal
            bootstrap.Modal.getInstance(document.getElementById('editSiswaModal')).hide();
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                confirmButtonColor: '#28a745',
                timer: 2000,
                timerProgressBar: true
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message || 'Gagal mengupdate data siswa',
                confirmButtonColor: '#d33'
            });
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan saat menyimpan data',
            confirmButtonColor: '#d33'
        });
    });
}

// Delete Siswa Function
function deleteSiswa(id, nama) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Data siswa "${nama}" akan dihapus secara permanen!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus data...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Send delete request
            fetch(`/siswa/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#28a745',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Gagal menghapus data siswa',
                        confirmButtonColor: '#d33'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menghapus data',
                    confirmButtonColor: '#d33'
                });
            });
        }
    });
}
</script>
@endsection
