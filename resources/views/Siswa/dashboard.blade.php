@extends('layouts.presensi')
@section('header')
        <!-- App Header -->
        <div class="appHeader bg-primary text-light">
            <div class="left">
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
        <!-- * App Header -->
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
    <div class="section" id="user-section">
        <div id="user-detail" style="margin-top: 50px">
            <div id="user-info">
                <h3 id="user-name">{{ $akun->nama }}</h3>
                <span id="user-role">{{ $siswa->kelas }}</span>
                <p>
                    <span id="user-role">{{ $perusahaan->nama }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="section" id="menu-section">
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
</div>
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