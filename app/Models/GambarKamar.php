<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarKamar extends Model
{
    use HasFactory;

    protected $table = 'gambar_kamar';

    protected $fillable = [
        'kamar_id',
        'gambar'
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class,'kamar_id');
    }
}
