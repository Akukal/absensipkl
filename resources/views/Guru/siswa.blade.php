@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    SIAKAD PKL SMK PRESTASI PRIMA
                </div>
                <h2 class="page-title">
                    Rekap Absensi
                </h2>
                <div class="page-pretitle">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}
                </div>
            </div>

        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <form method="GET">
                                    <div class="row">

                                        <div class="col-2">
                                            <div class="form-group">

                                                <select name="kelas" class="form-select">
                                                    <option value="">Semua Kelas</option>
                                                    <option value="XII BCF 1"
                                                        {{ $reqkelas == 'XII BCF 1' ? 'selected' : '' }}>XII BCF 1
                                                    </option>
                                                    <option value="XII BCF 2"
                                                        {{ $reqkelas == 'XII BCF 2' ? 'selected' : '' }}>XII BCF 2
                                                    </option>
                                                    <option value="XII DKV 1"
                                                        {{ $reqkelas == 'XII DKV 1' ? 'selected' : '' }}>XII DKV 1
                                                    </option>
                                                    <option value="XII DKV 2"
                                                        {{ $reqkelas == 'XII DKV 2' ? 'selected' : '' }}>XII DKV 2
                                                    </option>
                                                    <option value="XII DKV 3"
                                                        {{ $reqkelas == 'XII DKV 3' ? 'selected' : '' }}>XII DKV 3
                                                    </option>
                                                    <option value="XII PPLG 1"
                                                        {{ $reqkelas == 'XII PPLG 1' ? 'selected' : '' }}>XII PPLG 1
                                                    </option>
                                                    <option value="XII PPLG 2"
                                                        {{ $reqkelas == 'XII PPLG 2' ? 'selected' : '' }}>XII PPLG 2
                                                    </option>
                                                    <option value="XII PPLG 3"
                                                        {{ $reqkelas == 'XII PPLG 3' ? 'selected' : '' }}>XII PPLG 3
                                                    </option>
                                                    <option value="XII TJKT 1"
                                                        {{ $reqkelas == 'XII TJKT 1' ? 'selected' : '' }}>XII TJKT 1
                                                    </option>
                                                    <option value="XII TJKT 2"
                                                        {{ $reqkelas == 'XII TJKT 2' ? 'selected' : '' }}>XII TJKT 2
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select name="perusahaan" class="form-select">
                                                    <option value="">Semua Perusahaan</option>
                                                    @foreach ($perusahaan as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $reqperusahaan == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select name="filter" class="form-select">
                                                    <option value="">Hari Ini</option>
                                                    <option value="6" {{ $reqfilter == '6' ? 'selected' : '' }}>
                                                        Juni</option>
                                                    <option value="7" {{ $reqfilter == '7' ? 'selected' : '' }}>
                                                        Juli</option>
                                                    <option value="8" {{ $reqfilter == '8' ? 'selected' : '' }}>
                                                        Agustus</option>
                                                    <option value="9" {{ $reqfilter == '9' ? 'selected' : '' }}>
                                                        September</option>
                                                    <option value="10" {{ $reqfilter == '10' ? 'selected' : '' }}>
                                                        Oktober</option>
                                                    <option value="11" {{ $reqfilter == '11' ? 'selected' : '' }}>
                                                        November</option>
                                                    <option value="12" {{ $reqfilter == '12' ? 'selected' : '' }}>
                                                        Desember</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-search" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                        <path d="M21 21l-6 -6"></path>
                                                    </svg> Cari
                                                </button>
                                </form>
                                <form method="GET" action="/siswa/export" style="display: inline">
                                    <input type="hidden" name="kelas" value="{{ $reqkelas }}">
                                    <input type="hidden" name="perusahaan" value="{{ $reqperusahaan }}">
                                    <input type="hidden" name="filter" value="{{ $reqfilter }}">
                                    <button type="submit" class="btn btn-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                            <path
                                                d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                        </svg> Excel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-building-skyscraper">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 21l18 0" />
                                            <path d="M5 21v-14l8 -4v18" />
                                            <path d="M19 21v-10l-6 -4" />
                                            <path d="M9 9l0 .01" />
                                            <path d="M9 12l0 .01" />
                                            <path d="M9 15l0 .01" />
                                            <path d="M9 18l0 .01" />
                                        </svg> Perusahaan</th>
                                    <th>Pembimbing</th>
                                    <th>Status</th>
                                    <th> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-clock">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" />
                                            <path d="M16 3v4" />
                                            <path d="M8 3v4" />
                                            <path d="M4 11h10" />
                                            <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M18 16.5v1.5l.5 .5" />
                                        </svg> Jam Masuk</th>
                                    <th>Det. Masuk</th>

                                    <th> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-clock">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" />
                                            <path d="M16 3v4" />
                                            <path d="M8 3v4" />
                                            <path d="M4 11h10" />
                                            <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M18 16.5v1.5l.5 .5" />
                                        </svg> Jam Keluar</th>
                                    <th>Det. Keluar</th>
                                    <th>Det. Izin</th>
                                    {{-- <th>Foto Ket.</th> --}}
                                </tr>
                            </thead>
                            <tbody>

                                @php $no = 1; @endphp

                                @foreach ($absen as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->siswa->user->nama }}</td>
                                    <td>{{ $item->siswa->kelas }}</td>
                                    <td>{{ $item->siswa->perusahaan->nama }}</td>
                                    <td>{{ $item->siswa->perusahaan->guru->user->nama }}</td>
                                    <td> <span class="badge bg-{{ $item->status == 'Hadir' ? 'green' : ($item->status == 'Izin' ? 'orange' : 'red') }}-lt">{{ $item->status }}</span></td>

                                    @if($item->status != 'Izin')
                                    <td>{!! $item->jam_masuk != null ? $item->jam_masuk : '<span class="badge bg-red-lt">Belum Absen</span>' !!}</td>
                                    @else
                                    <td><span class="badge bg-orange-lt">Izin</span></td>
                                    @endif

                                    @if($item->jam_masuk == null && $item->status != 'Izin')
                                    <td><span class="badge bg-red-lt">Belum Absen</span></td>
                                    @elseif($item->status == 'Izin')
                                    <td><span class="badge bg-orange-lt">Izin</span></td>
                                    @else
                                    <td><a href="#"  onclick="showDetails('{{ Storage::url('absensi/' . $item->foto_masuk) }}', '{{ $item->lokasi_masuk }}')">Lihat</a></td>
                                    @endif

                                    @if($item->status != 'Izin')
                                    <td>{!! $item->jam_keluar != null ? $item->jam_keluar : '<span class="badge bg-red-lt">Belum Absen</span>' !!}</td>
                                    @else
                                    <td><span class="badge bg-orange-lt">Izin</span></td>
                                    @endif

                                    @if($item->jam_keluar == null && $item->status != 'Izin')
                                    <td><span class="badge bg-red-lt">Belum Absen</span></td>
                                    @elseif($item->status == 'Izin')
                                    <td><span class="badge bg-orange-lt">Izin</span></td>
                                    @else
                                    <td><a href="#"  onclick="showDetails('{{ Storage::url('absensi/' . $item->foto_keluar) }}', '{{ $item->lokasi_keluar }}')">Lihat</a></td>
                                    @endif

                                    @if($item->status != 'Izin')
                                    <td><span class="badge bg-{{ $item->keterangan == null && $item->status == 'Hadir' ? 'green' : 'red' }}-lt">{{ $item->keterangan == null ? 'Tdk Izin' : $item->keterangan }}</span></td>
                                    @else
                                    {{-- Ini Belum Gais --}}
                                    <td><a href="#"  onclick="showDetail('{{ Storage::url('absensi/' . $item->foto) }}', '{{ $item->keterangan }}')">Lihat</a></td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
</div>
</div>

</div>
<div class="modal modal-blur fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Lokasi dan Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Lokasi:</h6>
                        <div id="map"></div>
                    </div>
                    <div class="col-md-6">
                        <h6>Gambar:</h6>
                        <div id="imageContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="izinModal" tabindex="-1" role="dialog" aria-labelledby="izinModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="izinModalLabel">Detail Izin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <img id="modalImage" src="" alt="Foto" style="max-width: 100%; height: auto;">
                        <label for="modalCaption" class="form-label mt-3">Keterangan</label>
                        <div id="modalCaption" class="form-control" style="height: auto;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
function showDetails(imageUrl, location) {
    var modal = new bootstrap.Modal(document.getElementById('detailModal'), {});
    modal.show();

    
    if(location != ''){
    document.getElementById('map').innerHTML = "<div id='mapid' style='height: 300px;'></div>"
        
    var loc = location.split(',');
    var map = L.map('mapid').setView([loc[0], loc[1]], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);
    }
    console.log(loc[0], loc[1])
    L.marker([parseFloat(loc[0]), parseFloat(loc[1])]).addTo(map)

    var image = document.createElement('img');
    image.src = imageUrl;
    image.style.maxWidth = '100%';
    var imageContainer = document.getElementById('imageContainer');
    imageContainer.innerHTML = ''; 
    imageContainer.appendChild(image);
}
</script>

<script>
    function showDetail(imageUrl, caption) {
        // Set the image and caption in the modal
        var modalImg = document.getElementById("modalImage");
        var modalCaption = document.getElementById("modalCaption");
        
        modalImg.src = imageUrl;
        modalCaption.innerHTML = caption;

        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById('izinModal'), {
            keyboard: false
        });
        myModal.show();
    }
</script>

@endsection
