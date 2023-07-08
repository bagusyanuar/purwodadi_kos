<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\FasilitasKamar;
use App\Models\FasilitasUmum;
use App\Models\Kamar;
use App\Models\Kos;
use App\Models\PemilikKos;
use App\Models\Peraturan;
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;

class KamarController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            DB::beginTransaction();
            try {
                $data_request = [
                    'nama' => $this->postField('nama'),
                    'harga'  => $this->postField('harga'),
                    'kos_id'  => $this->postField('kos'),
                ];
                $fasilitas_kamar = $this->postField('fasilitas_kamar');
                $kamar = Kamar::create($data_request);
                $kamar->fasilitas_kamar()->attach($fasilitas_kamar);
                DB::commit();
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }
        if ($this->request->ajax()) {
            $data = Kamar::with(['kos', 'fasilitas_kamar'])->get();
            return $this->basicDataTables($data);
        }
        $kos = Kos::all();
        $fasilitas_kamar = FasilitasKamar::all();
        return view('admin.kamar.index')->with([
            'kos' => $kos,
            'fasilitas_kamar' => $fasilitas_kamar,
        ]);
    }

    public function patch($id)
    {
        DB::beginTransaction();
        try {
            $data = Kamar::find($id);
            $data_request = [
                'nama' => $this->postField('nama'),
                'harga'  => $this->postField('harga'),
                'kos_id'  => $this->postField('kos'),
            ];
            $fasilitas_kamar = $this->postField('fasilitas_kamar');
            $data->fasilitas_kamar()->sync($fasilitas_kamar);
            $data->update($data_request);
            DB::commit();
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $kamar = Kamar::find($id);
            $kamar->fasilitas_kamar()->detach();
            $kamar->delete();
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('failed', 500);
        }
    }

    public function images($id)
    {
        try {
            $kamar = Kamar::with(['gambar'])->find($id);
            return $this->jsonResponse('success', 200, [
                'data' => $kamar->gambar
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
