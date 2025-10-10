@extends('layouts.presensi')

@section('header')
    <!-- App Header -->
    {{-- <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Tidak Hadir</div>
        <div class="right"></div>
    </div> --}}
@endsection

@section('content')
<section class="w-full max-w-lg min-h-screen mx-auto flex flex-col justify-center gap-4 text-gray-300 py-24">
  <div class="w-full flex flex-col items-center justify-center gap-6 px-4">
      <div class="relative bg-gray-800 rounded-2xl shadow-2xl py-6 px-6 w-full max-w-md flex flex-col items-center gap-4 border border-gray-700">
        <form action="/izin" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="w-full flex flex-col gap-4">
            <div>
              <label for="foto" class="block text-sm font-semibold mb-1.5 text-white">Upload Foto Surat <span class="text-orange-400">*</span></label>
              <input 
                type="file" 
                id="foto" 
                name="foto" 
                class="block w-full text-sm sm:text-base text-gray-200 bg-gray-900 rounded-lg border border-gray-700 focus:outline-none focus:border-orange-400 focus:ring focus:ring-orange-500/50 p-2"
                accept="image/*"
                required
              >
            </div>
            <div>
              <label for="keterangan" class="block text-sm font-semibold mb-1.5 text-white">Keterangan <span class="text-orange-400">*</span></label>
              <input 
                type="text" 
                id="keterangan" 
                name="keterangan" 
                class="block w-full text-sm sm:text-base text-gray-200 bg-gray-900 rounded-lg border border-gray-700 focus:outline-none focus:border-orange-400 focus:ring focus:ring-orange-500/50 p-2"
                placeholder="Masukkan keterangan"
                required
              >
            </div>

            <button type="submit" id="kirimAbsen" class="cursor-pointer select-none w-full flex items-center justify-center gap-1 py-2 rounded-lg bg-gradient-to-tr from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 shadow-lg border-1 border-orange-700 text-white text-sm sm:text-base font-semibold transition focus:outline-none active:scale-95">
              <ion-icon name="mail-outline" class="text-lg sm:text-xl"></ion-icon>
              Kirim Surat
            </button>
          </div>
        </form>
      </div>
  </div>
</section>

{{-- <div class="row" style="margin-top: 60px; margin-bottom: 120px">
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
  </div> --}}
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