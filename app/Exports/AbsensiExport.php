<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Absen;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AbsensiExport implements FromView, ShouldAutoSize
{

    public $kelas, $perusahaan, $filter;

    public function __construct($kelas, $perusahaan, $filter)
    {
        $this->kelas = $kelas;
        $this->perusahaan = $perusahaan;
        $this->filter = $filter;
    }

    public function view(): View
    {

        if($this->kelas == null && $this->perusahaan == null && $this->filter == null){
            $absen = Absen::whereDate('tanggal', Carbon::now()->toDateString())->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();

        } elseif ($this->kelas == null && $this->perusahaan == null && $this->filter != null) {
            $absen = Absen::whereMonth('tanggal', $this->filter)->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();

        } elseif ($this->kelas == null && $this->perusahaan != null && $this->filter != null){
            $absen = Absen::whereMonth('tanggal', $this->filter)->whereHas('siswa', function ($query){
                $query->where('id_perusahaan', $this->perusahaan);
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();
            
        } elseif ($this->kelas != null && $this->perusahaan == null && $this->filter == null) {
            $absen = Absen::whereDate('tanggal', Carbon::now()->toDateString())->whereHas('siswa', function ($query){
                $query->where('kelas', $this->kelas);
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();

        } elseif ($this->kelas != null && $this->perusahaan == null && $this->filter != null) {
            $absen = Absen::whereMonth('tanggal', $this->filter)->whereHas('siswa', function ($query){
                $query->where('kelas', $this->kelas);
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();

        } elseif ($this->kelas != null && $this->perusahaan != null && $this->filter == null) {
            $absen = Absen::whereDate('tanggal', Carbon::now()->toDateString())->whereHas('siswa', function ($query){
                $query->where('id_perusahaan', $this->perusahaan)->where('kelas', $this->kelas);
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();
        } elseif ($this->kelas == null && $this->perusahaan != null && $this->filter == null) {
            $absen = Absen::whereDate('tanggal', Carbon::now()->toDateString())->whereHas('siswa', function ($query){
                $query->where('id_perusahaan', $this->perusahaan);
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
                });
            }])->get();
            
        } else {
            $absen = Absen::whereMonth('tanggal', $this->filter)->whereHas('siswa', function ($query){
                $query->where('id_perusahaan', $this->perusahaan)->when($this->kelas, function ($query, $kelas) {
                    $query->where('kelas', $kelas);
                });
            })->with(['siswa' => function ($query) {
                $query->with('user')->orderBy('kelas')->orderBy(function ($query) {
                    $query->select('nama')->from('users')->whereColumn('users.id', 'siswa.id_user');
              });
            }])->get();
        }
        
        return view('export.absensi', ['data' => $absen]);
    }

}
