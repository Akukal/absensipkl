@extends('layouts.presensi')
@php
    // Define showCameraSection based on absen status
    $showCameraSection = isset($absen) && $absen->jam_masuk && !$absen->jam_keluar;
@endphp
@section('header')
    <!-- App Header -->
    {{-- <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div> --}}
    <!-- * App Header -->
    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }
        
        .webcam-capture video {
            transform: scaleX(-1) !important;
        }

        #map {
            height: 200px;
            /* Remove display: none from here */
        }

        .camera-section {
            display: none; /* Initially hidden */
        }

        .jam-digital-malasngoding {
            background-color: #27272783;
            position: absolute;
            top: 65px;
            right: 10px;
            z-index: 9999;
            width: 150px;
            border-radius: 10px;
            padding: 5px;
        }

        .jam-digital-malasngoding p {
            color: #fff;
            font-size: 16px;
            text-align: left;
            margin-top: 0;
            margin-bottom: 0;
        }

        .attendance-type-selection {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* .attendance-option {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            margin: 5px 0;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        } 

        .attendance-option:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
        }*/

        .attendance-option.selected {
            border: 1px solid #fb923c; /* Tailwind's orange-400 */
            color: #fb923c; /* Tailwind's orange-400 */
            /* border:1px solid #374151; */
            background-color: transparent;
        }

        .attendance-option input[type="radio"] {
            margin-right: 10px;
            accent-color: #fb923c;
        }

        .attendance-option-content {
            flex: 1;
        }

        .attendance-option-title {
            font-weight: bold;
        }

        .attendance-option-desc {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }
        
        .disabled {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
@endsection
@section('content')
    @php
        // Data dummy siswa
        $akun = (object)[
            'nama' => 'NURUL FAJRIYAH'
        ];
        $siswa = (object)[
            'kelas' => 'XII TKJ 2'
        ];
        $perusahaan = (object)[
            'nama' => 'PT. Pintar Berjaya Digital'
        ];

        $absen = null;
        // Variabel pendukung halaman
        $showCameraSection = false; // Misal untuk tes, set tampil/tidak kamera
        // Dummy hari (nama hari) dan waktu (lihat jam digital di dashboard)
        setlocale(LC_TIME, 'id_ID.UTF-8');
        $hari = 'Senin, 22 Januari 2024';
    @endphp

    <section class="w-full min-h-screen max-w-lg mx-auto flex flex-col py-20 justify-center gap-4 px-4 text-gray-300 py-24">
        <div class="w-full flex flex-col items-center justify-center gap-6">
            <div class="relative bg-gray-800 rounded-2xl shadow-2xl py-6 px-6 w-full max-w-md flex flex-col items-center gap-2 border border-gray-700">
                <div class="attendance-option w-full flex items-center border border-gray-600 px-4 py-2 gap-2 rounded-lg select-none cursor-pointer" id="option-wfo" onclick="selectAttendanceType('WFO')">
                    <input type="radio" id="wfo" name="attendance_type" value="WFO" class="hidden">
                    <ion-icon name="laptop-outline" class="text-2xl"></ion-icon>
                    <div class="">
                        <div class="text-sm sm:text-base font-bold">Work From Office (WFO)</div>
                        <div class="text-xs sm:text-sm">Hadir di kantor/tempat PKL</div>
                    </div>
                </div>
                
                <div class="attendance-option w-full flex items-center border border-gray-600 px-4 py-2 gap-2 rounded-lg select-none cursor-pointer" id="option-wfh" onclick="selectAttendanceType('WFH')">
                    <input type="radio" id="wfh" name="attendance_type" value="WFH" class="hidden">
                    <ion-icon name="business-outline" class="text-2xl"></ion-icon>
                    <div class="">
                        <div class="text-sm sm:text-base font-bold">Work From Home (WFH)</div>
                        <div class="text-xs sm:text-sm">Bekerja dari rumah</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="camera-section w-full max-w-md flex flex-col mx-auto justify-center items-center bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 py-6 px-6 gap-6 transition-all duration-300" style="display: {{ $showCameraSection ? 'block' : 'none' }};">
            <div class="w-full flex flex-col items-center gap-4">
                <!-- Webcam Capture Area -->
                <div class="relative w-full flex flex-col items-center">
                    <input type="hidden" id="lokasi">
                    <input type="hidden" id="attendance_type_selected">
                    <div class="webcam-capture bg-gray-900 rounded-xl border border-gray-700 w-full aspect-video flex items-center justify-center overflow-hidden">
                        <!-- Kamera akan muncul di sini -->
                    </div>
                </div>
                <!-- Maps Lokasi -->
                <div class="w-full">
                    <div id="map" class="relative -z-0 w-full rounded-xl border border-gray-700 h-52"></div>
                </div>
                <!-- Tanggal & Jam Digital -->
                <div class="hidden w-full items-center my-4" id="time-section">
                    <span class="font-semibold text-sm tracking-wide text-orange-400">{{ $hari }}</span>
                    <span id="jam" class="text-2xl font-extrabold text-white mt-1"></span>
                </div>
                <!-- Tombol Absen -->
                <button id="takeabsen" class="cursor-pointer select-none w-full flex items-center justify-center gap-1 py-2 rounded-lg bg-gradient-to-tr from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 shadow-lg border-1 border-orange-700 text-white text-sm sm:text-base font-semibold transition focus:outline-none active:scale-95">
                    <ion-icon name="camera-outline" class="text-lg sm:text-xl"></ion-icon>
                    Absen
                </button>
            </div>
        </div>
    </section>

    
    <!-- Attendance Type Selection -->
    {{-- <div class="row absolute z-40" style="margin-top: 60px">
        <div class="col">
            <div class="attendance-type-selection">
                <h6 class="mb-3">Pilih Jenis Kehadiran:</h6>
                
                <div class="attendance-option border border-gray-600 px-4 py-2 rounded-lg" id="option-wfo" onclick="selectAttendanceType('WFO')">
                    <input type="radio" id="wfo" name="attendance_type" value="WFO">
                    <div class="attendance-option-content">
                        <div class="attendance-option-title">Work From Office (WFO)</div>
                        <div class="attendance-option-desc">Hadir di kantor/tempat PKL</div>
                    </div>
                </div>
                
                <div class="attendance-option" id="option-wfh" onclick="selectAttendanceType('WFH')">
                    <input type="radio" id="wfh" name="attendance_type" value="WFH">
                    <div class="attendance-option-content">
                        <div class="attendance-option-title">Work From Home (WFH)</div>
                        <div class="attendance-option-desc">Bekerja dari rumah</div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Camera and Map Section (Initially Hidden) -->
    {{-- <div class="w-full min-h-screen flex items-center justify-center">
        <div class="camera-section w-full max-w-lg flex flex-col justify-center items-center bg-gray-800" style="display: {{ $showCameraSection ? 'block' : 'none' }};">
            <div class="row">
                <div class="col">
                    <input type="hidden" id="lokasi">
                    <input type="hidden" id="attendance_type_selected">
                    <div class="webcam-capture"></div>
                </div>
            </div>

            <div class="jam-digital-malasngoding">
                <p>{{ $hari }}</p>
                <p id="jam"></p>
            </div> 

            <div class="row">
                <div class="col">
                    <button id="takeabsen" class="btn btn-primary btn-block">
                        <ion-icon name="camera-outline"></ion-icon>
                        Absen
                    </button>
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div> --}}

    <audio id="notifikasi_in">
        <source src="{{ asset('assets/sound/notifikasi_in.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notifikasi_out">
        <source src="{{ asset('assets/sound/notifikasi_out.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="radius_sound">
        <source src="{{ asset('assets/sound/radius.mp3') }}" type="audio/mpeg">
    </audio>
@endsection

@push('myscript')
    <script type="text/javascript">
        // window.onload = function() {
        //     jam();
        // }

        // function jam() {
        //     var e = document.getElementById('jam'),
        //         d = new Date(),
        //         h, m, s;
        //     h = d.getHours();
        //     m = set(d.getMinutes());
        //     s = set(d.getSeconds());

        //     e.innerHTML = h + ':' + m + ':' + s;

        //     setTimeout('jam()', 1000);
        // }

        // function set(e) {
        //     e = e < 10 ? '0' + e : e;
        //     return e;
        // }

        // Global variable to store map instance
        var mapInstance = null;
        var mapMarker = null;
        var webcamAttached = false;

        // Determine lock state from backend
        var absen = @json($absen);
        var selectionLocked = absen && absen.jam_masuk && !absen.jam_keluar;

        // Disable click if locked
        function selectAttendanceType(type) {
            if (selectionLocked) return; // Prevent changing if locked

            // Remove selected class from all options
            document.querySelectorAll('.attendance-option').forEach(option => {
                option.classList.remove('selected');
            });

            // Add selected class to clicked option
            event.currentTarget.classList.add('selected');

            // Check the radio button
            document.getElementById(type.toLowerCase()).checked = true;

            // Store the selected type
            document.getElementById('attendance_type_selected').value = type;

            // Show camera and map section
            document.querySelector('.camera-section').style.display = 'block';

            // Initialize webcam if not already attached
            if (!webcamAttached) {
                Webcam.set({
                    height: 480,
                    width: 640,
                    image_format: 'jpeg',
                    jpeg_quality: 80,
                });
                Webcam.attach('.webcam-capture');
                webcamAttached = true;
            }

            // Set location based on type
            if (type === 'WFH') {
                document.getElementById('lokasi').value = 'WFH-Location';
            }

            // Initialize map only once
            setTimeout(function() {
                if (!mapInstance) {
                    mapInstance = L.map('map').setView([-6.2088, 106.8456], 15);
                    L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                        maxZoom: 20,
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                    }).addTo(mapInstance);
                }
                // Try to get geolocation and update map
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(successCallback, errorCallback, { enableHighAccuracy: true });
                } else {
                    errorCallback();
                }
            }, 100); // Give time for the section to be visible
        }

        function successCallback(position) {
            var lokasi = document.getElementById('lokasi');
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            console.log(lokasi.value);

            // Move map and marker instead of re-creating map
            if (mapInstance) {
                mapInstance.setView([position.coords.latitude, position.coords.longitude], 18);
                if (mapMarker) {
                    mapMarker.setLatLng([position.coords.latitude, position.coords.longitude]);
                } else {
                    mapMarker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(mapInstance);
                }
            }
        }

        function errorCallback() {
            console.log("Error getting location");
            // Default to Jakarta if geolocation fails
            if (mapInstance) {
                mapInstance.setView([-6.2088, 106.8456], 15);
                if (mapMarker) {
                    mapMarker.setLatLng([-6.2088, 106.8456]);
                } else {
                    mapMarker = L.marker([-6.2088, 106.8456]).addTo(mapInstance);
                }
            }
        }

        // On page load, if locked, visually disable options
        $(document).ready(function() {
            // If already masuk but not pulang, show camera/map section
            if (selectionLocked) {
                $('.attendance-option').addClass('disabled');
                $('.camera-section').show();

                // Set the selected type visually
                if (absen && absen.status === 'WFH') {
                    $('#wfh').prop('checked', true);
                    $('#option-wfh').addClass('selected');
                } else if (absen && absen.status === 'Hadir') {
                    $('#wfo').prop('checked', true);
                    $('#option-wfo').addClass('selected');
                }

                // Set hidden input for attendance_type_selected
                $('#attendance_type_selected').val(absen.status === 'WFH' ? 'WFH' : 'WFO');

                // Initialize webcam/map if not already
                if (!webcamAttached) {
                    Webcam.set({
                        height: 480,
                        width: 640,
                        image_format: 'jpeg',
                        jpeg_quality: 80,
                    });
                    Webcam.attach('.webcam-capture');
                    webcamAttached = true;
                }
                setTimeout(function() {
                    if (!mapInstance) {
                        mapInstance = L.map('map').setView([-6.2088, 106.8456], 15);
                        L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                            maxZoom: 20,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                        }).addTo(mapInstance);
                    }
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(successCallback, errorCallback, { enableHighAccuracy: true });
                    } else {
                        errorCallback();
                    }
                }, 100);
            }
        });

        // On page load, if locked, visually disable options
        $(document).ready(function() {
            if (selectionLocked) {
                $('.attendance-option').addClass('disabled');
            }
        });

        // After absen pulang, unlock selection for next day
        function unlockSelection() {
            selectionLocked = false;
            $('#wfo, #wfh').prop('disabled', false);
            $('.attendance-option').removeClass('disabled');
        }

        $("#takeabsen").click(function(e) {
            var attendanceType = $("#attendance_type_selected").val();
            
            if (!attendanceType) {
                Swal.fire({
                    title: 'Error !',
                    text: 'Silakan pilih jenis kehadiran terlebih dahulu',
                    icon: 'error'
                });
                return;
            }

            Webcam.snap(function(uri) {
                image = uri;
            });
            
            var lokasi = $("#lokasi").val();
            
            $.ajax({
                type: 'POST',
                url: '/create',
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi,
                    attendance_type: attendanceType,
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    if(respond.absen){
                        Swal.fire({
                            title: 'Berhasil !',
                            text: respond.message,
                            icon: 'success'
                        }).then(() => {
                            // Redirect to dashboard after successful attendance
                            window.location.href = '/dashboard';
                        });
                    } 
                    if (respond.absen == false) {
                        Swal.fire({
                            title: 'Error !',
                            text: respond.message,
                            icon: 'error'
                        });
                    }
                    if(respond.absen && respond.message.includes('Keluar')) {
                        unlockSelection();
                    }
                },
                error: (error) => {
                    console.log(error);
                    Swal.fire({
                        title: 'Error !',
                        text: 'Terjadi kesalahan pada server',
                        icon: 'error'
                    });
                }
            });
        });
    </script>
@endpush
