<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use Carbon\Carbon;
use App\Models\Guru;
use App\Models\User;
use App\Models\Absen;
use App\Models\Siswa;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function dashboard(){
        $data = [
            'title' => 'Dashboard',
            'hadir' => Absen::where('status', 'Hadir')->count(),
            'tidak' => Absen::where('status', 'Tidak Hadir')->count(),
            'izin' => Absen::where('status', 'Izin')->count()
        ];
        return view('Guru.dashboard', $data);
    }

    public function perusahaan(){
        $data = [
            'title' => 'Perusahaan',
            'guru' => Guru::with('user')->get()->sortBy(function ($guru) { return $guru->user->nama;}),
            'perusahaan' => Perusahaan::all()
        ];

        return view('Guru.Perusahaan.index', $data);
    }

    public function addPerusahaan(Request $request){
        $perusahaan = new Perusahaan();
        $perusahaan->nama = $request->nama_perusahaan;
        $perusahaan->alamat = $request->alamat_perusahaan;
        $perusahaan->pj = $request->pj_perusahaan;
        $perusahaan->nohp = $request->no_pj;
        $perusahaan->id_guru = $request->guru;
        $perusahaan->save();

        return redirect('/perusahaan')->with(['success' => 'Data Perusahaan Berhasil Dibuat']);
    }
    public function detail($id){
        $perusahaan = Perusahaan::find($id);
        
        // Check if company exists
        if (!$perusahaan) {
            return redirect('/perusahaan')->with(['error' => 'Perusahaan tidak ditemukan']);
        }
        
        // Get students with their user data for better display
        $siswa = Siswa::where('id_perusahaan', $id)
                    ->with('user') // Assuming you have a relationship defined
                    ->get();

        // dd($siswa, $perusahaan, $id);
        
        $data = [
            'title' => $perusahaan->nama, // More efficient than making another query
            'perusahaan' => $perusahaan,
            'siswa' => $siswa,
            'guru' => Guru::whereNot('id', $perusahaan->id_guru)->with('user')->get(),
            'id' => $id
        ];

        return view('Guru.Perusahaan.detail', $data);
    }

    public function edit(Request $request, $id){
        $perusahaan = Perusahaan::find($id);
        $perusahaan->nama = $request->nama_perusahaan;
        $perusahaan->alamat = $request->alamat_perusahaan;
        $perusahaan->pj= $request->pj_perusahaan;
        $perusahaan->nohp = $request->no_pj;
        $perusahaan->id_guru = $request->guru;
        $perusahaan->save();

        return back()->with(['success' => true]);
    }
    

    public function siswa(Request $request){
        // Jika tidak ada parameter, tampilkan semua siswa
        if(!$request->has(['kelas', 'perusahaan', 'filter'])) {
            $siswa = Siswa::with(['user', 'perusahaan'])->get();
            
            $data = [
                'title' => 'Data Siswa',
                'siswa' => $siswa,
                'perusahaan' => Perusahaan::orderBy('nama')->get(),
                'view_type' => 'siswa', // untuk membedakan view
                'reqkelas' => null,
                'reqperusahaan' => null,
                'reqfilter' => null,
                'absen' => collect() // empty collection untuk konsistensi
            ];
            
            return view('Guru.siswa', $data);
        }

        // Existing code for absensi filtering...
        if($request->kelas == null && $request->perusahaan == null && $request->filter == null){
            $absen = Absen::whereDate('tanggal', Carbon::now()->toDateString())->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();

        } elseif ($request->kelas == null && $request->perusahaan == null && $request->filter != null) {
            $absen = Absen::whereMonth('tanggal', $request->filter)->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();

        } elseif ($request->kelas == null && $request->perusahaan != null && $request->filter != null){
            $absen = Absen::whereMonth('tanggal', $request->filter)->whereHas('siswa', function ($query) use ($request) {
                $query->where('id_perusahaan', $request->perusahaan);
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();
            
        } elseif ($request->kelas != null && $request->perusahaan == null && $request->filter == null) {
            $absen = Absen::whereDate('tanggal', Carbon::now()->toDateString())->whereHas('siswa', function ($query) use ($request) {
                $query->where('kelas', $request->kelas);
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();

        } elseif ($request->kelas != null && $request->perusahaan == null && $request->filter != null) {
            $absen = Absen::whereMonth('tanggal', $request->filter)->whereHas('siswa', function ($query) use ($request) {
                $query->where('kelas', $request->kelas);
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();

        } elseif ($request->kelas != null && $request->perusahaan != null && $request->filter == null) {
            $absen = Absen::whereDate('tanggal', Carbon::now()->toDateString())->whereHas('siswa', function ($query) use ($request) {
                $query->where('id_perusahaan', $request->perusahaan)->where('kelas', $request->kelas);
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();
        } elseif ($request->kelas == null && $request->perusahaan != null && $request->filter == null) {
            $absen = Absen::whereDate('tanggal', Carbon::now()->toDateString())->whereHas('siswa', function ($query) use ($request) {
                $query->where('id_perusahaan', $request->perusahaan);
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();
            
        } else {
            $absen = Absen::whereMonth('tanggal', $request->filter)->whereHas('siswa', function ($query) use ($request) {
                $query->where('id_perusahaan', $request->perusahaan)->when($request->kelas, function ($query, $kelas) {
                    $query->where('kelas', $kelas);
                });
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
              });
            }])->get();
        }
        
        $absen->transform(function($item){
            $tanggalArr = explode('-', $item->tanggal);
            $item->tanggal = $tanggalArr[2] . '-' . $tanggalArr[1] . '-' . $tanggalArr[0];
        
            return $item;
        });
        

        $data = [
            'title' => 'Rekap Absensi',
            'absen' => $absen,
            'perusahaan' => Perusahaan::orderBy('nama')->get(),
            'reqkelas' => $request->kelas,
            'reqperusahaan' => $request->perusahaan,
            'reqfilter' => $request->filter,
            'view_type' => 'absensi'
        ];
        
        return view('Guru.siswa', $data);
    }

    public function guru(){
        $data = [
            'title' => 'Guru',
            'guru' => Guru::all()->sortBy('nama')
        ];
        return view('Guru.guru', $data);
    }

    public function addGuru(Request $request){
        $user = new User();
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->level = 'guru';
        $user->save();

        $guru = new Guru();
        $guru->id_user = $user->id;
        $guru->nohp = $request->nohp;
        $guru->save();

        return redirect('/guru')->with(['success' => 'Data Guru Berhasil Dibuat']);
    }

    public function export(Request $request){
        return Excel::download(new AbsensiExport($request->kelas, $request->perusahaan, $request->filter), 'absensi.xlsx');
    }

    // CRUD Siswa Methods
    public function createSiswa(){
        try {
            // Pastikan eager loading dan filter data yang valid
            $recentSiswa = Siswa::with(['user'])
                ->whereHas('user') // Hanya ambil siswa yang punya user
                ->orderBy('created_at', 'desc')
                ->get();

            // Debug untuk melihat data
            \Log::info('Recent Siswa Count: ' . $recentSiswa->count());
            
            foreach($recentSiswa as $siswa) {
                \Log::info('Siswa ID: ' . $siswa->id, [
                    'has_user' => $siswa->user ? true : false,
                    'has_perusahaan' => $siswa->perusahaan ? true : false,
                    'user_id' => $siswa->id_user,
                    'perusahaan_id' => $siswa->id_perusahaan
                ]);
            }

            $data = [
                'title' => 'Tambah Siswa',
                'perusahaan' => Perusahaan::orderBy('nama')->get(),
                'recentSiswa' => $recentSiswa
            ];
            
            return view('Guru.Siswa.create', $data);
            
        } catch (\Exception $e) {
            \Log::error('Error in createSiswa:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            // Fallback dengan data kosong jika ada error
            $data = [
                'title' => 'Tambah Siswa',
                'perusahaan' => Perusahaan::orderBy('nama')->get(),
                'recentSiswa' => collect() // Empty collection
            ];
            
            return view('Guru.Siswa.create', $data);
        }
    }

    public function storeSiswa(Request $request){
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'kelas' => 'required|string|max:10',
            'id_perusahaan' => 'required|exists:perusahaan,id'
        ]);

        // Create user first
        $user = new User();
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->level = 'siswa';
        $user->save();

        // Create siswa record
        $siswa = new Siswa();
        $siswa->id_user = $user->id;
        $siswa->id_perusahaan = $request->id_perusahaan;
        $siswa->kelas = $request->kelas;
        $siswa->save();

        return redirect('/siswa/create')->with(['success' => 'Data Siswa Berhasil Dibuat']);
    }

    public function editSiswa($id){
        try {
            $siswa = Siswa::with(['user', 'perusahaan'])->find($id);
            
            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'siswa' => $siswa
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateSiswa(Request $request, $id){
        try {
            $siswa = Siswa::with('user')->find($id);
            
            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak ditemukan'
                ], 404);
            }

            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $siswa->user->id,
                'kelas' => 'required|string|max:10',
                'id_perusahaan' => 'required|exists:perusahaan,id'
            ]);

            // Update user data
            $siswa->user->nama = $request->nama;
            $siswa->user->email = $request->email;
            $siswa->user->save();

            // Update siswa data
            $siswa->kelas = $request->kelas;
            $siswa->id_perusahaan = $request->id_perusahaan;
            $siswa->save();

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diupdate'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteSiswa($id){
        try {
            $siswa = Siswa::with('user')->find($id);
            
            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak ditemukan'
                ], 404);
            }

            // Store nama for response
            $nama = $siswa->user->nama;

            // Delete user (will cascade to siswa if foreign key is set properly)
            $siswa->user->delete();
            $siswa->delete();

            return response()->json([
                'success' => true,
                'message' => "Data siswa {$nama} berhasil dihapus"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
        public function weeklyAttendance(Request $request){
        try {
            // Get current week or requested week
            $startDate = $request->input('start_date', Carbon::now()->startOfWeek());
            $startDate = Carbon::parse($startDate)->startOfWeek();
            
            // Generate 7 days from start date
            $weekDates = [];
            for ($i = 0; $i < 7; $i++) {
                $weekDates[] = $startDate->copy()->addDays($i);
            }
            
            // Base query for students
            $query = Siswa::with(['user', 'perusahaan']);
            
            // Apply filters
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            }
            
            if ($request->filled('kelas')) {
                $query->where('kelas', $request->kelas);
            }
            
            if ($request->filled('perusahaan')) {
                $query->where('id_perusahaan', $request->perusahaan);
            }
            
            // Get per_page from request with default of 20, validate range
            $perPage = $request->input('per_page', 20);
            $perPage = in_array($perPage, [10, 20, 50]) ? $perPage : 20;
            
            // Add pagination with dynamic per_page
            $siswa = $query->orderBy('kelas')
                        ->orderBy(function($q) {
                            $q->select('nama')
                                ->from('users')
                                ->whereColumn('users.id', 'siswa.id_user');
                        })
                        ->paginate($perPage);
            
            // Append current query parameters to pagination links
            $siswa->appends($request->all());
            
            // Get attendance data for the current page students only
            $attendanceData = [];
            foreach ($siswa as $student) {
                $studentAttendance = [];
                foreach ($weekDates as $date) {
                    $attendance = Absen::where('id_siswa', $student->id)
                                    ->whereDate('tanggal', $date->format('Y-m-d'))
                                    ->first();
                    $studentAttendance[] = $attendance ? $attendance->status : null;
                }
                $attendanceData[$student->id] = $studentAttendance;
            }
            
            // Get unique classes and companies for filters
            $kelasList = Siswa::distinct()->pluck('kelas')->sort()->values();
            $perusahaanList = Perusahaan::orderBy('nama')->get();
            
            // Get total count for display (before pagination)
            $totalSiswa = Siswa::when($request->filled('search'), function($q) use ($request) {
                    $q->whereHas('user', function($subQ) use ($request) {
                        $subQ->where('nama', 'like', "%{$request->search}%");
                    });
                })
                ->when($request->filled('kelas'), function($q) use ($request) {
                    $q->where('kelas', $request->kelas);
                })
                ->when($request->filled('perusahaan'), function($q) use ($request) {
                    $q->where('id_perusahaan', $request->perusahaan);
                })
                ->count();
            
            $data = [
                'title' => 'Absensi Mingguan',
                'siswa' => $siswa,
                'weekDates' => $weekDates,
                'attendanceData' => $attendanceData,
                'startDate' => $startDate,
                'kelasList' => $kelasList,
                'perusahaanList' => $perusahaanList,
                'totalSiswa' => $totalSiswa,
                'filters' => [
                    'search' => $request->search,
                    'kelas' => $request->kelas,
                    'perusahaan' => $request->perusahaan
                ]
            ];
            
            return view('Guru.Siswa.weekly-attendace', $data);
            
        } catch (\Exception $e) {
            \Log::error('Error in weeklyAttendance:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data absensi mingguan');
        }
    }
}