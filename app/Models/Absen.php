<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    
    protected $table = 'absen';
    public $timestamps = false;

    protected $fillable = [
        'id_siswa',
        'status',
        'jam_masuk',
        'foto_masuk',
        'lokasi_masuk',
        'jam_keluar',
        'foto_keluar',
        'lokasi_keluar',
        'foto',
        'keterangan',
    ];

    public function siswa(){
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
}
