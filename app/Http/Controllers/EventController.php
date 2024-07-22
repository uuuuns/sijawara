<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\FileUpload;
use App\Models\Event;
use App\Models\Activity;

class EventController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function index()
    {
        $data['title'] = "Webinar";
        $role = session('user')[0]['ID_ROLE'];
        if ($role == 1) {
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

        return
            view('template.header', $data) .
            view('template_admin/event', $data) .
            view('template.footer', $data);
    }

    public function store(Request $req)
    {
        $activity = [
            'ID_ACTIVITY' => $this->GenerateUniqID('ACT', $req->input('title_activity')),
            'TITLE_ACTIVITY' => $req->input('title_activity'),
            'ID_USER' => session('user')[0]['ID_USER'],
            'SERTIF_CODE' => $req->input('sertif_code'),
            'TYPE_ACTIVITY' => 2,
            'STATUS' => $req->has('status') ? 1 : 0,
            'IMAGE_ACTIVITY' => FileUpload::S3($req->file('image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now())),
            'DATE_START' => $req->input('date_start'),
            'DATE_END' => $req->input('date_end'),
            'LOG_TIME' => date('Y-m-d H:i:s')
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

        return redirect('events')->with(['succ_msg' => 'Successfully Add Events', 'location' => 'events']);
    }

    public function update(Request $req)
    {
        $activity = [
            'TITLE_ACTIVITY' => $req->input('up_title_activity'),
            'ID_USER' => session('user')[0]['ID_USER'],
            'SERTIF_CODE' => $req->input('up_sertif_code'),
            'DATE_START' => $req->input('up_date_start'),
            'DATE_END' => $req->input('up_date_end'),
            'STATUS' => $req->has('up_status') ? 1 : 0,
            'LOG_TIME' => date('Y-m-d H:i:s')
        ];

        if (!empty($req->file('up_image_activity'))) {
            $activity['IMAGE_ACTIVITY'] = FileUpload::S3($req->file('up_image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now()));
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

        return redirect('events')->with(['succ_msg' => 'Successfully Update Events', 'location' => 'events']);
    }

    public function delete(Request $req)
    {
        DB::table('event')->WHERE(['ID_ACTIVITY' => $req->input('id_activity')])->delete();
        DB::table('activity')->WHERE(['ID_ACTIVITY' => $req->input('id_activity')])->delete();

        return redirect('events')->with('succ_msg', 'Data Deleted successfully');
    }

    public function deskripsi_get($id)
    {
        // $data['title'] = "Deskripsi Setting";

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
