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
        <form action="{{ url('/izin') }}" method="POST" enctype="multipart/form-data" class="w-full">
          @csrf
          <div class="w-full flex flex-col gap-4">
            <div>
              <label for="foto" class="block text-sm font-semibold mb-1.5 text-white">Unggah Foto Surat <span class="text-orange-400">*</span></label>
              <label class="flex justify-center w-full h-24 px-4 transition border hover:text-white border-white/75 hover:border-white border-dashed cursor-pointer rounded-lg">
                <span class="flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="min-w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <span class="font-medium text-sm">
                        Klik untuk unggah
                    </span>
                </span>
                <input id="foto" name="foto" type="file" accept="image/*" class="hidden" required oninput="previewFotoSurat(event)">
              </label>
              <!-- Preview image -->
              <div id="preview-foto-surat" class="w-full flex justify-center mt-2" style="display: none;">
                <img src="#" alt="Preview Surat" id="img-preview-surat" class="max-h-48 rounded-lg border border-gray-700 object-contain" />
              </div>
              <script>
                function previewFotoSurat(event) {
                  const input = event.target;
                  const previewContainer = document.getElementById('preview-foto-surat');
                  const img = document.getElementById('img-preview-surat');
                  if(input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                      img.src = e.target.result;
                      previewContainer.style.display = 'flex';
                    }
                    reader.readAsDataURL(input.files[0]);
                  } else {
                    previewContainer.style.display = 'none';
                    img.src = '#';
                  }
                }
              </script>
            </div>
            <div>
              <label for="keterangan" class="block text-sm font-semibold mb-1.5 text-white">Keterangan <span class="text-orange-400">*</span></label>
              <input 
                type="text" 
                id="keterangan" 
                name="keterangan" 
                class="block w-full text-sm sm:text-base text-gray-200 bg-gray-900 rounded-lg border border-gray-700 focus:outline-none focus:border-orange-400 focus:ring focus:ring-orange-500/50 p-2 transition"
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