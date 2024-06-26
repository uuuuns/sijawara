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
        $data['title'] = "Course";

        if (session('user')[0]->get('ID_ROLE') == 1) {
            $data['course'] = DB::select("
                SELECT
                    c.*
                FROM
                    course c
            ");

            $data["activity"] = DB::select("
            SELECT
                c.*
            FROM
                activity c
            ");
        } else {
            $data['course'] = DB::select("
                SELECT
                    c.*
                FROM    
                    course c
                WHERE
                    c.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
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
        $data['title'] = "Add Course";

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
        // dd($req);
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

        // dd($req);
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

    public function update_course($id)
    {
        $data['title'] = "Update Course";

        $data["kategori"] = DB::select("
            SELECT
                k.*
            FROM
                kategori k
        ");

        $data["course"] = DB::select("
            SELECT
                a.* ,
                c.* ,
                ic.* ,
                dq.*
            FROM
                activity a
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            LEFT JOIN item_course ic ON
                ic.ID_COURSE = c.ID_COURSE
            LEFT JOIN detail_quiz dq
                dq.ID_COURSE = c.ID_COURSE
            WHERE
                a.STATUS = 1
            AND
                c.ID_ACTIVITY = '" . $id . "'
        ");

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.course.update_course', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function update(Request $req)
    {
        $data = [];

        DB::table('')->WHERE(['' => $req->input('')])->update($data);

        return redirect('courses')->with(['succ_msg' => 'Successfully Add New Course', 'location' => 'courses']);
    }

    public function delete(Request $req)
    {
        $data = [];

        DB::table('')->WHERE(['' => $req->input('')])->delete($data);

        return redirect('courses')->with(['succ_msg' => 'Successfully Add New Course', 'location' => 'courses']);
    }

    public function item_materi($data, $req)
    {
        $orderList          = $req->input('order_list');
        $categoryList       = $req->input('type');
        $materiTitleList    = $req->input('materi_title');
        $descMateriList     = $req->input('desc_materi');
        $file               = $req->file('materi_file');
        $linkYT             = $req->input('materi_link');
        $data_item          = [];

        if (!empty($orderList)) {
            for ($i = 0; $i < count($orderList); $i++) {
                if ($categoryList[$i] == 1) {
                    $materi = [
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'TITLE'         => $materiTitleList[$i],
                        'FILE'          => FileUpload::S3($file[$i], 'MATERI_FILE', 'Materi-' . strtotime(now())),
                        'LINK_YT'       => $linkYT[$i],
                        'DESKRIPSI'     => $descMateriList[$i],
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i]
                    ];

                    $data_item[] = $materi;
                } else {
                    $data_item[] = [
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'TITLE'         => null,
                        'FILE'          => null,
                        'LINK_YT'       => null,
                        'DESKRIPSI'     => null,
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i]
                    ];
                }
            }
        }
        $idQuiz = DB::table('item_course')->insert($data_item);

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
        $questions              = $req->input('question');
        $kunci_soal             = $req->input('kunci_soal');

        $soalformedArray        = $this->transformArray($questions);
        $kunciformedArray       = $this->transformArray($kunci_soal);

        $quiz                   = [];
        for ($i = 0; $i < count($order_list_quiz); $i++) {
            $quiz[] = [
                'ID_QUIZ'       => $lastIdQuiz,
                'ID_COURSE'     => $data['ID_COURSE'],
                'SOAL'          => $soalformedArray[$i],
                'PIL_JWB'       => implode(',', [$jawaban_a[$i], $jawaban_b[$i], $jawaban_c[$i]]),
                'KUNCI'         => $kunciformedArray[$i],
                'ORDER_LIST'    => $order_list_quiz[$i]
            ];

            DB::table('detail_quiz')->insert($quiz);
        }
    }

    function transformArray($array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $flattened = [];
                foreach ($value as $subValue) {
                    if (is_array($subValue)) {
                        foreach ($subValue as $item) {
                            $flattened[] = $item;
                        }
                    } else {
                        $flattened[] = $subValue;
                    }
                }
                $result[] = $flattened;
            } else {
                $result[] = $value;
            }
        }
        return $result;
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
