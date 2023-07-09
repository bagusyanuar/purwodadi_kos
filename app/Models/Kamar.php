<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';

    protected $fillable = [
        'kos_id',
        'nama',
        'harga',
        'ukuran',
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }

    public function gambar()
    {
        return $this->hasMany(GambarKamar::class, 'kamar_id');
    }

    public function fasilitas_kamar()
    {
        return $this->belongsToMany(FasilitasKamar::class, 'kamar_fasilitas_kamar', 'kamar_id', 'fasilitas_kamar_id');
    }
}
