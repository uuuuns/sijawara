<?php

namespace App\Http\Controllers\guest_controller;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Checkout;
use App\Models\Event;
use App\Models\Certificate;
use App\Models\FileUpload;
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

	public function index()
	{
		$data['title'] = 'Event - SIJAWARA+';
		$data_user =  (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');
		$data['checkout'] = $this->checkoutModel->get_all_order($data_user);
		
		$perPage = 9; // Jumlah item per halaman
		$currentPage = request()->query('page', 1);
		$totalRows = DB::table('activity')->where('TYPE_ACTIVITY', 2)->count();

		if (empty(session('user'))) {
			$events = DB::table('activity')
				->selectRaw('
					activity.*, 
					event.KUOTA_PESERTA,
					(
						SELECT 
							COUNT(*) 
						FROM 
							`order` o
						WHERE 
							o.ID_PRODUCT = activity.ID_ACTIVITY 
					) as participant, 
					(
						SELECT
							COUNT(ti.ID_INVITED)
						FROM
							tb_invited ti 
						WHERE
							ti.ID_USER = "'.$data_user.'"
							AND ti.ID_ACTIVITY = activity.ID_ACTIVITY
					) AS is_invited,
					(DATEDIFF(CURDATE(), activity.DATE_END) >= 1) as EXPIRED')
				->leftJoin('event', 'event.ID_ACTIVITY', '=', 'activity.ID_ACTIVITY')
				->where('TYPE_ACTIVITY', 2)
				->orderBy('activity.DATE_START', 'DESC')
				->Paginate($perPage, ['*'], 'page', $currentPage);
		}else {
			$events = DB::table('activity')
				->selectRaw('
					activity.*, 
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
					(
						SELECT
							COUNT(ti.ID_INVITED)
						FROM
							tb_invited ti 
						WHERE
							ti.ID_USER = "'.$data_user.'"
							AND ti.ID_ACTIVITY = activity.ID_ACTIVITY
					) AS is_invited,
					(DATEDIFF(CURDATE(), activity.DATE_END) >= 1) as EXPIRED', [session('user')[0]->get('ID_USER')])
				->leftJoin('event', 'event.ID_ACTIVITY', '=', 'activity.ID_ACTIVITY')
				->where('activity.TYPE_ACTIVITY', 2)
				->orderBy('activity.LOG_TIME', 'DESC')
				->paginate($perPage, ['*'], 'page', $currentPage);
			}

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
			return redirect()->back()->with(['succ_msg' => 'Berhasil join', 'location' => 'event']);
		} else {
			return redirect()->back()->with(['err_msg' => 'Anda Sudah mengambil join', 'location' => 'event']);
		}
	}
	public function detailEvent()
	{
		$data['title'] = 'Event';
		$data_user =  (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');

		if(empty($_GET['id_activity'])) {
			return redirect('404');
		}

		$id_activity = $_GET['id_activity'];
		$data['event'] = $this->eventModel->get_event($id_activity);
		$data['other_event'] = $this->eventModel->get_other_event($id_activity);
		$HAL_2_SERTIF = $data['event']->SERTIF_IMAGE_BELAKANG;
		
		if($data['event'] == NULL ) {
			return redirect('404');
		}

		if (!empty($data['event']->TEMA)) {
			$tema = explode(';', $data['event']->TEMA);
			$jp = explode(';', $data['event']->JAM_PELATIHAN);
			$LIST_TEMA = [];
			foreach ($tema as $key => $value) {
				$LIST_TEMA[] = [
					'TEMA' => $value,
					'JP' => $jp[$key]
				];
			}
		}else {
			$LIST_TEMA = [];
		}

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
			$sertif_number = $data['event']->ID_EVENT . '/' . (($data['event']->TYPE_ACTIVITY == 1) ? 'CRS' : 'EVT') . '/SIJAWARA/' . $bln[(date('m', strtotime($data['event']->DATE_START)) - 1)] . '/' . date('Y');
			
			$data_sertif = array(
				"ID_USER" => session('user')[0]->get('ID_USER'),
				"ID_ACTIVITY" => $id_activity,
				"NO_SERTIFIKAT" => $sertif_number,
				"FILE_SERTIFIKAT" => null,
				"JENIS_SERTIFIKAT" => $data['event']->TYPE_ACTIVITY,
				"LOG_TIME" => date('Y-m-d H:i:s')
			);
			$id_sertif = DB::table('sertifikat_activity')->insertGetId($data_sertif);

			$sertif_path = $this->certificateModel->generate(session('user')[0]->get('NAME'), $data['event']->TITLE_ACTIVITY, $sertif_number, $data['event']->SERTIF_IMAGE, "PESERTA", date('d F Y', strtotime($data['event']->DATE_START)), $id_sertif, 2, $LIST_TEMA, $HAL_2_SERTIF);
			$data_sertif = array(
				"ID_USER" => session('user')[0]->get('ID_USER'),
				"ID_ACTIVITY" => $id_activity,
				"NO_SERTIFIKAT" => $sertif_number,
				"JENIS_SERTIFIKAT" => $data['event']->TYPE_ACTIVITY,
				"FILE_SERTIFIKAT" => $sertif_path,
				"LOG_TIME" => date('Y-m-d H:i:s')
			);
			DB::table('sertifikat_activity')->where('ID_SERTIFIKAT', $id_sertif)->update($data_sertif);

			$data['sertif'] = (object) $data_sertif;
		}else{
			$data['sertif'] = $sertifCheck;
		}
		$data['checkout'] = $this->checkoutModel->get_all_order($data_user);
		
		if (is_null($data['event']->KUOTA_PESERTA)) {
			$data['is_full'] = false;
		} else if ($data['event']->KUOTA >= $data['event']->KUOTA_PESERTA) {
			$data['is_full'] = true;
		} else {
			$data['is_full'] = false;
		}

		$data['materi_file'] = DB::table('tb_upload_materi')
			->where('ID_USER', $data_user)
			->where('ID_EVENT', $data['event']->ID_ACTIVITY)
			->first();

		return
		 view('template.header', $data) .
		 view('template_guest.event.event_detail', $data) .
		 view('template.footer', $data);
	}
	public function upload_file(Request $req)
	{
		$file = [];

		foreach ($req->file('file_materi') as $item) {
			$file[] = FileUpload::S3($item, 'UPLOAD_MATERI', 'Upload-Materi-' . strtotime(now()));
		}

		$file = [
			'ID_USER'		=> $req->input('id_user'),
			'ID_EVENT'		=> $req->input('id_activity'),
			'FILE'			=> implode(';', $file),
			'LOG_TIME'		=> date('Y-m-d H:i:s')
		];

		DB::table('tb_upload_materi')->insert($file);

		return redirect()->back()->with('succ_msg', 'Berhasil mengupload');
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
