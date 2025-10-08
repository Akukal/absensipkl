<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;
    protected $table = 'perusahaan';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'alamat',
        'pj',
        'nohp',
        'id_guru',
    ];

    public function guru(){
        return $this->belongsTo(Guru::class, 'id_guru', 'id');
    }

    public function siswa(){
        return $this->hasMany(Siswa::class, 'id_perusahaan', 'id');
    }
}
