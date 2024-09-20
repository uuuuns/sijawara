<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WidyaiswaraController extends Controller
{
    // Bentuk Controller
    public function index_widyaiswara()
    {
        $data['title'] = "Widyaiswara";

        $data["widyaiswara"] = DB::select("
            SELECT
                w.*
            FROM
                md_widyaiswara w
        ");   
        $data['admin'] = true;
        // Kirim data ke view
        return
            view('template.header', $data) .
            view('template_admin/master_data/widyaiswara', $data) .
            view('template.footer', $data);
    }    
    public function store_widyaiswara(Request $req)
    {
        $req->validate([
            'image_profile' => 'required|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = [
            'NAMA'  => $req->input('nama') ,
            'POSISI' => $req->input('posisi') ,
            'TENTANG' => $req->input('tentang')
        ];

        if($req->hasFile('image_profile')) {
            // Store the image on S3
            $data['IMAGE'] = FileUpload::S3($req->file('image_profile'), 'IMAGE_PROFILE', 'Image-profile-' . strtotime(now()));
        }

        DB::table('md_widyaiswara')->INSERT($data);

        return redirect('widyaiswara')->with(['msg' => 'Berhasil Menambahkan Data Widyaiswara', 'location' => 'widyaiswara']);
    }
    public function update_widyaiswara(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('up_nama') ,
            'POSISI' => $req->input('up_posisi') ,
            'TENTANG' => $req->input('up_tentang')
        ];
        
        if(!empty($req->file('up_image_profile'))) {   
            $data['IMAGE']  = FileUpload::S3($req->file('up_image_profile'), 'IMAGE_PROFILE', 'Image-profile-' . strtotime(now()));
        }
        DB::table('md_widyaiswara')->WHERE(['ID' => $req->input('up_id_widyaiswara')])->update($data);

        return redirect('widyaiswara')->with(['msg' => 'Berhasil Mengubah Data', 'location' => 'widyaiswara']);
    }
    public function delete_widyaiswara(Request $req)
    {
        DB::table('md_widyaiswara')->WHERE(['ID' => $req->input('del_id_widyaiswara')])->delete();

        return redirect('widyaiswara')->with(['msg' => 'Berhasil Menghapus Data', 'location' => 'widyaiswara']);
    }
}
