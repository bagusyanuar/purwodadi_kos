<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\FasilitasKamar;
use App\Models\FasilitasUmum;
use App\Models\GambarKamar;
use App\Models\Kamar;
use App\Models\Kos;
use App\Models\PemilikKos;
use App\Models\Peraturan;
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
                    'harga' => $this->postField('harga'),
                    'kos_id' => $this->postField('kos'),
                    'ukuran' => $this->postField('ukuran'),
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
                'harga' => $this->postField('harga'),
                'kos_id' => $this->postField('kos'),
                'ukuran' => $this->postField('ukuran'),
            ];
            $fasilitas_kamar = $this->postField('fasilitas_kamar');
            $data->fasilitas_kamar()->sync($fasilitas_kamar);
            $data->update($data_request);
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
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
        DB::beginTransaction();
        try {
            $kamar = Kamar::with(['gambar'])->find($id);
            if ($this->request->method() === 'POST') {
                if ($this->request->hasFile('file')) {
                    foreach ($this->request->file('file') as $file) {
                        $name = $this->uuidGenerator() . '.' . $file->getClientOriginalExtension();
                        Storage::disk('kamar')->put($name, File::get($file));
                        $images_data = [
                            'kamar_id' => $kamar->id,
                            'gambar' => $name
                        ];
                        GambarKamar::create($images_data);
                    }
                    DB::commit();
                    return $this->jsonResponse('success', 200);
                }
            }

            return $this->jsonResponse('success', 200, [
                'data' => $kamar->gambar
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('failed', 500);
        }
    }

    public function dropImages($id)
    {
        try {
            GambarKamar::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
