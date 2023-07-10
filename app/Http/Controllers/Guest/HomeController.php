<?php


namespace App\Http\Controllers\Guest;


use App\Helper\CustomController;
use App\Models\Kamar;

class HomeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $kamar = Kamar::with(['kos.pemilik_kos', 'kos.wilayah' ,'gambar', 'fasilitas_kamar'])
            ->inRandomOrder()
            ->get()
            ->take(8);
        return view('guest.home')->with(['kamar' => $kamar]);
    }
}
