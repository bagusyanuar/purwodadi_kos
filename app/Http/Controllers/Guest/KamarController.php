<?php


namespace App\Http\Controllers\Guest;


use App\Helper\CustomController;
use App\Models\Kamar;

class KamarController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($kos, $id) {
        $data = Kamar::with(['kos.pemilik_kos', 'kos.wilayah', 'kos.peraturan', 'kos.fasilitas_umum', 'fasilitas_kamar', 'gambar'])
            ->where('kos_id', '=', $kos)
            ->where('id', '=', $id)
            ->firstOrFail();
        return view('guest.kamar')->with(['data' => $data]);
    }
}
