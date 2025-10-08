@extends('layout.admin.tabler')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $title }}</h4>
                    <a href="/siswa" class="btn btn-secondary btn-sm float-right">Kembali</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/siswa/edit/{{ $siswa->id }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Siswa</label>
                                    <input type="text" class="form-control" id="nama" name="nama" 
                                           value="{{ old('nama', $siswa->user->nama) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $siswa->user->email) }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kelas">Kelas</label>
                                    <input type="text" class="form-control" id="kelas" name="kelas" 
                                           value="{{ old('kelas', $siswa->kelas) }}" placeholder="Contoh: XI RPL 1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_perusahaan">Perusahaan</label>
                                    <select class="form-control" id="id_perusahaan" name="id_perusahaan" required>
                                        <option value="">Pilih Perusahaan</option>
                                        @foreach($perusahaan as $company)
                                            <option value="{{ $company->id }}" 
                                                    {{ (old('id_perusahaan', $siswa->id_perusahaan) == $company->id) ? 'selected' : '' }}>
                                                {{ $company->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="/siswa" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection