<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\FasilitasUmum;
use App\Models\Kos;
use App\Models\PemilikKos;
use App\Models\Peraturan;
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;

class KosController extends CustomController
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
                    'pemilik_kos_id' => $this->postField('pemilik_kos'),
                    'wilayah_id'  => $this->postField('wilayah'),
                    'embedded_map'  => $this->postField('map'),
                ];
                $fasilitas_umum = $this->postField('fasilitas_umum');
                $peraturan = $this->postField('peraturan');
                $kos = Kos::create($data_request);
                $kos->fasilitas_umum()->attach($fasilitas_umum);
                $kos->peraturan()->attach($peraturan);
                DB::commit();
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }
        if ($this->request->ajax()) {
            $data = Kos::with(['pemilik_kos', 'wilayah', 'peraturan', 'fasilitas_umum'])->get();
            return $this->basicDataTables($data);
        }
        $wilayah = Wilayah::all();
        $pemilik_kos = PemilikKos::all();
        $fasilitas_umum = FasilitasUmum::all();
        $peraturan = Peraturan::all();
        return view('admin.kos.index')->with([
            'wilayah' => $wilayah,
            'pemilik_kos' => $pemilik_kos,
            'fasilitas_umum' => $fasilitas_umum,
            'peraturan' => $peraturan
        ]);
    }

    public function patch($id)
    {
        DB::beginTransaction();
        try {
            $data = Kos::find($id);
            $data_request = [
                'nama' => $this->postField('nama'),
                'pemilik_kos_id' => $this->postField('pemilik_kos'),
                'wilayah_id'  => $this->postField('wilayah'),
                'embedded_map'  => $this->postField('map'),
            ];
            $fasilitas_umum = $this->postField('fasilitas_umum');
            $peraturan = $this->postField('peraturan');
            $data->fasilitas_umum()->sync($fasilitas_umum);
            $data->peraturan()->sync($peraturan);
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
            $kos = Kos::find($id);
            $kos->peraturan()->detach();
            $kos->fasilitas_umum()->detach();
            $kos->delete();
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('failed', 500);
        }
    }


}
