<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="Presensi PKL" />
    <meta property="og:description" content="Siakad PKL SMK Prestasi Prima" />
    <meta property="og:image" content="{{ asset('assets/img/icon-512.png') }}" />
    <meta name="description" content="Siakad PKL SMK Prestasi Prima">
    <meta name="keywords" content="SIAKAD PKL SMK PRESTASI PRIMA" />
    <meta name="theme-color" content="#004AAD">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Presensi PKL</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <!-- KOREKSI: Path gambar diubah untuk menyertakan '/assets/' -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon-512.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon-512.png') }}">

    {{-- <style>
        /* Google Fonts - Poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            column-gap: 30px;
            background-color: #f0f2f5; /* Menambahkan background agar lebih terlihat */
        }

        .form {
            max-width: 430px; /* Sedikit diperlebar */
            width: 100%;
            padding: 30px;
            border-radius: 8px; /* Sedikit lebih bulat */
            background-color: #fff; /* Menambahkan background putih */
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* Menambahkan bayangan */
        }

        header {
            font-size: 28px;
            font-weight: 600;
            color: #232836;
            text-align: center;
        }

        form {
            margin-top: 30px;
        }

        .form .field {
            position: relative;
            height: 50px;
            width: 100%;
            margin-top: 20px;
            border-radius: 6px;
        }

        .field input,
        .field button {
            height: 100%;
            width: 100%;
            border: none;
            font-size: 16px;
            font-weight: 400;
            border-radius: 6px;
        }

        .field input {
            outline: none;
            padding: 0 15px;
            border: 1px solid#CACACA;
        }

        .field input:focus {
            border-color: #0171d3; /* Mengubah warna border saat focus */
        }

        .field button {
            color: #fff;
            background-color: #0171d3;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .field button:hover {
            background-color: #016dcb;
        }
        
        .media-options a {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            height: 50px;
            width: 100%;
            color: #232836;
            background-color: #fff;
            border: 1px solid #CACACA;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .media-options a:hover {
            background-color: #f2f2f2;
        }

        img.google-img {
            height: 20px;
            width: 20px;
            margin-right: 12px;
        }
    </style> --}}

    <style>
        .animated-background {
            background-size: 400%;

            -webkit-animation: animation 10s ease infinite;
            -moz-animation: animation 10s ease infinite;
            animation: animation 10s ease infinite;
        }

        @keyframes animation {
            0%,
            100% {
                background-position: 80%;
            }
            
            50% {
                background-position: 40%;
            }
        }

        .anim-open1 {
            animation: opening 1s linear forwards;
            opacity: 0;
        }

        .anim-open2 {
            animation: opening 1s linear forwards;
            animation-delay: 0.5s;
            opacity: 0;
        }

        .anim-open3 {
            animation: opening 1s linear forwards;
            animation-delay: 0.7s;
            opacity: 0;
        }

        .anim-open4 {
            animation: opening 1s linear forwards;
            animation-delay: 0.9s;
            opacity: 0;
        }

        .anim-open5 {
            animation: opening 1s linear forwards;
            animation-delay: 1.1s;
            opacity: 0;
        }

        .anim-open6 {
            animation: opening 1s linear forwards;
            animation-delay: 1.3s;
            opacity: 0;
        }

        @keyframes opening {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

    </style>
    
</head>

<body class="font-['Poppins'] bg-gray-950 bg-gradient-to-br animated-background from-orange-900 to-gray-950 w-full min-h-screen flex items-center justify-center text-white">
{{-- <section class="bg-red-200">
        <div class="form login">
            <!-- KOREKSI: Path gambar diubah untuk menyertakan '/assets/' -->
            <img src="{{ asset('assets/img/icon-512.png') }}" alt="Logo" style="width: 80px; height: auto; display: block; margin: 0 auto 20px;">
            <div class="form-content">
                <header>Login Presensi PKL</header>
            </div>

            <div class="media-options" style="margin-top: 30px;">
                <!-- Pakai API GOOGLE -->
                <a href="/auth/google" class="google">
                    <!-- KOREKSI: Path gambar diubah untuk menyertakan '/assets/' -->
                    <img src="{{ asset('assets/img/google.png') }}" alt="Google Logo" class="google-img">
                    <span><b>Login Memakai Akun Sekolah</b></span>
                </a>
            </div>

            <div style="text-align: center; margin-top: 40px; color: #8b8b8b; font-size: 14px;">
                <b>Created by Orens Solution Prestasi Prima</b>
            </div>
        </div>
    </section> --}}

    <section class="w-full max-w-lg h-full flex flex-col items-center justify-center text-center px-6">
        <div class="flex flex-col items-center gap-6 rounded-2xl py-10 px-6 w-full">
            <img src="{{ asset('assets/img/icon-512.png') }}" class="min-w-20 sm:min-w-24 h-20 sm:h-24 object-contain rounded-full select-none transition anim-open1" draggable="false" alt="Logo" title="SMK Prestasi Prima">
            <div class="flex flex-col tracking-wide">
                <h1 class="text-3xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-300 mb-1 anim-open2">Presensi PKL</h1>
                <span class="text-base sm:text-xl text-gray-300 font-extrabold anim-open3">SMK Prestasi Prima</span>
            </div>
            <p class="text-gray-300 text-sm sm:text-base mb-2 anim-open4">Selamat datang di <span class="text-orange-400">Aplikasi Presensi PKL</span>.<br>Silakan login menggunakan akun sekolah Anda.</p>
        </div>
    </section>
    <section class="fixed bottom-6 flex flex-col w-full max-w-lg px-4">
        <a href="/auth/google" title="Login dengan Akun Sekolah" class="w-full flex items-center justify-center py-3 gap-3 bg-blue-950 hover:bg-blue-900/70 transition transform active:scale-95 rounded-lg shadow-lg border border-white/10 select-none text-sm sm:text-base mb-3 anim-open5">
            <svg viewBox="-3 0 262 262" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" fill="#000000" class="min-w-5 sm:min-w-6 h-5 sm:h-6">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027" fill="#4285F4"></path>
                    <path d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1" fill="#34A853"></path>
                    <path d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782" fill="#FBBC05"></path>
                    <path d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251" fill="#EB4335"></path>
                </g>
            </svg>
            <span class="text-gray-300 font-semibold tracking-wide">Login dengan Akun Sekolah</span>
        </a>
        <span class="w-full flex justify-center text-gray-500 text-xs anim-open6">&copy; Orens Solutions {{ date('Y') }}</span>
    </section>

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <!-- Base Js File -->
    <script src="{{ asset('assets/js/base.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('error'))
    <script>
        Swal.fire({
            icon: "error",
            title: "Oops..",
            text: "{{ session('error') }}"
        });
    </script>
    @endif

    <script>
        // You can change the texts here
        var OnlineText = "Connected to the Internet";
        var OfflineText = "No Internet Connection";

        // Online Mode Toast Append
        function onlineModeToast() {
            // Tambahkan toast dengan Tailwind, auto hilang setelah 3 detik
            const toastId = 'online-toast-' + Date.now();
            $("body").append(
                `<div id="${toastId}" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-lime-800 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-500 opacity-100">
                    <div class="in"><div class="text">${OnlineText}</div></div>
                </div>`
            );
            setTimeout(() => {
                $(`#${toastId}`).addClass('opacity-0');
                setTimeout(() => {
                    $(`#${toastId}`).remove();
                }, 500); // tunggu transisi hilang
            }, 3000);
        }

        // Ofline Mode Toast Append
        function offlineModeToast() {
            // Versi online: toast offline dengan style dan animasi tailwind, auto hilang setelah 3 detik
            const toastId = 'offline-toast-' + Date.now();
            $("body").append(
                `<div id="${toastId}" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-red-700 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-500 opacity-100">
                    <div class="in"><div class="text">${OfflineText}</div></div>
                </div>`
            );
            setTimeout(() => {
                $(`#${toastId}`).addClass('opacity-0');
                setTimeout(() => {
                    $(`#${toastId}`).remove();
                }, 500); // tunggu transisi hilang
            }, 3000);
        }

        // Online Mode Function
        function onlineMode() {
            if ($("#offline-toast").hasClass("show")) {
                $("#offline-toast").removeClass("show");
            }
            if ($("#online-toast").length > 0) {
                $("#online-toast").addClass("show");
                setTimeout(() => {
                    $("#online-toast").removeClass("show");
                }, 3000);
            }
            else {
                onlineModeToast();
            }
            $(".toast-box.tap-to-close").click(function () {
                $(this).removeClass("show");
            });
        }

        // Offline Mode Function
        function offlineMode() {
            if ($("#online-toast").hasClass("show")) {
                $("#online-toast").removeClass("show");
            }
            if ($("#offline-toast").length > 0) {
                $("#offline-toast").addClass("show");
            }
            else {
                offlineModeToast();
            }
            $(".toast-box.tap-to-close").click(function () {
                $(this).removeClass("show");
            });
        }

        // Check with event listener if online or offline
        window.addEventListener('online', onlineMode);
        window.addEventListener('offline', offlineMode);
    </script>
</body>

</html>
