<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function redirectGoogle(){
        // KOREKSI: Menambahkan stateless() untuk menghindari InvalidStateException
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback(){
        try{
            // KOREKSI: Menambahkan stateless() agar cocok dengan redirect
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->email)->first();

            if($user){
                // Jika user ditemukan, langsung login
                Auth::login($user);
            } else {
                // Jika user tidak ditemukan, buat user baru
                $newLevel = 'siswa'; // Level default
                if ($googleUser->email == 'gilbertsibuea8539@gmail.com') {
                    // KOREKSI: Mengubah level menjadi 'guru' agar sesuai dengan ENUM di database
                    $newLevel = 'guru'; 
                }

                $newUser = new User();
                $newUser->nama = $googleUser->name;
                $newUser->email = $googleUser->email;
                $newUser->level = $newLevel;
                $newUser->save(); // Simpan user baru ke database

                Auth::login($newUser);
            }

            // Arahkan ke halaman yang benar setelah login
            if(Auth::user()->level == 'siswa'){
                return redirect()->intended('/home');
            } else {
                return redirect()->intended('/dashboard');
            }

        } catch (Exception $e) {
            // Mengembalikan ke halaman login dengan pesan error jika ada masalah
            return redirect('/')->with(['error' => 'Terjadi kesalahan saat login, silahkan coba lagi']);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
