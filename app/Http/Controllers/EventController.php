<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\FileUpload;
use App\Models\Event;
use App\Models\Activity;

class EventController extends Controller
{
    public function index()
    {
        $data['title'] = "Webinar & Pelatihan";
        $role = session('user')[0]['ID_ROLE'];
        if ($role == 1 || $role == 4) {
            $data['event'] = DB::select("
            Select
                a.* ,
                e.CATEGORY_EVENT,
                e.LOCATION,
                e.ORGANIZER,
                e.CONTACT_CUSTOMER,
                e.LINK_ZOOM,
                e.KUOTA_PESERTA
            FROM
                activity a
            LEFT JOIN event e ON
                e.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                a.TYPE_ACTIVITY = 2
        ");

            $data['instruktur'] = DB::select("
            SELECT
                u.ID_USER ,
                u.NAME
            FROM
                user u
            LEFT JOIN instructor_req ir ON
                ir.ID_USER = u.ID_USER            
        ");
        } else {
            $data['event'] = DB::select("
                Select
                    a.* ,
                    e.CATEGORY_EVENT,
                    e.LOCATION,
                    e.ORGANIZER,
                    e.CONTACT_CUSTOMER,
                    e.LINK_ZOOM,
                    e.KUOTA_PESERTA
                FROM
                    activity a
                LEFT JOIN event e ON
                    e.ID_ACTIVITY = a.ID_ACTIVITY
                WHERE
                    a.TYPE_ACTIVITY = 2
                    AND a.ID_USER = '" . session('user')[0]['ID_USER'] . "'    
                ");
        }
        $data['admin'] = true;
        return
            view('template.header', $data) .
            view('template_admin/event', $data) .
            view('template.footer', $data);
    }

    public function index_lihat_peserta(Request $req) {
        $data['title'] = "Peserta Event";

        $data['list_peserta'] = DB::select("
            SELECT
                u.NAME ,
                u.EMAIL ,
                u.TELP,
                u.ALAMAT,
                tum.FILE
            FROM
                user u 
            LEFT JOIN `order` o ON   
                o.ID_USER = u.ID_USER
            LEFT JOIN tb_upload_materi tum ON
                tum.ID_USER = o.ID_USER
            WHERE 
                o.ID_PRODUCT = '" . $req->input('ID_ACTIVITY') . "'
        ");

        $data['event'] = DB::selectOne("
            SELECT
                a.* ,
                e.CATEGORY_EVENT,
                e.LOCATION,
                e.ORGANIZER,
                e.CONTACT_CUSTOMER,
                e.LINK_ZOOM,
                e.KUOTA_PESERTA
            FROM
                activity a
            LEFT JOIN event e ON
                e.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                a.TYPE_ACTIVITY = 2
            AND
                a.ID_ACTIVITY = '" . $req->input('ID_ACTIVITY') . "'
        ");

        return
            view('template.header', $data) .
            view('template_admin/lihat_peserta_event', $data) .
            view('template.footer', $data);
    }

    public function laporan_event(Request $req)
    {
        $event = DB::select("
            SELECT
                u.EMAIL,
                u.NAME,
                u.TELP,
                u.JK ,
                u.ALAMAT,
                o.LOG_TIME ,
                a.TITLE_ACTIVITY
            FROM
                user u
            LEFT JOIN user_data ud ON   
                ud.ID_USER = u.ID_USER
            LEFT JOIN `order` o ON
                o.ID_USER = u.ID_USER 
            LEFT JOIN activity a ON
                a.ID_ACTIVITY = o.ID_PRODUCT 
            WHERE
                o.ID_PRODUCT  = '" . $req->input('ID_ACTIVITY') . "'
        ");
        app(Laporan::class)->laporan_event($event);
    }

    public function store(Request $req)
    {
        $activity = [
            'ID_ACTIVITY' => $this->GenerateUniqID('ACT', $req->input('title_activity')),
            'TITLE_ACTIVITY' => $req->input('title_activity'),
            'ID_USER' => session('user')[0]['ID_USER'],
            'SERTIF_CODE' => !empty($req->input('sertif_code')) ? $req->input('sertif_code') : null,
            'TYPE_ACTIVITY' => 2,
            'STATUS' => $req->has('status') ? 1 : 0,
            'IMAGE_ACTIVITY' => FileUpload::S3($req->file('image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now())),
            'DATE_START' => $req->input('date_start'),
            'DATE_END' => $req->input('date_end'),
            'LOG_TIME' => date('Y-m-d H:i:s'),
            'IS_PUBLIC' => $req->input('status_public'),
            'SERTIF_IMAGE' => $req->hasFile('sertif_image') ? FileUpload::S3($req->file('sertif_image'), 'SERTIF_IMAGE', 'Template-Certifiace-' . strtotime(now())) : null
        ];

        $event = [
            'ID_ACTIVITY'       => $activity['ID_ACTIVITY'],
            'CATEGORY_EVENT'    => $req->input('category'),
            'LOCATION'          => $req->input('location'),
            'ORGANIZER'         => $req->input('penyelenggara'),
            'CONTACT_CUSTOMER'  => $req->input('contact'),
            'DESKRIPSI_EVENT'   => $req->input('desc_event')
        ];

        if (!empty($req->input('link_zoom'))) {
            $event['LINK_ZOOM'] = $req->input('link_zoom');
        }
        if (!empty($req->input('kuota_peserta'))) {
            $event['KUOTA_PESERTA'] = $req->input('kuota_peserta');
        }

        DB::table('activity')->insert($activity);
        DB::table('event')->insert($event);

        return redirect('events')->with(['succ_msg' => 'Berhasil Menambahkan Webinar/Pelatihan', 'location' => 'events']);
    }

    public function update(Request $req)
    {
        $activity = [
            'TITLE_ACTIVITY' => $req->input('up_title_activity'),
            'ID_USER' => session('user')[0]['ID_USER'],
            'SERTIF_CODE' => $req->input('up_sertif_code'),
            'DATE_START' => $req->input('up_date_start'),
            'DATE_END' => $req->input('up_date_end'),
            'IS_PUBLIC' => $req->input('up_status_public'),
            'STATUS' => $req->has('up_status') ? 1 : 0,
            'LOG_TIME' => date('Y-m-d H:i:s')
        ];

        if (!empty($req->file('up_image_activity'))) {
            $activity['IMAGE_ACTIVITY'] = FileUpload::S3($req->file('up_image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now()));
        }

        if ($req->hasFile('up_sertif_image')) {
            $activity['SERTIF_IMAGE'] = FileUpload::S3($req->file('up_sertif_image'), 'SERTIF_IMAGE', 'Template-Certifiace-' . strtotime(now()));
        }

        $event = [
            'CATEGORY_EVENT'    => $req->input('up_category'),
            'LOCATION'          => $req->input('up_location'),
            'ORGANIZER'         => $req->input('up_penyelenggara'),
            'CONTACT_CUSTOMER'  => $req->input('up_contact'),
            'DESKRIPSI_EVENT'   => $req->input('up_desc_event')
        ];

        if (!empty($req->input('up_link_zoom'))) {
            $event['LINK_ZOOM'] = $req->input('up_link_zoom');
        }
        if (!empty($req->input('up_kuota_peserta'))) {
            $event['KUOTA_PESERTA'] = $req->input('up_kuota_peserta');
        }

        DB::table('activity')->WHERE(['ID_ACTIVITY' => $req->input('up_id_activity')])->update($activity);
        DB::table('event')->WHERE(['ID_ACTIVITY' => $req->input('up_id_activity')])->update($event);

        return redirect('events')->with(['succ_msg' => 'Berhasil Memperbarui Webinar/Pelatihan', 'location' => 'events']);
    }

    public function delete(Request $req)
    {
        DB::table('event')->WHERE(['ID_ACTIVITY' => $req->input('id_activity')])->delete();
        DB::table('activity')->WHERE(['ID_ACTIVITY' => $req->input('id_activity')])->delete();

        return redirect('events')->with('succ_msg', 'Webinar/Pelatihan Berhasil Dihapus');
    }

    public function deskripsi_get($id)
    {
        $data['event'] = DB::selectOne("
            SELECT
                *
            FROM
                event
            WHERE
                ID_ACTIVITY = '$id'
        ");

        return response([
            'status_code'       => 200,
            'status_message'    => 'Data diterima',
            $data
        ], 200);
    }

    public function GenerateUniqID($first, $var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return "ACT_" . $uniqid . substr(md5(time()), 0, 3);
    }
}
