<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\PemilikKos;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PemilikKosController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            try {
                $data_request = [
                    'nama' => $this->postField('nama'),
                    'no_hp' => $this->postField('no_hp'),
                    'alamat' => $this->postField('alamat'),
                ];
                PemilikKos::create($data_request);
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }
        if ($this->request->ajax()) {
            $data = PemilikKos::with([])->get();
            return $this->basicDataTables($data);
        }
        return view('admin.pemilik-kos.index');
    }

    public function patch($id)
    {
        try {
            $data = PemilikKos::find($id);
            $data_request = [
                'nama' => $this->postField('nama'),
                'no_hp' => $this->postField('no_hp'),
                'alamat' => $this->postField('alamat'),
            ];
            $data->update($data_request);
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            PemilikKos::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
