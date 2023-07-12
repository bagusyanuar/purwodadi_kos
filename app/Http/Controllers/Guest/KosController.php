<?php


namespace App\Http\Controllers\Guest;


use App\Helper\CustomController;
use App\Models\Kamar;
use App\Models\Kos;
use App\Models\Wilayah;

class KosController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($kos)
    {
        if ($this->request->ajax()) {
            $param = $this->field('p');
            $sort = $this->field('sort');
            try {
                $query = Kamar::with(['kos.pemilik_kos', 'kos.wilayah', 'gambar', 'fasilitas_kamar'])->where('kos_id', '=', $kos);
                if ($param !== "") {
                    $query->where('nama', 'LIKE', '%' . $param . '%');
                }

                if ($sort === 'DESC') {
                    $query->orderBy('harga', 'DESC');
                } else {
                    $query->orderBy('harga', 'ASC');
                }

                $data = $query->get();
                return $this->jsonResponse('success', 200, $data);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }
        $wilayah = Wilayah::all();
        $data = Kos::with(['pemilik_kos', 'wilayah'])->findOrFail($kos);
        return view('guest.kos')->with(['data' => $data, 'wilayah' => $wilayah]);
    }
}
