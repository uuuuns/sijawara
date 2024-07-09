<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\FileUpload;

class CourseController extends Controller
{
    private $id_detailCourse = 0;
    public function __construct()
    {
        // 
    }
    public function index()
    {
        $data['title'] = "Kursus";

        if (session('user')[0]->get('ID_ROLE') == 1) {
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

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.course.course', $data) .
            view('template_main.admin_side.etc.footer');
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
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.course.add_course', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function store(Request $req)
    {
        $activity = [
            'ID_ACTIVITY'           => $this->GenerateUniqID('ACT', $req->input('title_activity')),
            'TITLE_ACTIVITY'        => $req->input('title_activity'),
            'ID_USER'               => session('user')[0]['ID_USER'],
            'PRICE_ACTIVITY'        => $req->input('price_course'),
            'IMAGE_ACTIVITY'        => FileUpload::S3($req->file('image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now())),
            'TYPE_ACTIVITY'         => 1,
            'SERTIF_CODE'           => $req->input('certif_code'),
            'DATE_START'            => $req->input('date_start'),
            'DATE_END'              => $req->input('date_end'),
            'IS_PUBLIC'             => $req->input('is_public'),
            'LOG_TIME'              => date('Y-m-d H:i:s')
        ];

        if ($req->input('status') == 'on') {
            $activity['STATUS'] = 0;
        } else {
            $activity['STATUS'] = 1;
        }

        $course = [
            'ID_COURSE'             => $this->GenerateUniqID('ACT', $req->input('announcement')),
            'ID_ACTIVITY'           => $activity['ID_ACTIVITY'],
            'PENGUMUMAN'            => $req->input('announcement'),
            'DESKRIPSI_COURSE'      => $req->input('desc_course'),
            'DESKRIPSI_COURSE_ITEM' => $req->input('desc_what_to_learn'),
            'KATEGORI'              => $req->input('category'),
        ];

        DB::table('activity')->insert($activity);
        DB::table('course')->insert($course);

        $data['ID_COURSE'] = $course['ID_COURSE'];
        $this->item_materi($data, $req);

        return redirect('courses')->with(['succ_msg' => 'Successfully Add New Course', 'location' => 'courses']);
    }

    public function add_materi($i)
    {
        $id_detailCourse = $i + 1;
        $data['no'] = $id_detailCourse;

        return
            view('template_main.admin_side.course.item_materi', $data);
    }

    public function add_quiz($j, $id_quiz)
    {
        $id_detailCourse = $j + 1;
        $data['no'] = $id_detailCourse;
        $data['id_quiz'] = $id_quiz;

        return
            view('template_main.admin_side.course.item_quiz', $data);
    }

    public function add_question($id, $index, $id_quiz)
    {
        $id_detailQuiz_Question = $id + 1;
        $data['no'] = $id_detailQuiz_Question;
        $data['index'] = $index;
        $data['no_quiz'] = $id_quiz;

        return
            view('template_main.admin_side.course.item_question', $data);
    }

    public function update_course(Request $req)
    {
        $data['title'] = "Edit Kursus";

        $data["kategori"] = DB::select("
            SELECT
                k.*
            FROM
                kategori k
        ");

        $data['data'] = DB::Select("
            SELECT
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
                k.KATEGORI
            FROM
                activity a
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            LEFT JOIN kategori k ON
                k.ID_KATEGORI = c.KATEGORI
            WHERE 
                a.ID_ACTIVITY = '" . $req->input('id_activity') . "'
        ")[0];

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.course.update_course', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function get_course_item($id_course, $id_materi)
    {
        // $id_detailCourse = $id_materi;
        // $data['id_item'] = $id_detailCourse;
        // // $data['data_materi'] = $this->Course->get_all_materi($_GET['ID_COURSE']);
        // $data['data_materi'] = DB::select("
        //     SELECT
        //         *
        //     FROM
        //         item_course
        //     WHERE
        //         ID_COURSE = $id_course
        // ");
        // $data['no'] = 1;
        // foreach ($data['data_materi'] as $item_data) {
        //     $data['item']['ID_ITEM'] = $item_data['ID_ITEM'];
        //     if ($item_data['TYPE'] == 1) {
        //         $data['item'] = array(
        //             'FILE'      => $item_data['FILE'],
        //             'TITLE'     => $item_data['TITLE'],
        //             'LINK_YT'   => $item_data['LINK_YT'],
        //             'DESKRIPSI' => $item_data['DESKRIPSI']
        //         );
        //         $this->load->view('admin/activity/course/materi/item_materi_update', $data);
        //     } else {
        //         $this->load->view('admin/activity/course/quiz/item_quiz_update', $data);
        //     }
        //     $data['no']++;
        // }
    }

    public function update(Request $req)
    {
        $data = [
            '' => $req->input('')
        ];

        DB::table('')->WHERE(['' => $req->input('')])->update($data);

        return redirect('courses')->with(['succ_msg' => 'Successfully Add New Course', 'location' => 'courses']);
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

        DB::table('detail_quiz')->WHERE(['ID_COURSE' => $find_id_course->ID_COURSE])->delete();
        DB::table('item_course')->WHERE(['ID_COURSE' => $find_id_course->ID_COURSE])->delete();
        DB::table('course')->WHERE(['ID_COURSE' => $find_id_course->ID_COURSE])->delete();
        DB::table('activity')->WHERE(['ID_ACTIVITY' => $find_id_course->ID_ACTIVITY])->delete();

        return redirect('courses')->with(['succ_msg' => 'Successfully Delete Course', 'location' => 'courses']);
    }

    public function item_materi($data, $req)
    {
        $orderList          = $req->input('order_list');
        $categoryList       = $req->input('type');
        $materiTitleList    = $req->input('materi_title');
        $descMateriList     = $req->input('desc_materi');
        $file               = $req->input('materi_file');
        $linkYT             = $req->input('materi_link');
        $idQuiz          = [];

        if (!empty($orderList)) {
            for ($i = 0; $i < count($orderList); $i++) {
                if ($categoryList[$i] == 1) {
                    $data_item = [
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'TITLE'         => $materiTitleList[$i],
                        'FILE'          => !empty($file[$i]) ? FileUpload::S3($file[$i], 'MATERI_FILE', 'Materi-' . strtotime(now())) : null,
                        'LINK_YT'       => $linkYT[$i],
                        'DESKRIPSI'     => $descMateriList[$i],
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i]
                    ];
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
                }
                $idQuiz[] = DB::table('item_course')->insertGetId($data_item);
            }
        }


        if (!empty($req->input('question'))) {
            $data['data_item'] = $data_item;
            $this->item_quiz($data, $req, $idQuiz);
        }
    }

    public function item_quiz($data, $req, $lastIdQuiz)
    {
        $jawaban_a              = $req->input('jawaban_a');
        $jawaban_b              = $req->input('jawaban_b');
        $jawaban_c              = $req->input('jawaban_c');
        $order_list_quiz        = $req->input('order_list_question');
        $question               = $req->input('question');
        $kunci_soal             = $req->input('kunci_soal');

        $tmpNo = 0;
        foreach ($question as $i => $questions) {
            $id_quiz = $lastIdQuiz[$tmpNo];
            for ($j = 0; $j < count($questions); $j++) {
                $quiz = [
                    'ID_QUIZ'       => $id_quiz,
                    'ID_COURSE'     => $data['ID_COURSE'],
                    'SOAL'          => $questions[$j],
                    'PIL_JWB'       => implode(',', [$jawaban_a[$tmpNo], $jawaban_b[$tmpNo], $jawaban_c[$tmpNo]]),
                    'KUNCI'         => $kunci_soal[$i][$j],
                    'ORDER_LIST'    => $order_list_quiz[$tmpNo]
                ];
                DB::table('detail_quiz')->insert($quiz);
            }
            $tmpNo++;
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
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.course.invite_user', $data) .
            view('template_main.admin_side.etc.footer');
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
            return redirect('courses/invite?id_activity=' . $id_activity)->with(['err_msg' => 'User Already Invited', 'location' => 'courses/invite?id_activity=' . $id_activity]);
        } else {
            $invited = [
                'ID_USER'       => $id_user,
                'ID_ACTIVITY'   => $id_activity
            ];
            DB::table('tb_invited')->insert($invited);
            return redirect('courses/invite?id_activity=' . $id_activity)->with(['succ_msg' => 'Successfully Invite User', 'courses/invite?id_activity=' . $id_activity]);
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
            return redirect('courses/invite?id_activity=' . $id_activity)->with(['err_msg' => 'Choose at least one user', 'location' => 'courses/invite?id_activity=' . $id_activity]);
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
                return redirect('courses/invite?id_activity=' . $id_activity)->with(['err_msg' => 'Choose at least one user', 'location' => 'courses/invite?id_activity=' . $id_activity]);
            } else {
                $invited = [
                    'ID_USER'       => $id_user,
                    'ID_ACTIVITY'   => $id_activity
                ];
                DB::table('tb_invited')->insert($invited);
            } 
        }
        return redirect('courses/invite?id_activity=' . $id_activity)->with(['succ_msg' => 'Successfully Invite User', 'courses/invite?id_activity=' . $id_activity]);
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
}
