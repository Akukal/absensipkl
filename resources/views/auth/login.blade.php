<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#004AAD">
    <title>Login - Presensi PKL</title>
    <meta name="description" content="Siakad PKL SMK Prestasi Prima">
    <meta name="keywords" content="SIAKAD PKL SMK PRESTASI PRIMA" />
    
    <!-- KOREKSI: Path gambar diubah untuk menyertakan '/assets/' -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon-512.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon-512.png') }}">

    <style>
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
    </style>
</head>

<body>
    <section class="container forms">
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
</body>

</html>
