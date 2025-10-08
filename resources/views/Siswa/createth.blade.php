@extends('layouts.presensi')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Tidak Hadir</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
<div class="row" style="margin-top: 60px">
    <div class="col">
      <form method="POST" action="/izin" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="foto">Foto Surat</label>
          <input type="file" id="foto" name="foto" class="form-control" accept="image/*" required>
        </div>
        <div class="form-group">
          <label for="keterangan">Keterangan</label>
          <input type="text" name="keterangan" class="form-control" required>
        </div>
        <div class="row">
          <div class="col">
            <button type="submit" id="kirimAbsen" class="btn btn-primary btn-block">
              <ion-icon name="checkmark-outline"></ion-icon>
              Kirim Surat
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('myscript')

@if(session('error'))
<script>
Swal.fire({
  title: 'Error !',
  text:  '{{ session('message') }}',
  icon: 'error'
  })
</script>
@endif

@if(session('true'))
<script>
Swal.fire({
  title: 'Berhasil !',
  text: 'Izin Berhasil',
  icon: 'success'
})  
</script>
@endif

@endpush