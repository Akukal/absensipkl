<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Siswa;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Helper function untuk mendapatkan atau membuat data siswa.
     * Ini untuk menghindari duplikasi kode.
     */
    private function getOrCreateSiswa($user)
    {
        $siswa = Siswa::where('id_user', $user->id)->first();

        // Jika data siswa tidak ada DAN level user adalah siswa, buatkan data baru.
        if (!$siswa && $user->level == 'siswa') {
            return Siswa::create([
                'id_user' => $user->id,
                // id_perusahaan dan kelas akan null (nullable) sampai diset kemudian
            ]);
        }
        
        return $siswa;
    }

    /**
     * Menampilkan halaman dashboard siswa.
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = $this->getOrCreateSiswa($user);

        // Jika setelah dicek/dibuat data siswa tetap tidak ada (misal, user bukan siswa), logout.
        if (!$siswa) {
            return redirect('/logout')->with(['error' => 'Data siswa Anda tidak dapat ditemukan atau dibuat.']);
        }

        // Ambil data lain hanya jika $siswa ditemukan.
        $perusahaan = $siswa->id_perusahaan ? Perusahaan::find($siswa->id_perusahaan) : null;
        $absen = Absen::where('id_siswa', $siswa->id)
                      ->whereDate('tanggal', Carbon::today())
                      ->first();

        $data = [
            'absen'       => $absen,
            'title'       => 'Home',
            'akun'        => $user,
            'siswa'       => $siswa,
            'perusahaan'  => $perusahaan
        ];
        return view('Siswa.dashboard', $data); // Menghapus spasi setelah nama view
    }

    /**
     * Menampilkan halaman form absen.
     */
    public function create()
    {
        $user = Auth::user();
        $siswa = $this->getOrCreateSiswa($user);
        $absen = null;
        if ($siswa) {
            $absen = Absen::where('id_siswa', $siswa->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();
        }
        $data = [
            'hari'  => date("d-m-Y"),
            'title' => 'Absensi',
            'absen' => $absen
        ];
        return view('Siswa.create', $data);
    }

    /**
     * Menampilkan halaman opsi absen.
     */
    public function opsi()
    {
        $data = [
            'title' => 'Absen'
        ];
        return view('Siswa.opsi', $data);
    }

    /**
     * Menampilkan halaman form izin.
     */
    public function izin()
    {
        $data = [
            'title' => 'Izin'
        ];
        return view('Siswa.createth', $data);
    }

    /**
     * Menyimpan data izin.
     */
    public function izinstore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto' => 'required|mimes:jpg,jpeg,png'
        ]);
    
        if ($validator->fails()) {
            return redirect('/izin')->with(['error' => true, 'message' => 'Format Harus jpg, jpeg, atau png']);
        }

        $siswa = $this->getOrCreateSiswa(Auth::user());
        if (!$siswa) {
            return redirect('/logout')->with(['error' => 'Data siswa tidak ditemukan.']);
        }

        // Lebih efisien menggunakan firstOrCreate untuk membuat data absen jika belum ada.
        $absensi = Absen::firstOrCreate(
            [
                'id_siswa' => $siswa->id,
                'tanggal'  => Carbon::now()->toDateString(),
            ],
            [
                'status' => 'Tidak Hadir'
            ]
        );

        if ($absensi->status != 'Tidak Hadir') {
            return redirect('/izin')->with(['error' => true, 'message' => 'Anda Sudah Absen atau Izin Hari Ini']);
        }

        $img = $request->file('foto');
        $nama = Auth::user()->id . "-" . Carbon::now()->toDateString() . "-" . rand(1, 1000000) . "." . $img->getClientOriginalExtension();
        $img->storeAs('public/absensi', $nama);

        $absensi->status = 'Izin';
        $absensi->foto = $nama;
        $absensi->keterangan = $request->keterangan;
        $absensi->save();

        return redirect('/izin')->with(['true' => true]);
    }

    /**
     * Menyimpan data absen masuk/keluar.
     */
    public function store(Request $request)
    {
        $siswa = $this->getOrCreateSiswa(Auth::user());
        if (!$siswa) {
            return response()->json(['absen' => false, 'message' => 'Data siswa tidak ditemukan.']);
        }

        $today = Carbon::now()->toDateString();
        $attendanceType = $request->attendance_type; // Only used for "masuk"
        
        $absensi = Absen::firstOrCreate(
            [
                'id_siswa' => $siswa->id,
                'tanggal'  => $today,
            ],
            [
                'status' => 'Tidak Hadir',
                'tanggal' => $today
            ]
        );
        
        if ($absensi->tanggal === null) {
            $absensi->tanggal = $today;
            $absensi->save();
        }

        // For WFH, we don't require location validation
        if (
            ($attendanceType === 'WFO' || $absensi->status === 'Hadir') // check both request and stored
            && $request->lokasi == null
        ) {
            return response()->json(['absen' => false, 'message' => 'Lokasi tidak Terbaca, Mohon Coba Lagi']);
        }
        
        // Proses Absen Masuk
        if ($absensi->jam_masuk == null && $absensi->status == 'Tidak Hadir') {
            if (Carbon::now()->hour < 7) {
                return response()->json(['absen' => false, 'message' => 'Anda Baru Bisa Absen Masuk Pada 07:00']);
            }
            
            $foto = $request->image;
            $nama = Auth::user()->id . "-" . $today . "-" . rand(1, 1000000);
            $img_exp = explode(";base64", $foto);
            $foto_64 = base64_decode($img_exp[1]);
            $file = $nama . ".png";
            
            Storage::disk('public')->put('absensi/' . $file, $foto_64);
            
            // Set status based on attendance type (lock it for today)
            if ($attendanceType === 'WFH') {
                $absensi->status = 'WFH';
            } else {
                $absensi->status = 'Hadir';
            }
            
            $absensi->jam_masuk = Carbon::now()->toTimeString();
            $absensi->foto_masuk = $file;
            $absensi->lokasi_masuk = $request->lokasi ?? 'WFH-Location';
            $absensi->save();
            
            $message = $attendanceType === 'WFH' ? 'Absensi WFH Masuk Berhasil' : 'Absensi Masuk Berhasil';
            return response()->json(['absen' => true, 'message' => $message]);

    // Proses Absen Pulang
    } elseif ($absensi->jam_masuk != null && $absensi->jam_keluar == null) {
        if (Carbon::now()->hour < 14) {
            return response()->json(['absen' => false, 'message' => 'Anda Baru Bisa Absen Pulang Pada 14:00']);
        }

        $foto = $request->image;
        $nama = Auth::user()->id . "-" . $today . "-" . rand(1, 1000000);
        $img_exp = explode(";base64", $foto);
        $foto_64 = base64_decode($img_exp[1]);
        $file = $nama . ".png";
        
        Storage::disk('public')->put('absensi/' . $file, $foto_64);

        // Use the stored status (locked from "masuk")
        $absensi->jam_keluar = Carbon::now()->toTimeString();
        $absensi->foto_keluar = $file;
        $absensi->lokasi_keluar = $request->lokasi ?? 'WFH-Location';
        $absensi->save();
        
        $message = $absensi->status === 'WFH' ? 'Absensi WFH Keluar Berhasil' : 'Absensi Keluar Berhasil';
        return response()->json(['absen' => true, 'message' => $message]);
    } else {
        return response()->json(['absen' => false, 'message' => 'Anda Sudah Absen Hari Ini']);
    }
}

    /**
     * Menampilkan halaman histori absensi.
     */
    public function histori(Request $request)
    {
        $user = Auth::user();
        $siswa = $this->getOrCreateSiswa($user);

        if (!$siswa) {
            return redirect('/logout')->with(['error' => 'Data siswa tidak ditemukan.']);
        }

        $perusahaan = $siswa->id_perusahaan ? Perusahaan::find($siswa->id_perusahaan) : null;
        
        $bulan = $request->bulan ?? Carbon::now()->month;
        $absen = Absen::where('id_siswa', $siswa->id)
              ->where(function($query) use ($bulan) {
                  $query->whereMonth('tanggal', $bulan)
                        ->orWhereNull('tanggal');
              })
              ->get();

        $data = [
            'title'       => 'Histori',
            'bulan'       => $bulan,
            'absen'       => $absen,
            'akun'        => $user,
            'siswa'       => $siswa,
            'perusahaan'  => $perusahaan
        ];
        return view('Siswa.histori', $data);
    }
}
