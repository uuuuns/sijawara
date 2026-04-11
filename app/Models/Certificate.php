<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\URL;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Crypt;
class Certificate extends Model
{
    public function getCertificate($con)
    {
        $query = DB::table('sertifikat_activity');

        foreach ($con as $column => $value) {
            $query->where($column, $value);
        }

        $results = $query->get();
        return $results;
    }
    public function createCertificate($data)
    {
        $this->db->insert('sertifikat_activity', $data);
        return $this->db->affected_rows();
    }

    public function generate($namaUser, $activity_name, $sertificate_no, $template_link, $role, $date, $id_sertif, $type_activity, $list_tema, $hal_2)
    {
        $encryptedId = Crypt::encryptString($id_sertif);
        $file_pdf = strtoupper($namaUser . "_CERTIFICATE_" . $activity_name) . ".pdf";
        $paper = 'A4';
        $orientation = 'landscape';

        $path = 'assets/images/certificate_template.jpg';
        if ($template_link != null) {
            $path = $template_link;
        }
        
        $type = pathinfo($path, PATHINFO_EXTENSION);
        // $getImage = file_get_contents($path);
        
        $relativePath = parse_url($path, PHP_URL_PATH);
        $localPath = public_path($relativePath);
        $getImage = file_get_contents($localPath);

        $data['IMAGE'] = 'data:image/' . $type . ';base64,' . base64_encode($getImage);

        $path_hal2 = 'assets/images/template_sertifikat_hal2.jpg';
        if ($hal_2 != null) {
            $path_hal2 = $hal_2;
        }

        $type_hal2 = pathinfo($path_hal2, PATHINFO_EXTENSION);
        // $getImage_hal2 = file_get_contents($path_hal2);

        $relativePath_hal2 = parse_url($path_hal2, PHP_URL_PATH);
        $localPath_hal2 = public_path($relativePath_hal2);
        $getImage_hal2 = file_get_contents($localPath_hal2);

        $data['IMAGE_HAL_2'] = 'data:image/' . $type_hal2 . ';base64,' . base64_encode($getImage_hal2);

        
        $data['NAME'] = ucwords(strtolower(trim($namaUser)));
        $data['JUDUL'] = ucwords(strtolower(trim($activity_name)));
        $data['ROLES'] = strtoupper($role);
        $data['TGL_ACARA'] = $date;
        $data['TGL_TTD'] = strtoupper($date);
        $data['QR'] = base64_encode(QrCode::format("svg")->size(516)->generate(URL::to('/').'/verifikasi/sertifikat?ID_SERTIFIKAT='.$encryptedId));
        $totalJP = 0;

        $html1 = view('pdf_template.sertifikat', $data)->render();
        
        if ($type_activity == 2 && count($list_tema) > 0) 
            {
            $data['LIST_TEMA'] = $list_tema;

            foreach ($list_tema as $item) {
                $totalJP += (int) $item['JP'];
            }
            $data['TOTAL_JP'] = $totalJP." JAM";
            $html2 = view('pdf_template.sertifikat_webinar', $data)->render();
            $html = $html1 . $html2;
        } else {
            $html = $html1;
        }

        $resPdf = PDFGenerator::generate($html, $file_pdf, $paper, $orientation);
        $new_path = FileUpload::UploadFileBlob($file_pdf, $resPdf, 'certificate');

        return $new_path;
    }
}
