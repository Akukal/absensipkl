@extends('layouts.presensi')
@section('header')
        {{-- <!-- App Header -->
        <div class="appHeader bg-primary text-light">
            {{-- <div class="left">
                <a href="javascript:;" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Home</div>
            <div class="right">
                <a href="/logout" class="logout">
                    <ion-icon name="exit-outline"></ion-icon>
                </a>
            </div>
        </div>
        <!-- * App Header --> --}}
@endsection
@section('content')
    <style>
        .logout {
            position: absolute;
            color: white;
            font-size: 30px;
            text-decoration: none;
            right: 8px;
        }

        .logout:hover {
            color: white;
        } 
    </style>
    @php
        // Data dummyAn
        $akun = (object)[
            'nama' => 'DANENDRA RAHARDYAN DANARDI'
        ];
        $siswa = (object)[
            'kelas' => 'XII RPL 1'
        ];
        $perusahaan = (object)[
            'nama' => 'PT. Maju Jaya Abadi Pratama'
        ];
        // Dummy absen: Sudah absen masuk, belum absen keluar
        $absen = (object)[
            'jam_masuk' => null,
            'jam_keluar' => '07:52:00',
            'status' => 'Tidak Hadir',
            'foto_masuk' => null,
            'foto_keluar' => null,
            'foto' => null
        ];
    @endphp
    
    <section class="w-full max-w-lg min-h-screen mx-auto flex flex-col justify-center gap-4 text-gray-300 py-24">
        <div class="w-full flex flex-col items-center justify-center gap-6 px-4">
            <div class="relative bg-gray-800 rounded-2xl shadow-2xl py-6 px-6 w-full max-w-md flex items-center gap-4 border border-gray-700">
                <span class="inline-flex items-center justify-center w-20 h-20 bg-gray-700 rounded-full">
                    <ion-icon name="person-circle-outline" class="text-9xl text-white"></ion-icon>
                </span>
                <div>
                    @php
                        $namaAkun = $akun->nama;
                        $namaLength = mb_strlen($namaAkun);
                        $namaClass = $namaLength > 24 ? 'text-base' : 'text-lg';
                    @endphp
                    <h3 class="{{ $namaClass }} font-bold text-white mb-1">{{ $namaAkun }}</h3>
                    <p class="text-xs sm:text-sm text-gray-400 mb-1">{{ $siswa->kelas }}</p>
                    <p class="text-xs sm:text-sm text-orange-400 font-semibold">{{ $perusahaan->nama }}</p>
                </div>
            </div>
            <div class="relative bg-gray-800 rounded-2xl shadow-2xl py-6 px-6 w-full max-w-md flex flex-col sm:flex-row items-center border border-gray-700">
                <span class="hidden sm:inline-flex items-center justify-center w-20 h-20 bg-gray-700 rounded-full">
                    <ion-icon name="time-outline" class="text-7xl text-white"></ion-icon>
                </span>
                <div class="flex-1 w-full">
                    <div class="grid grid-cols-2 divide-x divide-gray-700">
                        <!-- Absen Masuk -->
                        <div class="flex flex-col items-center py-2 px-3">
                            <span class="text-gray-400 text-xs font-medium mb-1 tracking-wide">Absen Masuk</span>
                            <span class="
                                text-2xl font-bold 
                                {{ is_null($absen) || (optional($absen)->jam_masuk == null && optional($absen)->status != 'Izin') ? 'text-red-600' : (optional($absen)->status == 'Izin' ? 'text-orange-400' : 'text-green-400') }}
                                ">
                                {{ is_null($absen) ? '--:--:--' : (optional($absen)->status == 'Izin' ? 'Izin' : (optional($absen)->jam_masuk ?? '--:--:--')) }}
                            </span>
                        </div>
                        <!-- Absen Keluar -->
                        <div class="flex flex-col items-center py-2 px-3">
                            <span class="text-gray-400 text-xs font-medium mb-1 tracking-wide">Absen Keluar</span>
                            <span class="
                                text-2xl font-bold 
                                {{ is_null($absen) || (optional($absen)->jam_keluar == null && optional($absen)->status != 'Izin') ? 'text-red-600' : (optional($absen)->status == 'Izin' ? 'text-orange-400' : 'text-green-400') }}
                                ">
                                {{ is_null($absen) ? '--:--:--' : (optional($absen)->status == 'Izin' ? 'Izin' : (optional($absen)->jam_keluar ?? '--:--:--')) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative bg-gray-800 rounded-2xl shadow-2xl py-6 px-6 w-full max-w-md flex flex-col gap-4 border border-gray-700">
                <span class="font-semibold text-white text-lg flex items-center gap-1">
                    <ion-icon name="aperture-outline"></ion-icon>
                    Absen Masuk
                </span>
                @if($absen && !empty($absen->foto_masuk) && $absen->status != 'Izin')
                <img 
                    src="{{ asset('storage/absensi/' . $absen->foto_masuk) }}" 
                    alt="Foto Masuk" 
                    class="w-full h-full object-cover rounded-xl border border-gray-600 bg-gray-900"
                >
                @elseif ($absen && empty($absen->foto_masuk) && $absen->status != 'Izin')
                    <span class="text-sm text-gray-400 italic">Belum ada foto masuk</span>
                @elseif ($absen && $absen->status == 'Izin')
                    <span class="text-sm text-orange-400 italic">Tidak ada foto (Izin)</span>
                @else
                    <span class="text-sm text-gray-400 italic">Tidak ada data absen hari ini</span>
                @endif
            </div>
            <div class="relative bg-gray-800 rounded-2xl shadow-2xl py-6 px-6 w-full max-w-md flex flex-col gap-4 border border-gray-700">
                <span class="font-semibold text-white text-lg flex items-center gap-1">
                    <ion-icon name="aperture-outline"></ion-icon>
                    Absen Keluar
                </span>
                @if($absen && !empty($absen->foto_keluar) && $absen->status != 'Izin')
                <img 
                    src="{{ asset('storage/absensi/' . $absen->foto_keluar) }}" 
                    alt="Foto Keluar" 
                    class="w-full h-full object-cover rounded-xl border border-gray-600 bg-gray-900"
                >
                @elseif ($absen && empty($absen->foto_keluar) && $absen->status != 'Izin')
                    <span class="text-sm text-gray-400 italic">Belum ada foto keluar</span>
                @elseif ($absen && $absen->status == 'Izin')
                    <span class="text-sm text-orange-400 italic">Tidak ada foto (Izin)</span>
                @else
                    <span class="text-sm text-gray-400 italic">Tidak ada data absen hari ini</span>
                @endif
            </div>
        </div>
    </section>
    
    {{-- <div class="section" id="user-section">
        <div id="user-detail" style="margin-top: 50px">
            <div id="user-info">
                <h3 id="user-name">{{ $akun->nama }}</h3>
                <span id="user-role">{{ $siswa->kelas }}</span>
                <p>
                    <span id="user-role">{{ $perusahaan->nama }}</span>
                </p>
            </div>
        </div>
    </div> --}}
    {{-- <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-name">
                            <h3 class="text-center">Selamat Datang</h3>
                            <p class="text-center" id="jam"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="attendance-card">
        <div class="attendance-times">
            <div>
                <h3>Absen Masuk</h3>
                <span id="clock-in-time" style="color: {{ is_null($absen) || (optional($absen)->jam_masuk == null && optional($absen)->status != 'Izin') ? 'red' : (optional($absen)->status == 'Izin' ? 'orange' : 'green') }}">
   {{ is_null($absen) ? '--:--:--' : (optional($absen)->status == 'Izin' ? 'Izin' : (optional($absen)->jam_masuk ?? '--:--:--')) }}
</span>
            </div>
            <div>
                <h3>Absen Keluar</h3>
                <span id="clock-out-time" style="color: {{ is_null($absen) || (optional($absen)->jam_keluar == null && optional($absen)->status != 'Izin') ? 'red' : (optional($absen)->status == 'Izin' ? 'orange' : 'green') }}">
   {{ is_null($absen) ? '--:--:--' : (optional($absen)->status == 'Izin' ? 'Izin' : (optional($absen)->jam_keluar ?? '--:--:--')) }}
</span>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
                @if($absen && !empty($absen->foto_masuk) && $absen->status != 'Izin')
                <div class="col-12">
                    <div class="card gradasigreen" style="margin-bottom: 20px; margin-top: 50px">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                     <img src="{{ asset('storage/absensi/' . $absen->foto_masuk) }}" alt="Foto Masuk" height="75px" width="125px" class="rounded">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              @elseif ($absen && empty($absen->foto_masuk) && $absen->status != 'Izin')
                <div class="col-12">
                    <div class="card gradasigreen" style="margin-bottom: 20px; margin-top: 50px">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera" style="height: 75px; width= 125px"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>Belum Absen</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($absen && !empty($absen->foto_keluar) && $absen->status != 'Izin')
                <div class="col-12">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <img src="/storage/absensi/{{ $absen->foto_keluar }}" alt="Foto_Keluar" height="75px" width="125px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($absen && empty($absen->foto_keluar) && $absen->status != 'Izin') 
                <div class="col-12">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera" style="height: 75px; width= 125px"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Keluar</h4>
                                    <span>Belum Absen</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($absen && $absen->status == 'Izin')
                <div class="col-12">
                    <div class="card gradasigrey">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <img src="/storage/absensi/{{ $absen->foto }}" alt="Foto_Keluar" height="75px" width="125px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
        </div>
</div>--}}
@endsection

@section('scripts')
    <script type="text/javascript">
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s, year, month, date, day;

            var days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());
            year = d.getFullYear();
            month = months[d.getMonth()]; // getMonth() returns 0-11
            date = set(d.getDate());
            day = days[d.getDay()]; // getDay() returns 0-6

            e.innerHTML = day + ', ' + date + ' ' + month + ' ' + year + ' ' + h + ':' + m + ':' + s;

            setTimeout(jam, 1000); // no need to pass the function name as a string
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>
@endsection