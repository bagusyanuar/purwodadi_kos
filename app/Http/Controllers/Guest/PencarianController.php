<?php


namespace App\Http\Controllers\Guest;


use App\Helper\CustomController;
use App\Models\Kamar;
use App\Models\Wilayah;

class PencarianController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $param = $this->field('p');
            $w = $this->field('wilayah');
            $sort = $this->field('sort');
            try {
                $query = Kamar::with(['kos.pemilik_kos', 'kos.wilayah', 'gambar', 'fasilitas_kamar']);
                if ($param !== "") {
                    $query->where('nama', 'LIKE', '%' . $param . '%');
                }

                if ($w !== "") {
                    $query->whereHas('kos', function ($q) use ($w) {
                        return $q->where('wilayah_id', '=', $w);
                    });
                }

                if ($sort === 'DESC') {
                    $query->orderBy('harga', 'DESC');
                } else {
                    $query->orderBy('harga', 'ASC');
                }

                $data = $query->get();
                return $this->jsonResponse('success', 200, $data);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }
        $wilayah = Wilayah::all();
        return view('guest.pencarian')->with(['wilayah' => $wilayah]);
    }


}
