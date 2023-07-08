<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\FasilitasUmum;

class FasilitasUmumController extends CustomController
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
                ];
                FasilitasUmum::create($data_request);
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }
        if ($this->request->ajax()) {
            $data = FasilitasUmum::with([])->get();
            return $this->basicDataTables($data);
        }
        return view('admin.fasilitas-umum.index');
    }

    public function patch($id)
    {
        try {
            $data = FasilitasUmum::find($id);
            $data_request = [
                'nama' => $this->postField('nama'),
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
            FasilitasUmum::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
