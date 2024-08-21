<?php

namespace App\Http\Controllers\guest_controller;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Checkout;
use App\Models\Event;
use App\Models\Category;
use App\Models\Certificate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class CourseGuest extends Controller
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
		$this->categoryModel = new Category();
		$this->certificateModel = new Certificate();
	}

	public function index()
	{
		$data['title'] = 'Course';
		$data['kategori'] = $this->categoryModel->get_all_category();
		$data_user = (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');
		$data['checkout'] = $this->checkoutModel->get_all_order($data_user);
		$data['is_invited'] = DB::select("
			SELECT
				id_invited	
			FROM
				tb_invited
			WHERE
				ID_USER = '" . $data_user . "'
		");

		return
			view('template.header', $data) .
			view('template_guest.course.course', $data) .
			view('template.footer', $data);
	}
	public function detailCourse()
	{
		if (session('user') == null) {
			return redirect('login');
		}
		$data['title'] = 'Course';

		$data['id_activity'] = $_GET['id_activity'];
		$data['course'] = $this->courseModel->get_course($data['id_activity']);
		$condition = "item_course.ID_COURSE = '" . $data['course']->ID_COURSE . "'" .
			" AND mapping_course.ID_USER = '" . session('user')[0]->get('ID_USER') . "'";
		" AND mapping_course.ID_USER = '" . session('user')[0]->get('ID_USER') . "'";
		$this->courseModel->updateMappingIndex($data['course']->ID_COURSE, $data['id_activity']);
		" AND mapping_course.ID_USER = '" . session('user')[0]->get('ID_USER') . "'";
		$this->courseModel->updateMappingIndex($data['course']->ID_COURSE, $data['id_activity']);
		$data['item_course'] = $this->courseModel->get_item_course($condition);
		$data['last_item'] = DB::select('
			SELECT
				*
			FROM
				mapping_course
			WHERE
				ID_USER = "' . session('user')[0]->get('ID_USER') . '"
				AND ID_ACTIVITY = "' . $data['id_activity'] . '"
				AND STATUS = 1
			ORDER BY ID_ITEM DESC
		');

		$condition_all_mapping =
			"ID_USER = '" . session('user')[0]->get('ID_USER') .
			"'AND ID_ACTIVITY = '" . $data['id_activity'] . "'";

		$data['data_all_mapping'] = DB::select("
			SELECT
				*
			FROM
				mapping_course
			WHERE
				$condition_all_mapping
		");
		$data_all_mapping = $this->courseModel->get_counttask($data['id_activity']);

		$data['tot_proggress'] = (!empty($data['last_item'])) ? (((int) $data_all_mapping[0]->MAPPING_COUNT) / count($data['data_all_mapping'])) * 100 : 0;

		$cek_nilai = DB::selectOne("
			SELECT 
				* 
			FROM 
				nilai_quiz 
			WHERE 
				ID_USER = '" . session('user')[0]->get('ID_USER') . "'
				AND ID_QUIZ = " . $data['last_item'][0]->ID_ITEM . "
			");

		$cek_item_course = DB::selectOne("
			SELECT 
				* 
			FROM 
				item_course 
			WHERE 
				ID_ITEM = " . $data['last_item'][0]->ID_ITEM . "
			");

		if (count($data['last_item']) == count($data['data_all_mapping']) && (!empty($cek_nilai->NILAI) ? $cek_nilai->NILAI >= 75 : false)) {
			$data['tot_proggress'] = 100;
			DB::table('order')
				->where('ID_USER', session('user')[0]->get('ID_USER'))
				->where('ID_PRODUCT', $data['id_activity'])
				->update(['COURSE_COMPLETED' => 1, 'MAPPING_COUNT' => count($data['data_all_mapping'])]);
		}
		if (count($data['last_item']) == count($data['data_all_mapping']) && ($cek_item_course->TYPE == 1)) {
			$data['tot_proggress'] = 100;
			DB::table('order')
				->where('ID_USER', session('user')[0]->get('ID_USER'))
				->where('ID_PRODUCT', $data['id_activity'])
				->update(['COURSE_COMPLETED' => 1, 'MAPPING_COUNT' => count($data['data_all_mapping'])]);
		}
		$sertifCheck = DB::selectOne("
			SELECT
				ID_SERTIFIKAT,
				FILE_SERTIFIKAT
			FROM
				sertifikat_activity
			WHERE
				$condition_all_mapping
		");
		if ($data['tot_proggress'] == 100 && empty($sertifCheck)) {
			$bln = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
			$sertif_number = $data['course']->ID_COURSE . '/' . (($data['course']->TYPE_ACTIVITY == 1) ? 'CRS' : 'EVT') . '/TBH/' . $bln[(date('m', strtotime($data['course']->DATE_START)) - 1)] . '/' . date('Y');
			$sertif_path = $this->certificateModel->generate(session('user')[0]->get('NAME'), $data['course']->TITLE_ACTIVITY, $sertif_number);
			$data_sertif = array(
				"ID_USER" => session('user')[0]->get('ID_USER'),
				"ID_ACTIVITY" => $data['id_activity'],
				"NO_SERTIFIKAT" => $sertif_number,
				"JENIS_SERTIFIKAT" => $data['course']->TYPE_ACTIVITY,
				"FILE_SERTIFIKAT" => $sertif_path,
				"LOG_TIME" => date('Y-m-d H:i:s')
			);

			DB::table('sertifikat_activity')->insert($data_sertif);
			$data['sertif'] = DB::selectOne("
				SELECT
					FILE_SERTIFIKAT
				FROM
					sertifikat_activity
				WHERE
					ID_USER = '" . session('user')[0]->get('ID_USER') . "'
					AND ID_ACTIVITY = '" . $data['id_activity'] . "'
			");
		} else {
			$data['sertif'] = $sertifCheck;
		}
		//get nilai
		$data['nilai'] = DB::selectOne("
			SELECT
				NILAI
			FROM
				nilai_quiz
			WHERE
				ID_USER = '" . session('user')[0]->get('ID_USER') . "'
		");
		$data['checkout'] = $this->checkoutModel->get_all_order(session('user')[0]->get('ID_USER'));

		// KOMENTAR
		$data['komentar'] = DB::select("
			SELECT
				tk.komentar,
				u.NAME,
				u.FOTO_PROFILE,
				tk.LOG_TIME
			FROM
				tb_komentar tk
			LEFT JOIN user u ON
				u.ID_USER = tk.ID_USER
			WHERE
				tk.ID_ACTIVITY = '" . $data['id_activity'] . "'
		");
		return view('template.header', $data) .
			view('template_guest.course.course_detail', $data) .
			view('template.footer', $data);
	}
	public function getDetailItemCourse()
	{
		$data['id_item'] = $_POST['id_item'];
		$data['type'] = $_POST['type'];
		$data['status'] = $_POST['status'];
		$data['id_activity'] = $_POST['type'] . '/' . $_POST['id_activity'];
		if ($data['type'] == 3) {
			$data['type'] = 2;
			//DELETE NILAI YANG ADA
			DB::table('nilai_quiz')->where('ID_QUIZ', $data['id_item'])->where('ID_USER', session('user')[0]->get('ID_USER'))->delete();
		} else {
			$data['type'] = $_POST['type'];
		}

		$condition_all_mapping = array(
			"ID_USER = '" . session('user')[0]->get('ID_USER') . "'",
			"ID_ACTIVITY = '" . $_POST['id_activity'] . "'",
			"STATUS <> 1"
		);
		$data['data_all_mapping'] = DB::select("
			SELECT
				*
			FROM
				mapping_course
			WHERE
				" . implode('AND ', $condition_all_mapping) . "
		");

		// GET NILAI QUIZ
		$data['quiz_grade'] = DB::selectOne('
			SELECT
				NILAI
			FROM
				nilai_quiz
			WHERE
				ID_USER = "' . session('user')[0]->get('ID_USER') . '"
				AND 
				ID_QUIZ = ' . $data['id_item'] . '
		');

		$max_id_item = DB::selectOne("
			SELECT
				MAX(ID_ITEM) AS MAX_ID
			FROM
				mapping_course
			WHERE
				ID_USER = '" . session('user')[0]->get('ID_USER') . "'
				AND ID_ACTIVITY = '" . $_POST['id_activity'] . "'"
		);

		$data_all_mapping = $this->courseModel->get_counttask($_POST['id_activity']);
		$count = ['MAPPING_COUNT' => ((int) $data_all_mapping[0]->MAPPING_COUNT) + 1];
		if ($data['status'] == 2) {
			DB::table("mapping_course")
				->where('ID_USER', session('user')[0]->get('ID_USER'))
				->where('ID_ACTIVITY', $_POST['id_activity'])
				->where('ID_ITEM', $data['data_all_mapping'][0]->ID_ITEM)
				->update(['STATUS' => 1]);

			if ($max_id_item->MAX_ID != $data['data_all_mapping'][0]->ID_ITEM) {
				DB::table("order")
					->where('ID_USER', session('user')[0]->get('ID_USER'))
					->where('ID_PRODUCT', $_POST['id_activity'])
					->update($count);
			}

			if ($data['type'] == 2) {
				$data['next_quiz_grade'] = DB::selectOne('
					SELECT
						NILAI
					FROM
						nilai_quiz
					WHERE
						ID_USER = "' . session('user')[0]->get('ID_USER') . '"
						AND 
						ID_QUIZ = ' . $data['data_all_mapping'][0]->ID_ITEM . '
				');
			}
		}

		// GET ID_ITEM DARI LAST ITEM YANG DI TELAH DIBUKA
		$data['last_item'] = DB::select('
			SELECT
				*
			FROM
				mapping_course
			WHERE
				ID_USER = "' . session('user')[0]->get('ID_USER') . '"
				AND ID_ACTIVITY = "' . $_POST['id_activity'] . '"
				AND STATUS = 1
			ORDER BY ID_ITEM DESC
		');

		$condition = ['tc.ID_ITEM = ' . $data['id_item']];
		// GET DATA UNTUK MATERI, ELSE QUIZ
		$sql = "
			SELECT
				*
			FROM
				item_course tc
			WHERE
				" . implode('AND ', $condition) . "
			";
		$data['detail_item_course'] = DB::select($sql)[0];

		if ($data['type'] != 1) {
			$sql = "
			SELECT
				tc.ID_ITEM,
				tc.TITLE ,
				tc.FILE ,
				tc.LINK_YT ,
				tc.DESKRIPSI ,
				tc.`TYPE` ,
				dq.ID_DETAIL,
				dq.ID_QUIZ ,
				dq.SOAL ,
				dq.PIL_JWB ,
				dq.ORDER_LIST ,
				dq.KUNCI 
			FROM
				item_course tc
			LEFT JOIN detail_quiz dq ON
				dq.ID_QUIZ = tc.ID_ITEM
			WHERE
				" . implode('AND ', $condition) . "
			ORDER BY RAND()
			";
			$data['detail_item_course'] = DB::select($sql);
		}

		return view('template_guest.course.ajax.detail_item', $data);
	}
	public function getMappingCourse()
	{
		// $data_all_mapping = $this->courseModel->get_all_mapping($condition_all_mapping);
		
		$newDataItem = DB::select("
			SELECT
				*
			FROM
				mapping_course
			WHERE
				ID_USER = '" . session('user')[0]->get('ID_USER') . "' 
				AND 
				ID_ACTIVITY = '" . $_POST['id_activity'] . "'
		");
		echo json_encode($newDataItem);
	}
	public function infoCourse()
	{
		$data['title'] = 'Course';
		$data_user = (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');

		DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
		$id_activity = $_GET['id_activity'];
		$data['checking_trans'] = $this->checkoutModel->get_trans($data_user);
		$data['course'] = $this->courseModel->get_course($id_activity);
		$condition = "item_course.ID_COURSE = '" . $data['course']->ID_COURSE . "'";
		$data_itemCourse = $this->courseModel->get_item_course($condition);
		$data['item_course'] = array();
		$data['total_item'] = array(
			'materi' => 0,
			'quiz' => 0
		);
		if ($data['course']->IS_PUBLIC === 0){
			$CHECKING_USER = DB::SelectOne("
				SELECT
					ti.*
				FROM
					tb_invited ti
				LEFT JOIN activity a ON
					ti.ID_ACTIVITY = a.ID_ACTIVITY
				WHERE
					ti.ID_ACTIVITY = '" . $data['course']->ID_ACTIVITY . "'
				AND
					ti.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
			");
			
			if (empty($CHECKING_USER)) {
				return redirect()->back()->with(['err_msg' => 'Metode ini tidak diperbolehkan']);;
			}
		}

		foreach ($data_itemCourse as $item) {
			if ($item->TYPE == 1) {
				array_push(
					$data['item_course'],
					$item
				);
				$data['total_item']['materi']++;
			} else {
				$data['total_item']['quiz']++;
			}
		}

		$data['komentar'] = DB::select("
			SELECT
				tk.komentar,
				u.NAME,
				u.FOTO_PROFILE,
				tk.LOG_TIME
			FROM
				tb_komentar tk
			LEFT JOIN user u ON
				u.ID_USER = tk.ID_USER
			WHERE
				tk.ID_ACTIVITY = '" . $id_activity . "'
		");

		$data['checkout'] = $this->checkoutModel->get_all_order($data_user);
		return
			view('template.header', $data) .
			view('template_guest.course.course_info', $data) .
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
				ID_USER = '" . session('user')[0]->get('ID_USER') . "'
			AND
				ID_PRODUCT = '" . $req->input('id_activity') . "'
		");

		$activity = DB::selectone("
			SELECT
				TYPE_ACTIVITY
			FROM
				activity
			WHERE
				ID_ACTIVITY = '" . $req->input('id_activity') . "'
		");

		if (empty($check_data)) {
			$order = [
				'ID_ORDER' => $this->GenerateUniqID_Order(time()),
				'ID_PRODUCT' => $req->input('id_activity'),
				'ID_USER' => session('user')[0]->get('ID_USER'),
				'LOG_TIME' => date('Y-m-d H:i:s')
			];

			if ($activity->TYPE_ACTIVITY == 1) {
				$this->InsertDataMapping($req->input('id_activity'));
			}

			DB::table('order')->insert($order);
			return redirect('profile/mycourses')->with(['succ_msg' => 'Berhasil join kursus', 'location' => 'profile/mycourses']);
		} else {
			return redirect('profile/mycourses')->with(['err_msg' => 'Sudah mengambil join Kursus ini', 'location' => 'profile/mycourses']);
		}
	}
	public function InsertDataMapping($item)
	{
		$data_course = $this->courseModel->get_course($item);
		$condition = "item_course.ID_COURSE = '" . $data_course->ID_COURSE . "'";
		$data_itemCourse = $this->courseModel->get_item_course($condition);
		for ($i = 0; $i < count($data_itemCourse); $i++) {
			if ($i == 0) {
				$data_mapping = array(
					"ID_USER" => session('user')[0]->get('ID_USER'),
					"ID_ACTIVITY" => $item,
					"ID_ITEM" => $data_itemCourse[$i]->ID_ITEM,
					"STATUS" => 1
				);
			} else {
				$data_mapping = array(
					"ID_USER" => session('user')[0]->get('ID_USER'),
					"ID_ACTIVITY" => $item,
					"ID_ITEM" => $data_itemCourse[$i]->ID_ITEM,
					"STATUS" => 0
				);
			}
			DB::table('mapping_course')->insert($data_mapping);
		}
	}
	public function QuizEvaluation()
	{
		$id_quiz = $_POST['id_quiz'];
		$id_detail = $_POST['id_detail'];
		$pilih_jwbn = $_POST['pilih_jwbn'];
		$id_user = session('user')[0]->get('ID_USER');
		$jml_jwbn_benar = 0;
		for ($i = 0; $i < count($id_detail); $i++) {
			$data_sum = DB::selectOne("
			SELECT
				COUNT(ID_DETAIL) AS TOT
			FROM
				detail_quiz
			WHERE
				ID_DETAIL = " . $id_detail[$i] . "
				AND KUNCI = '" . $pilih_jwbn[$i] . "'
			");
			$jml_jwbn_benar += $data_sum->TOT;
		}
		$nilai = ($jml_jwbn_benar / count($id_detail)) * 100;
		$data['total_data'] = DB::select("
			SELECT
				ID_QUIZ
			FROM
				nilai_quiz
			WHERE
				ID_QUIZ = " . $id_quiz . "
				AND 
				ID_USER = '" . $id_user . "'
		");

		$data_quiz = [
			"ID_QUIZ" => $id_quiz,
			"ID_USER" => $id_user,
			"NILAI" => $nilai
		];
		if (!empty($data['total_data'])) {
			DB::table('nilai_quiz')
				->where('ID_QUIZ', $id_quiz)
				->where('ID_USER', "'" . $id_user . "'")
				->update($data_quiz);
		} else {
			DB::table('nilai_quiz')->insert($data_quiz);
		}

		$dataActivity = DB::selectOne("
			SELECT
				c.ID_ACTIVITY
			FROM 
				item_course ic
			LEFT JOIN course c ON
				c.ID_COURSE = ic.ID_COURSE
			WHERE 
				ic.ID_ITEM = $id_quiz
		");

		$max_id_item = DB::selectOne("
			SELECT
				MAX(ID_ITEM) AS MAX_ID
			FROM
				mapping_course
			WHERE
				ID_USER = '" . $id_user . "'
				AND ID_ACTIVITY = '" . $dataActivity->ID_ACTIVITY . "'"
		);

		$data_all_mapping = $this->courseModel->get_counttask($dataActivity->ID_ACTIVITY);
		$count = ['MAPPING_COUNT' => ((int) $data_all_mapping[0]->MAPPING_COUNT) + 1];
		if ($nilai >= 75 && $max_id_item->MAX_ID == $id_quiz) {
			DB::table("order")
				->where('ID_USER', session('user')[0]->get('ID_USER'))
				->where('ID_PRODUCT', $dataActivity->ID_ACTIVITY)
				->update($count);
		}

		echo $nilai;
	}
	public function searchCourse()
	{
		$keyword = $_GET['keyword'];
		$data['data_search'] = $this->courseModel->get_course_by_id($keyword, 1);
		return
			view('template_guest.course.ajax.item_search', $data);
	}
	public function getFilterByKat(Request $req)
	{
		$condition = (!empty($_POST['category'])) ? "WHERE activity.TYPE_ACTIVITY = 1 AND activity.IS_PUBLIC = 1 AND course.KATEGORI = '" . $_POST['category'] . "'" : "WHERE activity.TYPE_ACTIVITY = 1 AND activity.IS_PUBLIC = 1";
		$id_user = (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');
		//999 is id tab invited
		if ($_POST['category'] == 999) {
			$data_id = DB::select("
				SELECT
					ID_ACTIVITY
				FROM
					tb_invited
				WHERE
					ID_USER = '" . $id_user . "'
			");

			$data_ids = array_map(function ($item) {
				return $item->ID_ACTIVITY;
			}, $data_id);
			$placeholders = "'" . implode("','", $data_ids) . "'";
			$condition = "WHERE activity.TYPE_ACTIVITY = 1 AND activity.ID_ACTIVITY IN (" . $placeholders . ")";
		}

		$id_user = (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');

		if ($id_user != null) {
			$data['course'] = DB::select('
				SELECT 
					activity.*, 
					course.DESKRIPSI_COURSE,
					(
						SELECT
							COUNT(*)
						FROM
							`order` o
						WHERE
							o.ID_USER = "' . $id_user . '"
							AND o.ID_PRODUCT = activity.ID_ACTIVITY	
					) AS DATA_CHECKING,
					(
						SELECT
							COUNT(o.ID_ORDER)
						FROM
							`order` o
						WHERE
							o.ID_PRODUCT = activity.ID_ACTIVITY 
					) AS participant,
					(
						CEIL(
							(
								SELECT
									MAX(o.MAPPING_COUNT)
								FROM
									`order` o
								WHERE
									o.ID_USER = "' . $id_user . '"
									AND o.ID_PRODUCT = activity.ID_ACTIVITY
							) / 
							(
								SELECT
									COUNT(*)
								FROM
									mapping_course
								WHERE
									mapping_course.ID_USER = "' . $id_user . '"
									AND mapping_course.ID_ACTIVITY = activity.ID_ACTIVITY
							) * 100
						)
					) AS PROGRESS
				FROM 
					activity
				LEFT JOIN course ON
					course.ID_ACTIVITY = activity.ID_ACTIVITY
				' . $condition . '
				');
		} else {
			$data['course'] = DB::select('
				SELECT 
					activity.*, 
					course.DESKRIPSI_COURSE,
					(
						SELECT
							COUNT(o.ID_ORDER)
						FROM
							`order` o
						WHERE
							o.ID_PRODUCT = activity.ID_ACTIVITY 
					) AS participant
				FROM 
					activity
				LEFT JOIN 
					course ON course.ID_ACTIVITY = activity.ID_ACTIVITY
					' . $condition . '
				');
		}
		return
			view('template_guest.course.ajax.course_by_category', $data);
	}
	public function GenerateUniqID_Order($var)
	{
		$string = preg_replace('/[^a-z]/i', '', $var);
		$vocal = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
		$scrap = str_replace($vocal, "", $string);
		$begin = substr($scrap, 0, 6);
		$uniqid = strtoupper($begin);
		return "ORD_" . $uniqid . substr(md5(time()), 0, 6);
	}
	// END COURSE CONTROLLER
}
