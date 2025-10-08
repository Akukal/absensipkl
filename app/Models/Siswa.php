<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_perusahaan',
        'kelas',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function absen(){
        return $this->hasMany(Absen::class, 'id_siswa', 'id');
    }

    public function perusahaan(){
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }

    public function guru(){
        return $this->belongsTo(Guru::class, 'id_guru', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
