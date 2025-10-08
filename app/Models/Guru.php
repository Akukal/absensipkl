<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nohp'
    ];

    public function perusahaan(){
        return $this->hasMany(Perusahaan::class, 'id_guru', 'id');
    }

    public function user(){
        return $this->belongsto(User::class, 'id_user', 'id');
    }

    public function siswa(){
        return $this->hasMany(Siswa::class, 'id_guru', 'id');
    }
}
