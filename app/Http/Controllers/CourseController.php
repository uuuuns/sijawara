<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\FileUpload;

class CourseController extends Controller
{
    private $id_detailCourse = 0;
    public function index()
    {
        $data['title'] = "Kursus";

        if (session('user')[0]->get('ID_ROLE') == 1 || session('user')[0]->get('ID_ROLE') == 4) {
            $data["activity"] = DB::select("
            SELECT
                c.*
            FROM
                activity c
            LEFT JOIN activity a ON
                a.ID_ACTIVITY = c.ID_ACTIVITY
            WHERE
                a.TYPE_ACTIVITY = 1
            ");
        } else {
            $data['course'] = DB::select("
                SELECT
                    c.*
                FROM    
                    course c
                LEFT JOIN activity a ON
                    a.ID_ACTIVITY = c.ID_ACTIVITY
                WHERE
                    a.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
                    AND a.TYPE_ACTIVITY = 1
            ");

            $data["activity"] = DB::select("
            SELECT
                c.*
            FROM
                activity c
            WHERE
                c.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
            ");
        }

        $data["kategori"] = DB::select("
            SELECT
                k.*
            FROM
                kategori k
        ");
        $data['admin'] = true;
        return
            view('template.header', $data) .
            view('template_admin/course/course', $data) .
            view('template.footer', $data);
    }

    public function add_course()
    {
        $data['title'] = "Kursus Baru";

        $data["kategori"] = DB::select("
            SELECT
                k.*
            FROM
                kategori k
        ");

        return
            view('template.header', $data) .
            view('template_admin/course/add_course', $data) .
            view('template.footer', $data);
    }

    public function store(Request $req)
    {
        try {
            $validatedData = $req->validate([
                'title_activity' => 'required',
                'date_start' => 'required',
                'date_end' => 'required',
                'desc_course' => 'required',
                'benefit' => 'required',
                'certif_code' => 'required',
                'order_list' => 'required',
                'order_list_question' => 'required'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => $e->errors()
            ], 422);
        }

        $activity = [
            'ID_ACTIVITY'           => $this->GenerateUniqID('ACT', $req->input('title_activity')),
            'TITLE_ACTIVITY'        => $req->input('title_activity'),
            'ID_USER'               => session('user')[0]['ID_USER'],
            'IMAGE_ACTIVITY'        => FileUpload::S3($req->file('image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now())),
            'TYPE_ACTIVITY'         => 1,
            'SERTIF_CODE'           => $req->input('certif_code'),
            'DATE_START'            => $req->input('date_start'),
            'DATE_END'              => $req->input('date_end'),
            'IS_PUBLIC'             => $req->input('is_public'),
            'LOG_TIME'              => date('Y-m-d H:i:s')
        ];
        if ($req->input('status') == 'on') {
            $activity['STATUS'] = 1;
        } else {
            $activity['STATUS'] = 0;
        }

        $course = [
            'ID_COURSE'             => $this->GenerateUniqID('ACT', $req->input('announcement')),
            'ID_ACTIVITY'           => $activity['ID_ACTIVITY'],
            'DESKRIPSI_COURSE'      => $req->input('desc_course'),
            'BENEFIT'               => $req->input('benefit'),
            'KATEGORI'              => $req->input('category')
        ];

        DB::table('activity')->insert($activity);
        DB::table('course')->insert($course);

        $data['ID_COURSE'] = $course['ID_COURSE'];
        $this->item_materi($data, $req);
        return redirect('courses')->with(['succ_msg' => 'Berhasil Menambahkan Kursus', 'location' => 'courses']);
    }

    public function deskripsi_get($id)
    {
        $desc = DB::selectOne("
            SELECT
                c.DESKRIPSI_COURSE ,
                c.BENEFIT
            FROM
                activity a
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                a.ID_ACTIVITY = '$id'
        ");

        return response([
            'status_code'       => 200,
            'status_message'    => 'Data diterima',
            $desc
        ], 200);
    }

    public function add_materi($i)
    {
        $id_detailCourse = $i + 1;
        $data['no'] = $id_detailCourse;

        return
            view('template_admin.course.item_materi', $data);
    }

    public function add_quiz($j, $id_quiz)
    {
        $id_detailCourse = $j + 1;
        $data['no'] = $id_detailCourse;
        $data['id_quiz'] = $id_quiz;

        return
            view('template_admin.course.item_quiz', $data);
    }

    public function add_question($id, $index)
    {
        $id_detailQuiz_Question = $id;
        $data['no'] = $id_detailQuiz_Question;
        $data['index'] = $index;

        return
            view('template_admin.course.item_question', $data);
    }

    public function update_course(Request $req)
    {
        $data['title'] = "Edit Kursus";

        $data['kategori'] = DB::select("
            SELECT
                k.*
            FROM
                kategori k
        ");

        $data_course = DB::Select("
            SELECT
                a.ID_ACTIVITY ,
                a.IMAGE_ACTIVITY ,
                a.TITLE_ACTIVITY ,
                a.PRICE_ACTIVITY ,
                a.DATE_START ,
                a.DATE_END ,
                a.STATUS ,
                c.ID_COURSE ,
                c.PENGUMUMAN ,
                c.DESKRIPSI_COURSE ,
                c.DESKRIPSI_COURSE_ITEM ,
                a.SERTIF_CODE ,
                k.ID_KATEGORI 
            FROM
                activity a
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            LEFT JOIN kategori k ON
                k.ID_KATEGORI = c.KATEGORI
            WHERE 
                a.ID_ACTIVITY = '" . $req->input('id_activity') . "'
        ")[0];

        $data['items'] = DB::Selectone("
            SELECT
                COUNT(ic.ID_COURSE) AS tot_item,
                max(ic.ID_ITEM) AS last_id
            FROM
                item_course ic
            LEFT JOIN course c ON
                c.ID_COURSE = ic.ID_COURSE
            WHERE
                c.ID_ACTIVITY = '" . $data_course->ID_ACTIVITY . "'
        ");

        $jsonData = json_encode($data_course);
        $data['item'] = json_encode($data['items']->tot_item);

        return
            view('template.header', $data) .
            view('template_admin/course/update_course', compact('data', 'jsonData')) .
            view('template.footer', $data);
    }

    public function get_course_item($id_course)
    {
        $data['data_materi'] = DB::select("
            SELECT
                *
            FROM
                item_course
            WHERE
                ID_COURSE = '" . $id_course . "'
            ORDER BY
                ORDER_LIST ASC
        ");

        $data['items'] = [];
        $data['quiz'] = [];
        $allView = "";

        foreach ($data['data_materi'] as $key => $item_data) {
            $data['no'] = $key + 1;
            if ($item_data->TYPE == 1) {
                $data['item'] = [
                    'ID_ITEM'   => $item_data->ID_ITEM,
                    'FILE'      => $item_data->FILE,
                    'TITLE'     => $item_data->TITLE,
                    'LINK_YT'   => $item_data->LINK_YT,
                    'DESKRIPSI' => $item_data->DESKRIPSI,
                    'ORDER_LIST' => $item_data->ORDER_LIST
                ];
                $allView .= view('template_admin.course.update_materi', $data)->render();
            } else {
                $data['id_quiz'] = $item_data->ID_ITEM;
                $dataquiz = DB::select("
                    SELECT
                        *
                    FROM
                        detail_quiz
                    WHERE
                        ID_QUIZ = '" . $item_data->ID_ITEM . "'
                ");

                $data['quiz'] = [];
                $data['no_index'] = 0;
                foreach ($dataquiz as $quiz) {
                    list($quiz->PIL_A, $quiz->PIL_B, $quiz->PIL_C, $quiz->PIL_D) = explode(";", $quiz->PIL_JWB);
                    $data['quiz'][$quiz->ID_QUIZ][] = [
                        'ID_DETAIL'  => $quiz->ID_DETAIL,
                        'ID_QUIZ'    => $quiz->ID_QUIZ,
                        'ID_COURSE'  => $quiz->ID_COURSE,
                        'SOAL'       => $quiz->SOAL,
                        'PIL_A'      => $quiz->PIL_A,
                        'PIL_B'      => $quiz->PIL_B,
                        'PIL_C'      => $quiz->PIL_C,
                        'PIL_D'      => $quiz->PIL_D,
                        'KUNCI'      => $quiz->KUNCI,
                        'ORDER_LIST' => $quiz->ORDER_LIST,
                        'NO'         => $data['no_index']
                    ];

                    foreach ($data['quiz'][$quiz->ID_QUIZ] as $ID_ITEM) {
                        $data['ID_ITEM'] = $ID_ITEM['ID_QUIZ'];
                    }
                    $data['no_index']++;
                }
                $allView .= view('template_admin.course.update_quiz', $data)->render();
            }
        }
        return $allView;
    }

    public function send_question(Request $request)
    {
        $quizData = $request->input('quizData');
        $no_index = 1;
        $no = $request->input('no');
        $html = '';
        foreach ($quizData as $question) {
            $html .= view('template_admin.course.update_question', ['item' => $question, 'no' => $no, 'index' => $no_index])->render();
            $no_index++;
        }

        return response()->json([
            'success' => true,
            'message' => 'Data received successfully!',
            'html' => $html
        ]);
    }

    public function update(Request $req)
    {
        try {
            $validatedData = $req->validate([
                'ID_ACTIVITY' => 'required',
                'ID_COURSE' => 'required',
                'title_activity' => 'required',
                'date_start' => 'required',
                'date_end' => 'required',
                'desc_course' => 'required',
                'benefit' => 'required',
                'certif_code' => 'required',
                'order_list' => 'required',
                'ID_ITEM' => 'required',
                'order_list_question' => 'required'
            ]);

            $activity = [
                'TITLE_ACTIVITY'        => $req->input('title_activity'),
                'ID_USER'               => session('user')[0]['ID_USER'],
                'SERTIF_CODE'           => $req->input('certif_code'),
                'DATE_START'            => $req->input('date_start'),
                'DATE_END'              => $req->input('date_end'),
                'IS_PUBLIC'             => $req->input('is_public'),
                'LOG_TIME'              => date('Y-m-d H:i:s')
            ];

            if (!empty($req->file('image_activity'))) {
                $activity['IMAGE_ACTIVITY'] = FileUpload::S3($req->file('image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now()));
            }

            if ($req->input('status') == 'on') {
                $activity['STATUS'] = 1;
            } else {
                $activity['STATUS'] = 0;
            }

            $course = [
                'ID_ACTIVITY'           => $req->input('ID_ACTIVITY'),
                'DESKRIPSI_COURSE'      => $req->input('desc_course'),
                'BENEFIT'               => $req->input('benefit'),
                'KATEGORI'              => $req->input('category')
            ];

            DB::table('activity')->WHERE(['ID_ACTIVITY' => $req->input('ID_ACTIVITY')])->update($activity);
            DB::table('course')->WHERE(['ID_ACTIVITY' => $req->input('ID_ACTIVITY')])->update($course);

            DB::table('item_course')->WHERE(['ID_COURSE' => $req->input('ID_COURSE')])->delete();
            DB::table('detail_quiz')->WHERE(['ID_COURSE' => $req->input('ID_COURSE')])->delete();

            $data['ID_COURSE'] = $req->input('ID_COURSE');
            $this->update_item_materi($data, $req);

            return redirect('courses')->with(['succ_msg' => 'Berhasi Memperbarui Kursus', 'location' => 'courses']);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function update_materi($req)
    {
        $id_item            = $req->input('ID_ITEM');
        $orderList          = $req->input('order_list');
        $categoryList       = $req->input('type');
        $materiTitleList    = $req->input('materi_title');
        $descMateriList     = $req->input('desc_materi');
        $linkYT             = $req->input('materi_link');

        if (!empty($req->file('materi_file'))) {
            $file           = $req->file('materi_file');
        }

        if (!empty($orderList)) {
            for ($i = 0; $i < count($orderList); $i++) {
                if ($categoryList[$i] == 1) {

                    if (empty($id_item[$i])) {
                        $where = '0';
                    } else {
                        $where = $id_item[$i];
                    }

                    $data_item = [
                        'TITLE'         => $materiTitleList[$i],
                        'ID_COURSE'     => $req->input('ID_COURSE'),
                        'LINK_YT'       => $linkYT[$i],
                        'DESKRIPSI'     => $descMateriList[$i],
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i]
                    ];

                    if (!empty($file[$i])) {
                        $data_item['FILE'] = FileUpload::S3($file[$i], 'MATERI_FILE', 'Materi-' . strtotime(now()));
                    }

                    DB::table('item_course')->updateOrInsert(['ID_ITEM' => $where], $data_item);
                } else {
                    $data_item = [
                        'TITLE'         => null,
                        'FILE'          => null,
                        'LINK_YT'       => null,
                        'DESKRIPSI'     => null,
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i]
                    ];
                    DB::table('item_course')->updateOrInsert(['ID_ITEM' => $id_item[$i]], $data_item);
                }
            }
        }
        if (!empty($req->input('question'))) {
            $this->update_quiz($req);
        }
    }

    public function update_quiz($req)
    {
        $jawaban_a          = $req->input('jawaban_a');
        $jawaban_b          = $req->input('jawaban_b');
        $jawaban_c          = $req->input('jawaban_c');
        $jawaban_d          = $req->input('jawaban_d');
        $question           = $req->input('question');
        $kunci_soal         = $req->input('kunci_soal_');
        $id_detail          = $req->input('ID_DETAIL');

        foreach ($kunci_soal as $index => $value) {
            $id         = $id_detail[$index];
            $questions  = $question[$index];
            $pil_a      = $jawaban_a[$index];
            $pil_b      = $jawaban_b[$index];
            $pil_c      = $jawaban_c[$index];
            $pil_d      = $jawaban_d[$index];
            $kunci      = $kunci_soal[$index];
            foreach ($value as $index_detail => $value_detail) {
                $quiz = [
                    'ID_DETAIL'     => $id[$index_detail],
                    'SOAL'          => $questions[$index_detail],
                    'PIL_JWB'       => implode(';', [$pil_a[$index_detail], $pil_b[$index_detail], $pil_c[$index_detail], $pil_d[$index_detail]]),
                    'KUNCI'         => $kunci[$index_detail]
                ];
                DB::table('detail_quiz')->WHERE(['ID_DETAIL' => $id[$index_detail]])->update($quiz);
            }
        }
    }

    public function delete(Request $req)
    {
        $find_id_course = DB::selectOne("
            SELECT
                *
            FROM
                course
            WHERE
                ID_ACTIVITY = '" . $req->id_activity . "'
        ");
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('tb_invited')->where('ID_ACTIVITY', $find_id_course->ID_ACTIVITY)->delete();
        DB::table('detail_quiz')->where('ID_COURSE', $find_id_course->ID_COURSE)->whereNotNull('ID_COURSE')->delete();
        DB::table('tb_komentar')->WHERE(['ID_ACTIVITY' => $find_id_course->ID_ACTIVITY])->delete();
        DB::table('mapping_course')->WHERE(['ID_ACTIVITY' => $find_id_course->ID_ACTIVITY])->delete();
        DB::table('item_course')->WHERE(['ID_COURSE' => $find_id_course->ID_COURSE])->delete();
        DB::table('course')->WHERE(['ID_COURSE' => $find_id_course->ID_COURSE])->delete();
        DB::table('activity')->WHERE(['ID_ACTIVITY' => $find_id_course->ID_ACTIVITY])->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return redirect('courses')->with(['succ_msg' => 'Berhasil Menghapus Kursus', 'location' => 'courses']);
    }

    public function item_materi($data, $req)
    {
        $orderList          = $req->input('order_list');
        $categoryList       = $req->input('type');
        $materiTitleList    = $req->input('materi_title');
        $descMateriList     = $req->input('desc_materi');
        $file               = $req->file('materi_file');
        $linkYT             = $req->input('materi_link');
        $idQuiz          = [];

        if (!empty($orderList)) {
            for ($i = 0; $i < count($orderList); $i++) {
                if ($categoryList[$i] == 1) {
                    $data_item = [
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'TITLE'         => $materiTitleList[$i],
                        'FILE'          => !empty($file[$i]) ? FileUpload::S3($file[$i], 'MATERI_FILE', 'Materi-' . str_replace(' ', '', $file[$i]->getClientOriginalName()) . '-' . strtotime(now())) : null,
                        'LINK_YT'       => $linkYT[$i],
                        'DESKRIPSI'     => $descMateriList[$i],
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i]
                    ];
                    DB::table('item_course')->insert($data_item);
                } else {
                    $data_item = [
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'TITLE'         => null,
                        'FILE'          => null,
                        'LINK_YT'       => null,
                        'DESKRIPSI'     => null,
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i]
                    ];
                    $idQuiz[] = DB::table('item_course')->insertGetId($data_item);
                }
            }
        }
        if (!empty($req->input('question'))) {
            $data['data_item'] = $data_item;
            $this->item_quiz($data, $req, $idQuiz);
        }
    }

    public function item_quiz($data, $req, $lastIdQuiz)
    {
        $jawaban_a          = $req->input('jawaban_a');
        $jawaban_b          = $req->input('jawaban_b');
        $jawaban_c          = $req->input('jawaban_c');
        $jawaban_d          = $req->input('jawaban_d');
        $order_list_quiz    = $req->input('order_list_question');
        $question           = $req->input('question');
        $kunci_soal         = $req->input('kunci_soal');

        $tmpNo = 0;
        $tmpNoQuiz = 0;
        foreach ($question as $i => $questions) {
            $id_quiz = $lastIdQuiz[$tmpNoQuiz];
            for ($j = 1; $j <= count($questions); $j++) {
                $quiz = [
                    'ID_QUIZ'       => $id_quiz,
                    'ID_COURSE'     => $data['ID_COURSE'],
                    'SOAL'          => $questions[$j],
                    'PIL_JWB'       => implode(';', [$jawaban_a[$tmpNo], $jawaban_b[$tmpNo], $jawaban_c[$tmpNo], $jawaban_d[$tmpNo]]),
                    'KUNCI'         => $kunci_soal[$i][$j],
                    'ORDER_LIST'    => $order_list_quiz[$tmpNo]
                ];
                DB::table('detail_quiz')->insert($quiz);
                $tmpNo++;
            }
            $tmpNoQuiz++;
        }
    }

    public function invite(Request $req)
    {
        $data['title']  = "Undang User";

        $data['users']   = DB::select("
            SELECT
                u.*,
                (SELECT
                    COUNT(*)
                FROM
                    tb_invited i
                WHERE
                    i.ID_USER = u.ID_USER
                AND
                    i.ID_ACTIVITY = '" . $req->input('id_activity') . "') AS is_invited
            FROM
                user u
            WHERE
                u.IS_DELETE = 0
            AND
                ID_ROLE <> 1
        ");

        $data['activity'] = DB::Select("
            SELECT
                a.*
            FROM
                activity a
            WHERE
                a.ID_ACTIVITY = '" . $req->input('id_activity') . "'
        ")[0];

        return
            view('template.header', $data) .
            view('template_admin/course/invite_user', $data) .
            view('template.footer', $data);
    }

    public function batalkan_undangan(Request $req)
    {
        $id_user = $req->input('id_user');
        $id_activity = $req->input('id_activity');

        $cek_data = DB::SelectOne("
            SELECT
                *
            FROM
                tb_invited
            WHERE
                ID_USER = '" . $id_user . "'
            AND
                ID_ACTIVITY = '" . $id_activity . "'
        ");

        if (!empty($cek_data)) {
            DB::table('tb_invited')->WHERE(['ID_USER' => $id_user, 'ID_ACTIVITY' => $id_activity])->delete();
            return redirect('courses/invite?id_activity=' . $id_activity)->with(['succ_msg' => 'Undangan telah dibatalkan', 'location' => 'courses/invite?id_activity=' . $id_activity]);
        } else {
            return redirect('courses/invite?id_activity=' . $id_activity)->with(['succ_msg' => 'User belum diundang', 'courses/invite?id_activity=' . $id_activity]);
        }
    }
    public function invite_individu(Request $req)
    {
        $id_user = $req->input('id_user');
        $id_activity = $req->input('id_activity');

        $cek_data = DB::SelectOne("
            SELECT
                *
            FROM
                tb_invited
            WHERE
                ID_USER = '" . $id_user . "'
            AND
                ID_ACTIVITY = '" . $id_activity . "'
        ");

        if (!empty($cek_data)) {
            return redirect('courses/invite?id_activity=' . $id_activity)->with(['err_msg' => 'User telah diundang', 'location' => 'courses/invite?id_activity=' . $id_activity]);
        } else {
            $invited = [
                'ID_USER'       => $id_user,
                'ID_ACTIVITY'   => $id_activity
            ];
            DB::table('tb_invited')->insert($invited);
            return redirect('courses/invite?id_activity=' . $id_activity)->with(['succ_msg' => 'User berhasil diundang', 'courses/invite?id_activity=' . $id_activity]);
        }
    }

    public function invite_batch(Request $req)
    {
        $id_users = $req->input('id_user');
        $id_activity = $req->input('id_act');

        // Memastikan $id_logins adalah array
        if (!is_array($id_users)) {
            // Jika $id_logins bukan array, kita coba untuk mengonversinya
            if (is_string($id_users)) {
                // Jika $id_logins adalah string, kita pecah string tersebut menjadi array
                $id_users = explode(',', $id_users);
            } else {
                $id_users = [];
            }
        }

        if (empty($id_users)) {
            return redirect('courses/invite?id_activity=' . $id_activity)->with(['err_msg' => 'Pilih setidaknya satu pengguna', 'location' => 'courses/invite?id_activity=' . $id_activity]);
        }

        foreach ($id_users as $id_user) {
            $cek_data = DB::SelectOne("
                SELECT
                    *
                FROM
                    tb_invited
                WHERE
                    ID_USER = '" . $id_user . "'
                AND
                    ID_ACTIVITY = '" . $id_activity . "'
            ");

            if (!empty($cek_data)) {
                return redirect('courses/invite?id_activity=' . $id_activity)->with(['err_msg' => 'Pilih setidaknya satu pengguna', 'location' => 'courses/invite?id_activity=' . $id_activity]);
            } else {
                $invited = [
                    'ID_USER'       => $id_user,
                    'ID_ACTIVITY'   => $id_activity
                ];
                DB::table('tb_invited')->insert($invited);
            }
        }
        return redirect('courses/invite?id_activity=' . $id_activity)->with(['succ_msg' => 'Berhasil mengundang user', 'courses/invite?id_activity=' . $id_activity]);
    }

    public function GenerateUniqID($prefix, $var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return $prefix . "_" . $uniqid . substr(md5(time()), 0, 3);
    }

    public function index_lihat_peserta(Request $req)
    {
        $data['title'] = "Peserta Kursus";

        $data['list_peserta'] = DB::select("
            SELECT
                u.EMAIL,
                u.ID_USER ,
                u.NAME,
                u.TELP,
                u.JK ,
                u.ALAMAT,
                o.LOG_TIME,
                a.TITLE_ACTIVITY,
                (
                    CEIL(
                        (
                            SELECT
                                MAX(o.MAPPING_COUNT)
                            FROM
                                `order` o
                            WHERE
                                o.ID_USER  = u.ID_USER 
                                AND o.ID_PRODUCT = a.ID_ACTIVITY
                        ) / 
                        (
                            SELECT
                                COUNT(*)
                            FROM
                                mapping_course
                            WHERE
                                mapping_course.ID_USER = u.ID_USER
                                AND mapping_course.ID_ACTIVITY = a.ID_ACTIVITY
                        ) * 100
                    )
                ) AS PROGRESS,
                (
                    CEIL 
                    (
                    (
                        SELECT
                            SUM(nq.NILAI)
                        FROM 
                            nilai_quiz nq
                        LEFT JOIN detail_quiz dq ON
                            dq.ID_QUIZ = nq.ID_QUIZ
                        LEFT JOIN course c ON
                            c.ID_COURSE = dq.ID_COURSE
                        WHERE
                            nq.ID_USER = u.ID_USER
                            AND c.ID_ACTIVITY = o.ID_PRODUCT
                    ) / (
                        SELECT
                            COUNT(nq2.NILAI)
                        FROM
                            nilai_quiz nq2
                        LEFT JOIN detail_quiz dq ON
                            dq.ID_QUIZ = nq2.ID_QUIZ
                        LEFT JOIN course c ON
                            c.ID_COURSE = dq.ID_COURSE
                        WHERE
                            nq2.ID_USER = u.ID_USER
                            AND c.ID_ACTIVITY = o.ID_PRODUCT 
                    )
                    )
                ) AS NILAI  
            FROM
                user u
            LEFT JOIN user_data ud ON   
                ud.ID_USER = u.ID_USER
            LEFT JOIN `order` o ON
                o.ID_USER = u.ID_USER 
            LEFT JOIN activity a  ON
                o.ID_PRODUCT  = a.ID_ACTIVITY
            WHERE
                o.ID_PRODUCT  = '" . $req->input('ID_ACTIVITY') . "'
        ");

        $data['kursus'] = DB::selectOne("
            SELECT
                a.* ,
                c.*
            FROM
                activity a
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                a.TYPE_ACTIVITY = 1
                AND a.ID_ACTIVITY = '" . $req->input('ID_ACTIVITY') . "'
        ");
        return
            view('template.header', $data) .
            view('template_admin.course.lihat_peserta_course', $data) .
            view('template.footer', $data);
    }

    public function laporan_course(Request $req)
    {
        $event = DB::select("
            SELECT
                u.EMAIL,
                u.ID_USER ,
                u.NAME,
                u.TELP,
                u.JK ,
                u.ALAMAT,
                o.LOG_TIME,
                a.TITLE_ACTIVITY,
                (
                    CEIL(
                        (
                            SELECT
                                MAX(o.MAPPING_COUNT)
                            FROM
                                `order` o
                            WHERE
                                o.ID_USER  = u.ID_USER 
                                AND o.ID_PRODUCT = a.ID_ACTIVITY
                        ) / 
                        (
                            SELECT
                                COUNT(*)
                            FROM
                                mapping_course
                            WHERE
                                mapping_course.ID_USER = u.ID_USER
                                AND mapping_course.ID_ACTIVITY = a.ID_ACTIVITY
                        ) * 100
                    )
                ) AS PROGRESS,
                (
                    CEIL 
                    (
                    (
                        SELECT
                            SUM(nq.NILAI)
                        FROM 
                            nilai_quiz nq
                        LEFT JOIN detail_quiz dq ON
                            dq.ID_QUIZ = nq.ID_QUIZ
                        LEFT JOIN course c ON
                            c.ID_COURSE = dq.ID_COURSE
                        WHERE
                            nq.ID_USER = u.ID_USER
                            AND c.ID_ACTIVITY = o.ID_PRODUCT
                    ) / (
                        SELECT
                            COUNT(nq2.NILAI)
                        FROM
                            nilai_quiz nq2
                        LEFT JOIN detail_quiz dq ON
                            dq.ID_QUIZ = nq2.ID_QUIZ
                        LEFT JOIN course c ON
                            c.ID_COURSE = dq.ID_COURSE
                        WHERE
                            nq2.ID_USER = u.ID_USER
                            AND c.ID_ACTIVITY = o.ID_PRODUCT 
                    )
                    )
                ) AS Rata_Nilai
            FROM
                user u
            LEFT JOIN user_data ud ON   
                ud.ID_USER = u.ID_USER
            LEFT JOIN `order` o ON
                o.ID_USER = u.ID_USER 
            LEFT JOIN activity a  ON
                o.ID_PRODUCT  = a.ID_ACTIVITY
            WHERE
                o.ID_PRODUCT  = '" . $req->input('ID_ACTIVITY') . "'
        ");
        app(Laporan::class)->laporan_course($event);
    }
    public function update_item_quiz($data, $req, $lastIdQuiz)
    {
        $id_quiz_in = implode(',', $req->input('ID_QUIZ'));
        $id_quiz_old = DB::select("
            SELECT
                ID_QUIZ
            FROM 
                nilai_quiz
            WHERE
                ID_QUIZ IN (".$id_quiz_in.")
        ");

        $jawaban_a          = $req->input('jawaban_a');
        $jawaban_b          = $req->input('jawaban_b');
        $jawaban_c          = $req->input('jawaban_c');
        $jawaban_d          = $req->input('jawaban_d');
        $order_list_quiz    = $req->input('order_list_question');
        $question           = $req->input('question');
        $kunci_soal         = $req->input('kunci_soal');

        $tmpNo = 0;
        $tmpNoQuiz = 0; 
        foreach ($question as $i => $questions) {
            $id_quiz = $lastIdQuiz[$tmpNoQuiz];
            $maxIndex = max(array_keys($questions));
            for ($j = 1; $j <= $maxIndex; $j++) {
                if(array_key_exists($j, $questions)) {
                    $quiz = [
                        'ID_QUIZ'       => $id_quiz,
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'SOAL'          => $questions[$j],
                        'PIL_JWB'       => implode(';', [$jawaban_a[$tmpNo], $jawaban_b[$tmpNo], $jawaban_c[$tmpNo], $jawaban_d[$tmpNo]]),
                        'KUNCI'         => $kunci_soal[$i][$j],
                        'ORDER_LIST'    => $order_list_quiz[$tmpNo]
                    ];
                    DB::table('detail_quiz')->insert($quiz);
                    $tmpNo++;
                }
            }
            if(!empty($id_quiz_old)) {
                DB::table('nilai_quiz')->WHERE(['ID_QUIZ' => $id_quiz_old[$tmpNoQuiz]->ID_QUIZ])->update(['ID_QUIZ' => $id_quiz]);
            }
            $tmpNoQuiz++;
        }
    }
    public function update_item_materi($data, $req)
    {
        $orderList          = $req->input('order_list');
        $categoryList       = $req->input('type');
        $materiTitleList    = $req->input('materi_title');
        $descMateriList     = $req->input('desc_materi');
        $linkYT             = $req->input('materi_link');
        $file = $req->file('materi_file');
        $file_default = $req->input('default_file');
        

        $idQuiz = [];
        if (!empty($orderList)) {
            for ($i = 0; $i < count($orderList); $i++) {
                if ($categoryList[$i] == 1) {
                    $data_item = [
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'TITLE'         => $materiTitleList[$i],
                        'FILE'          => !empty($file[$i]) ? FileUpload::S3($file[$i], 'MATERI_FILE', 'Materi-' . str_replace(' ', '', $file[$i]->getClientOriginalName()) . '-' . strtotime(now())) : (!empty($file_default[$i]) ? $file_default[$i] : null),
                        'LINK_YT'       => $linkYT[$i],
                        'DESKRIPSI'     => $descMateriList[$i],
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i]
                    ];
                    DB::table('item_course')->insert($data_item);
                } else {
                    $data_item = [
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'TITLE'         => null,
                        'FILE'          => null,
                        'LINK_YT'       => null,
                        'DESKRIPSI'     => null,
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i]
                    ];
                    $idQuiz[] = DB::table('item_course')->insertGetId($data_item);
                }
            }
        }
        if (!empty($req->input('question'))) {
            $data['data_item'] = $data_item;
            $this->update_item_quiz($data, $req, $idQuiz);
        }
    }
}
