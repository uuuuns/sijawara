<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\FileUpload;

class SettingController extends Controller
{
    public function index()
    {
        $data['title'] = "Setting";

        $data["carousel"] = DB::select("
            SELECT
                id_carousel,
                gambar,
                link 
            FROM 
                tb_carousel
        ");
        $data['admin'] = true;
        return
            view('template.header', $data) .
            view('template_admin.setting_carousel', $data) .
            view('template.footer', $data);
    }

    public function addCarousel(Request $request)
    {
        $data = $request->all();

        $data_carousel = [
            'gambar' => FileUpload::S3($request->file('gambar'), 'CAROUSEL', 'Image' . strtotime(now())),
            'link' => $data['link']
        ];

        DB::table('tb_carousel')->insert($data_carousel);

        return redirect()->back();
    }
    public function editCarousel(Request $request)
    {
        $data = $request->all();

        $data_carousel = [
            'gambar' => FileUpload::S3($request->file('gambar'), 'CAROUSEL', 'Image' . strtotime(now())),
            'link' => $data['link']
        ];

        DB::table('tb_carousel')->insert($data_carousel);

        return redirect()->back();
    }

    public function deleteCarousel(Request $request)
    {
        DB::table('tb_carousel')->where('id_carousel', $request->input('id_carousel'))->delete();

        return redirect()->back();
    }

    public function testimoni_index()
    {
        $data['title'] = "Setting";

        $data["testimoni"] = DB::select("
            SELECT
                id_testimoni,
                nama,
                testimoni
            FROM 
                tb_testimoni
        ");
        $data['admin'] = true;
        return
            view('template.header', $data) .
            view('template_admin.setting_testimoni', $data) .
            view('template.footer', $data);
    }

    public function addTestimoni(Request $request)
    {

        $data_testimoni = [
            'testimoni' => $request->input('testimoni'),
            'nama' => $request->input('nama')
        ];
        DB::table('tb_testimoni')->insert($data_testimoni);

        return redirect()->back();
    }
    public function editTestimoni(Request $request)
    {
        $data_testimoni = [
            'testimoni' => $request->input('up_testimoni'),
            'nama' => $request->input('up_nama')
        ];
        DB::table('tb_testimoni')->where('id_testimoni', $request->input('up_id_testimoni'))->update($data_testimoni);

        return redirect()->back();
    }

    public function deleteTestimoni(Request $request)
    {
        DB::table('tb_testimoni')->where('id_testimoni', $request->input('id_testimoni'))->delete();

        return redirect()->back();
    }
}
