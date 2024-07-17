<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\FileUpload;

class EbookController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function index()
    {
        $data['title'] = "Ebook";

        $data['book'] = DB::select("
            SELECT
                e.*
            FROM
                ebook e
        ");

        return
            view('template.header', $data) .
            view('template_admin/ebook', $data) .
            view('template.footer', $data);
    }

    public function store(Request $req)
    {
        $data = [
            'ID_BUKU'       => $this->GenerateUniqID($req->input('judul')),
            'IMAGE_EBOOK'   => FileUpload::S3($req->file('image_ebook'), 'IMAGE_EBOOK', 'Image-Ebook-' . strtotime(now())),
            'JUDUL'         => $req->input('judul'),
            'GENRE'         => $req->input('genre'),
            'AUTHOR'        => $req->input('author'),
            'TAHUN'         => $req->input('tahun'),
            'PRICE'         => $req->input('harga'),
            'LINK_EBOOK'    => FileUpload::S3($req->file('ebook'), 'EBOOK', 'Ebook-' . strtotime(now())),
            'LOG_TIME'      => date('Y-m-d H:i:s'),
            'ID_USER'       => session('user')[0]['ID_USER']
        ];

        DB::table('ebook')->insert($data);

        return redirect('ebook')->with('succ_msg', 'Successfully Add New Ebook');
    }

    public function update(Request $req)
    {
        $data = [
            'JUDUL'         => $req->input('up_judul'),
            'GENRE'         => $req->input('up_genre'),
            'AUTHOR'        => $req->input('up_author'),
            'TAHUN'         => $req->input('up_tahun'),
            'PRICE'         => $req->input('up_harga'),
            'LOG_TIME'      => date('Y-m-d H:i:s')
        ];

        if (!empty($req->file('up_image_ebook'))) {
            $data['IMAGE_EBOOK']   = FileUpload::S3($req->file('up_image_ebook'), 'IMAGE_EBOOK', 'Image-Ebook-' . strtotime(now()));
        }

        if (!empty($req->file('frame_ebook'))) {
            $data['LINK_EBOOK']    = FileUpload::S3($req->file('frame_ebook'), 'EBOOK', 'Ebook-' . strtotime(now()));
        }

        DB::table('ebook')->where('ID_BUKU', '=', $req->input('up_id_buku'))->update($data);

        return redirect('ebook')->with('succ_msg', 'Successfully Update Ebook');
    }

    public function delete(Request $req)
    {
        DB::table('ebook')->where('ID_BUKU', '=', $req->input('del_id_ebook'))->delete();

        return redirect('ebook')->with('succ_msg', 'Successfully Delete Ebook');
    }

    public function GenerateUniqID($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap = str_replace($vocal, "", $string);
        $begin = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return "EBK_" . $uniqid . substr(md5(time()), 0, 3);
    }
}
