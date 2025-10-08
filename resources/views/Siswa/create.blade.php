@extends('layouts.presensi')
@php
    // Define showCameraSection based on absen status
    $showCameraSection = isset($absen) && $absen->jam_masuk && !$absen->jam_keluar;
@endphp
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
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

        .attendance-option {
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
        }

        .attendance-option.selected {
            border-color: #007bff;
            background-color: #e7f3ff;
        }

        .attendance-option input[type="radio"] {
            margin-right: 10px;
        }

        .attendance-option-content {
            flex: 1;
        }

        .attendance-option-title {
            font-weight: bold;
            color: #333;
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
    <!-- Attendance Type Selection -->
    <div class="row" style="margin-top: 60px">
        <div class="col">
            <div class="attendance-type-selection">
                <h6 class="mb-3">Pilih Jenis Kehadiran:</h6>
                
                <div class="attendance-option" id="option-wfo" onclick="selectAttendanceType('WFO')">
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
    </div>

    <!-- Camera and Map Section (Initially Hidden) -->
    <div class="camera-section" style="display: {{ $showCameraSection ? 'block' : 'none' }};">
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
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }

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
