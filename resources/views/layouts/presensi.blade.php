<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>{{ $title }} - Presensi PKL</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="SIAKAD PKL SMK PRESTASI PRIMA" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icon-512.png') }}">
    @if (!request()->is('home') && !request()->is('create'))
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endif
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon-512.png') }}" sizes="32x32">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        .selectmaterialize {
            display: block;
            background-color: transparent !important;
            border: 0px !important;
            border-bottom: 1px solid #9e9e9e !important;
            border-radius: 0 !important;
            outline: none !important;
            height: 3rem !important;
            width: 100% !important;
            font-size: 16px !important;
            margin: 0 0 8px 0 !important;
            padding: 0 !important;
            color: #495057;
        }

        #loader {
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #loader .loading-icon {
            width: 42px;
            height: auto;
            animation: loadingAnimation 1s infinite;
        }

        @keyframes loadingAnimation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @-webkit-keyframes spinner-border {
            to {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes spinner-border {
            to {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        .spinner-border {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: text-bottom;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: spinner-border 0.75s linear infinite;
            animation: spinner-border 0.75s linear infinite;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
        }

        .historicontent {
            display: flex;
            margin-top: 10px;
        }

        .datapresensi {
            margin-left: 10px;
        }

    </style>
</head>

<body class="font-['Poppins'] bg-gray-900">

    <!-- loader -->
    <div id="loader" style="background: #020617 !important;">
        <div class="spinner-border text-orange-800" role="status"></div>
    </div>
    <!-- * loader -->

    @yield('header')
    <section class="fixed top-0 z-40 w-full bg-gray-800 border-b-1 border-gray-700 text-gray-300 flex justify-center shadow-xl">
        <div class="w-full max-w-lg flex items-center justify-between px-4 py-2">
            <a href="{{ url('/home') }}" class="text-transparent bg-clip-text bg-gradient-to-r text-lg from-orange-400 to-orange-300 font-extrabold">Presensi PKL</a>
            <div class="text-sm sm:text-base" id="jam"></div>
        </div>
    </section>

    <!-- App Capsule -->
    <div id="appCapsule" class="bg-gray-900 w-full min-h-screen">
        @yield('content')
    </div>  
    <!-- * App Capsule -->

    @include('layouts.bottomNav')

    <script type="text/javascript">
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s, year, month, date, day;

            var days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            var months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());
            year = d.getFullYear();
            month = months[d.getMonth()]; // getMonth() returns 0-11
            date = set(d.getDate());
            day = days[d.getDay()]; // getDay() returns 0-6

            e.innerHTML = day + ', ' + date + ' ' + month + ' ' + year + ' | ' + h + ':' + m + ':' + s;

            setTimeout(jam, 1000); // no need to pass the function name as a string
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>

    @include('layouts.script')

</body>

</html>
