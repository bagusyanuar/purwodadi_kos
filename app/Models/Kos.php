<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    use HasFactory;

    protected $table = 'kos';

    protected $fillable = [
        'pemilik_kos_id',
        'wilayah_id',
        'nama',
        'embedded_map',
    ];

    public function pemilik_kos()
    {
        return $this->belongsTo(PemilikKos::class, 'pemilik_kos_id');
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    public function peraturan()
    {
        return $this->belongsToMany(Peraturan::class, 'peraturan_kos');
    }

    public function fasilitas_umum()
    {
        return $this->belongsToMany(FasilitasUmum::class, 'kos_fasilitas_umum');
    }
}
