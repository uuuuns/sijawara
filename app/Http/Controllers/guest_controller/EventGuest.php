<?php

namespace App\Http\Controllers\guest_controller;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Checkout;
use App\Models\Event;
use App\Models\Certificate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class EventGuest extends Controller
{
	public $session_data;
	protected $eventModel;
    protected $courseModel;
    protected $checkoutModel;
    protected $categoryModel;
    protected $certificateModel;
	public function __construct()
    {
        $this->eventModel = new Event();
        $this->courseModel = new Course();
        $this->checkoutModel = new Checkout();
        $this->certificateModel = new Certificate();
    }

	// EVENT CONTROLLER
	public function index()
	{

		$data['title'] = 'Event';
		$data_user =  (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');
		$data['checkout'] = $this->checkoutModel->get_all_order($data_user);
		
		// Pagination settings
		$perPage = 9; // Jumlah item per halaman
		$currentPage = request()->query('page', 1);
		// Query untuk menghitung total baris
		$totalRows = DB::table('activity')->where('TYPE_ACTIVITY', 2)->count();

		// Data event untuk halaman saat ini
		if (empty(session('user'))) {
			$events = DB::table('activity')
					->selectRaw('activity.*, 
								event.KUOTA_PESERTA,
								(
									SELECT 
										COUNT(*) 
									FROM 
										`order` o
									WHERE 
										o.ID_PRODUCT = activity.ID_ACTIVITY 
								) as participant, 
								(DATEDIFF(CURDATE(), activity.DATE_START) >= 1) as EXPIRED')
					->leftJoin('event', 'event.ID_ACTIVITY', '=', 'activity.ID_ACTIVITY')
					->where('TYPE_ACTIVITY', 2)
					->Paginate($perPage, ['*'], 'page', $currentPage);
			}else {
				$events = DB::table('activity')
					->selectRaw('activity.*, 
								event.ID_EVENT, 
								event.CATEGORY_EVENT, 
								event.LOCATION, 
								event.ORGANIZER, 
								event.CONTACT_CUSTOMER, 
								event.DESKRIPSI_EVENT, 
								event.LINK_ZOOM, 
								event.KUOTA_PESERTA, 
								(
									SELECT 
										COUNT(*) 
									FROM 
										`order` o
									WHERE 
										o.ID_USER = ? 
										AND o.ID_PRODUCT = activity.ID_ACTIVITY 
								) as DATA_CHECKING, 
								(
									SELECT 
										COUNT(*) 
									FROM 
										`order` o
									WHERE 
										o.ID_PRODUCT = activity.ID_ACTIVITY 
								) as participant, 
								(DATEDIFF(CURDATE(), activity.DATE_START) >= 1) as EXPIRED', [session('user')[0]->get('ID_USER')])
					->leftJoin('event', 'event.ID_ACTIVITY', '=', 'activity.ID_ACTIVITY')
					->where('activity.TYPE_ACTIVITY', 2)
					->paginate($perPage, ['*'], 'page', $currentPage);
			}

		// Load views
		return 
			view('template.header', $data) .
			view('template_guest.event.event', compact('events', 'totalRows')) .
			view('template.footer', $data);
	}

	public function add_event(Request $req)
	{
		$check_data = DB::select("
			SELECT
				*
			FROM
				`order`
			WHERE
				ID_USER = '". session('user')[0]->get('ID_USER') ."'
			AND
				ID_PRODUCT = '". $req->input('id_event;]') ."'
		");

		if (empty($check_data)) {
			$order = [
				'ID_ORDER'             	=> $this->GenerateUniqID_Order(time()),
				'ID_PRODUCT'           	=> $req->input('id_event'),
				'ID_USER'		     	=> session('user')[0]->get('ID_USER'),
				'LOG_TIME'				=> date('Y-m-d H:i:s')
			];
	
			DB::table('order')->insert($order);
			return redirect('event')->with(['succ_msg' => 'Berhasil join webinar', 'location' => 'event']);
		} else {
			return redirect('event')->with(['err_msg' => 'Sudah mengambil join webinar ini', 'location' => 'event']);
		}
	}
	public function detailEvent()
	{
		$data['title'] = 'Event';
		$data_user =  (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');
		$id_activity = $_GET['id_activity'];
		$data['event'] = $this->eventModel->get_event($id_activity);
		$data['other_event'] = $this->eventModel->get_other_event($id_activity);
		if (empty($data['event']->DATA_CHECKING)){
			$data['event']->DATA_CHECKING = null;
		}
		$con = ['ID_ACTIVITY = "'.$id_activity.'"'];
        // $sertifCheck = $this->certificateModel->getCertificate($con);
		$sertifCheck = DB::selectOne("
			SELECT
				ID_SERTIFIKAT,
				FILE_SERTIFIKAT
			FROM
				sertifikat_activity
			WHERE
				ID_USER = '$data_user'
				AND
				".implode('AND', $con)."
		");
		if (!empty($data['event']->DATA_CHECKING) && empty($sertifCheck)) {
			$bln = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
			$sertif_number = $data['event']->ID_EVENT . '/' . (($data['event']->TYPE_ACTIVITY == 1) ? 'CRS' : 'EVT') . '/TBH/' . $bln[(date('m', strtotime($data['event']->DATE_START)) - 1)] . '/' . date('Y');
			$sertif_path = $this->certificateModel->generate(session('user')[0]->get('NAME'), $data['event']->TITLE_ACTIVITY, $sertif_number);
			$data_sertif = array(
				"ID_USER" => session('user')[0]->get('ID_USER'),
				"ID_ACTIVITY" => $id_activity,
				"NO_SERTIFIKAT" => $sertif_number,
				"JENIS_SERTIFIKAT" => $data['event']->TYPE_ACTIVITY,
				"FILE_SERTIFIKAT" => $sertif_path,
				"LOG_TIME" => date('Y-m-d H:i:s')
			);
			// $this->certificateModel->createCertificate($data_sertif);
			DB::table('sertifikat_activity')->insert($data_sertif);

			$data['sertif'] = $this->certificateModel->getCertificate($data_sertif);
		}else{
			$data['sertif'] = $sertifCheck;
		}
		$data['checkout'] = $this->checkoutModel->get_all_order($data_user);

		return
		 view('template.header', $data) .
		 view('template_guest.event.event_detail', $data) .
		 view('template.footer', $data);
	}
	public function searchEvent()
	{
		$keyword = $_GET['keyword'];
		$data['data_search'] = $this->eventModel->get_event_by_id($keyword, 2);

		return
			view('template_guest.event.ajax.item_search', $data);
	}

	public function GenerateUniqID_Order($var)
	{
		$string = preg_replace('/[^a-z]/i', '', $var);
		$vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
		$scrap  = str_replace($vocal, "", $string);
		$begin  = substr($scrap, 0, 6);
		$uniqid = strtoupper($begin);
		return "ORD_" . $uniqid . substr(md5(time()), 0, 6);
	}
	// END EVENT CONTROLLER
}
