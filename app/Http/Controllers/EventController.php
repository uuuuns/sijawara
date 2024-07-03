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

        $data['event'] = DB::select("
            Select
                a.* ,
                e.*
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

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.event', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function store(Request $req)
    {
        $activity = [
            'ID_ACTIVITY' => $this->GenerateUniqID('ACT', $req->input('title_activity')),
            'TITLE_ACTIVITY' => $req->input('title_activity'),
            'ID_USER' => session('user')[0]['ID_USER'],
            'PRICE_ACTIVITY' => (int)str_replace(".", "", $req->input('price_activity')),
            'SERTIF_CODE' => $req->input('sertif_code'),
            'TYPE_ACTIVITY' => 2,
            'IMAGE_ACTIVITY' => FileUpload::S3($req->file('image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now())),
            'DATE_START' => $req->input('date_start'),
            'LOG_TIME' => date('Y-m-d H:i:s')
        ];

        if ($req->input('status') == "on") {
            $activity['status'] = 0;
        } else {
            $activity['status'] = 1;
        }

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

        DB::table('activity')->insert($activity);
        DB::table('event')->insert($event);

        return redirect('events')->with(['succ_msg' => 'Successfully Add Events', 'location' => 'events']);
    }

    public function update(Request $req)
    {
        $activity = [
            'TITLE_ACTIVITY' => $req->input('title_activity'),
            'ID_USER' => session('user')[0]['ID_USER'],
            'PRICE_ACTIVITY' => (int)str_replace(".", "", $req->input('price_activity')),
            'SERTIF_CODE' => $req->input('sertif_code'),
            'IMAGE_ACTIVITY' => FileUpload::S3($req->file('image_activity'),'IMAGE_ACTIVITY','Image-Activity-' . strtotime(now())),
            'TYPE_ACTIVITY' => 2,
            'DATE_START' => $req->input('date_start'),
            'LOG_TIME' => date('Y-m-d H:i:s')
        ];

        $event = [
            'CATEGORY_EVENT'    => $req->input('category'),
            'LOCATION'          => $req->input('location'),
            'ORGANIZER'         => $req->input('penyelenggara'),
            'CONTACT_CUSTOMER'  => $req->input('contact'),
            'DESKRIPSI_EVENT'   => $req->input('up_desc_event')
        ];

        if (!empty($req->input('link_zoom'))) {
            $event['LINK_ZOOM'] = $req->input('link_zoom');
        }

        DB::table('activity')->WHERE(['ID_ACTIVITY' => $req->input('id_activity')])->update($activity);
        DB::table('event')->WHERE(['ID_ACTIVITY' => $req->input('id_activity')])->update($event);

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