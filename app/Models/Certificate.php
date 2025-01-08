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

    public function generate($namaUser, $activity_name, $sertificate_no, $template_link, $role, $date, $id_sertif)
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
        $getImage = file_get_contents($path);
        $data['IMAGE'] = 'data:image/' . $type . ';base64,' . base64_encode($getImage);
        
        $data['NAME'] = ucwords(strtolower(trim($namaUser)));
        $data['JUDUL'] = ucwords(strtolower(trim($activity_name)));
        $data['ROLES'] = strtoupper($role); //PESERTA
        $data['TGL_ACARA'] = $date; //25 Oktober 2024
        $data['TGL_TTD'] = strtoupper($date); //MALANG, 25 OKTOBER 2024
        $data['QR'] = base64_encode(QrCode::format("svg")->size(516)->generate(URL::to('/').'/verifikasi/sertifikat?ID_SERTIFIKAT='.$encryptedId));
        
        $html = view('pdf_template.sertifikat', $data)->render();
        $resPdf = PDFGenerator::generate($html, $file_pdf, $paper, $orientation);
        $new_path = FileUpload::UploadFileBlob($file_pdf, $resPdf, 'certificate');

        return $new_path;
    }
}
