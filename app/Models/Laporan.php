<?php

namespace App\Models;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Laporan extends Model
{
    public function styling_title_template($ColorFill, $ColorText)
    {
        $styleTitle['font']['bold']                         = true;
        $styleTitle['font']['size']                         = 11;
        $styleTitle['font']['color']['argb']                = $ColorText;
        $styleTitle['fill']['fillType']                     = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID;
        $styleTitle['fill']['color']['argb']                = $ColorFill;
        $styleTitle['alignment']['horizontal']              = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT;
        $styleTitle['alignment']['vertical']                = \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER;

        return $styleTitle;
    }

    public function styling_content_template($ColorFill, $ColorText, $a_vertical, $a_horizontal)
    {
        $align_vertical = ($a_vertical == 'center') ?
            \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER : (
                ($a_vertical == 'bottom') ?
                \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM :
                \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
            );

        $align_horizontal = ($a_horizontal == 'center') ?
            \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER : (
                ($a_horizontal == 'left') ?
                \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT :
                \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
            );

        $styleContent['font']['size'] = 10;
        $styleContent['font']['color']['argb'] = $ColorText;
        $styleContent['fill']['fillType'] = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID;
        $styleContent['fill']['color']['argb'] = $ColorFill;
        $styleContent['borders']['outline']['borderStyle'] = \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN;
        $styleContent['alignment']['horizontal'] = $align_horizontal;
        $styleContent['alignment']['vertical'] = $align_vertical;

        return $styleContent;
    }
    
    public function laporan_event($data) {
        $spreadsheet = new Spreadsheet();

        $ObjSheet = $spreadsheet->getActiveSheet();
        $ObjSheet->setTitle("LAPORAN PESERTA WEBINAR");

        $ObjSheet->getColumnDimension('B')->setAutoSize(true);
        $ObjSheet->getColumnDimension('C')->setAutoSize(true);
        $ObjSheet->getColumnDimension('D')->setAutoSize(true);
        $ObjSheet->getColumnDimension('E')->setAutoSize(true);
        $ObjSheet->getColumnDimension('F')->setAutoSize(true);
        $ObjSheet->getColumnDimension('G')->setAutoSize(true);
        $ObjSheet->getColumnDimension('H')->setAutoSize(true);
        
        $ObjSheet->mergeCells('B2:H2')->setCellValue('B2', "DATA PESERTA WEBINAR/PELATIHAN")->getStyle('B2:H2')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'))->getFont()->setSize(14)->setUnderline(\PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE);
        $ObjSheet->mergeCells('B3:H3')->setCellValue('B3', $data[0]->TITLE_ACTIVITY)->getStyle('B3:H3')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'));

        $ObjSheet->setCellValue('B7', 'No')->getStyle('B7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('C7', 'Nama Peserta')->getStyle('C7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('D7', 'Email')->getStyle('D7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('E7', 'Nomor Telp')->getStyle('E7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('F7', 'Jenis Kelamin')->getStyle('F7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('G7', 'Alamat')->getStyle('G7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('H7', 'Tanggal Ambil')->getStyle('H7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));

        $rowStart = 8;
        foreach ($data as $key => $item) {
            $ObjSheet->setCellValue('B' . $rowStart, ($key + 1))->getStyle('B' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'center'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('C' . $rowStart, $item->NAME)->getStyle('C' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('D' . $rowStart, $item->EMAIL)->getStyle('D' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('E' . $rowStart, $item->TELP)->getStyle('E' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('F' . $rowStart, $item->JK)->getStyle('F' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('G' . $rowStart, $item->ALAMAT)->getStyle('G' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('H' . $rowStart, $item->LOG_TIME)->getStyle('H' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);

            $rowStart++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'Laporan Peserta Webinar/Pelatihan '.$data[0]->TITLE_ACTIVITY;
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function laporan_course($data) {
        $spreadsheet = new Spreadsheet();

        $ObjSheet = $spreadsheet->getActiveSheet();
        $ObjSheet->setTitle("LAPORAN PESERTA KURSUS");

        $ObjSheet->getColumnDimension('B')->setAutoSize(true);
        $ObjSheet->getColumnDimension('C')->setAutoSize(true);
        $ObjSheet->getColumnDimension('D')->setAutoSize(true);
        $ObjSheet->getColumnDimension('E')->setAutoSize(true);
        $ObjSheet->getColumnDimension('F')->setAutoSize(true);
        $ObjSheet->getColumnDimension('G')->setAutoSize(true);
        $ObjSheet->getColumnDimension('H')->setAutoSize(true);
        $ObjSheet->getColumnDimension('I')->setAutoSize(true);
        $ObjSheet->getColumnDimension('J')->setAutoSize(true);
        $ObjSheet->getColumnDimension('K')->setAutoSize(true);
        
        $ObjSheet->mergeCells('B2:K2')->setCellValue('B2', "DATA PESERTA KURSUS")->getStyle('B2:K2')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'))->getFont()->setSize(14)->setUnderline(\PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE);
        $ObjSheet->mergeCells('B3:K3')->setCellValue('B3', $data[0]->TITLE_ACTIVITY)->getStyle('B3:K3')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'));

        $ObjSheet->setCellValue('B7', 'No')->getStyle('B7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('C7', 'Nama Peserta')->getStyle('C7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('D7', 'Email')->getStyle('D7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('E7', 'Nomor Telp')->getStyle('E7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('F7', 'Jenis Kelamin')->getStyle('F7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('G7', 'Alamat')->getStyle('G7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('H7', 'Tanggal Ambil')->getStyle('H7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('I7', 'Status')->getStyle('I7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('J7', 'Nilai')->getStyle('J7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('K7', 'Tanggal Selesai')->getStyle('K7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));

        $rowStart = 8;
        foreach ($data as $key => $item) {
            $ObjSheet->setCellValue('B' . $rowStart, ($key + 1))->getStyle('B' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'center'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('C' . $rowStart, $item->NAME)->getStyle('C' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('D' . $rowStart, $item->EMAIL)->getStyle('D' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('E' . $rowStart, (empty($item->TELP) ? "Belum Mengisi" : $item->TELP))->getStyle('E' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('F' . $rowStart, (empty($item->JK) ? "Belum Mengisi" : $item->JK))->getStyle('F' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('G' . $rowStart, (empty($item->ALAMAT) ? "Belum Mengisi" : $item->ALAMAT))->getStyle('G' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('H' . $rowStart, $item->LOG_TIME)->getStyle('H' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('I' . $rowStart, ($item->PROGRESS == 100 ? "Selesai" : $item->PROGRESS."%"))->getStyle('I' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('J' . $rowStart, (empty($item->Rata_Nilai) ? "Belum Mengerjakan" : $item->Rata_Nilai))->getStyle('J' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('K' . $rowStart, (empty($item->DATE_COMPLETED) ? "Belum Selesai" : $item->DATE_COMPLETED))->getStyle('K' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);

            $rowStart++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'Laporan Peserta Kursus '.$data[0]->TITLE_ACTIVITY;
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function laporan_ukm($data){
        set_time_limit(300);

        $spreadsheet = new Spreadsheet();

        $ObjSheet = $spreadsheet->getActiveSheet();
        $ObjSheet->setTitle("LAPORAN PESERTA UKM");

        $ObjSheet->getColumnDimension('B')->setAutoSize(true);
        $ObjSheet->getColumnDimension('C')->setWidth(18);
        $ObjSheet->getColumnDimension('D')->setWidth(40);
        $ObjSheet->getColumnDimension('E')->setWidth(37);
        $ObjSheet->getColumnDimension('F')->setWidth(18);
        $ObjSheet->getColumnDimension('G')->setWidth(20);
        $ObjSheet->getColumnDimension('H')->setWidth(57);
        $ObjSheet->getColumnDimension('I')->setWidth(29);
        $ObjSheet->getColumnDimension('J')->setWidth(24);
        $ObjSheet->getColumnDimension('K')->setWidth(20);
        $ObjSheet->getColumnDimension('L')->setWidth(18);
        $ObjSheet->getColumnDimension('M')->setWidth(31);
        $ObjSheet->getColumnDimension('N')->setWidth(25);
        $ObjSheet->getColumnDimension('O')->setWidth(25);
        $ObjSheet->getColumnDimension('P')->setWidth(25);
        $ObjSheet->getColumnDimension('Q')->setWidth(25);
        $ObjSheet->getColumnDimension('R')->setWidth(31);
        $ObjSheet->getColumnDimension('S')->setWidth(24);
        $ObjSheet->getColumnDimension('T')->setWidth(35);
        $ObjSheet->getColumnDimension('U')->setWidth(57);
        $ObjSheet->getColumnDimension('V')->setWidth(24);
        $ObjSheet->getColumnDimension('W')->setWidth(20);
        $ObjSheet->getColumnDimension('X')->setWidth(42);
        $ObjSheet->getColumnDimension('Y')->setWidth(42);
        $ObjSheet->getColumnDimension('Z')->setWidth(25);
        $ObjSheet->getColumnDimension('AA')->setWidth(13);
        $ObjSheet->getColumnDimension('AB')->setWidth(17);
        $ObjSheet->getColumnDimension('AC')->setWidth(14);
        $ObjSheet->getColumnDimension('AD')->setWidth(14);
        $ObjSheet->getColumnDimension('AE')->setWidth(14);
        $ObjSheet->getColumnDimension('AF')->setWidth(14);
        $ObjSheet->getColumnDimension('AG')->setWidth(37);
        $ObjSheet->getColumnDimension('AH')->setWidth(17);
        $ObjSheet->getColumnDimension('AI')->setWidth(14);

        $ObjSheet->freezePane('A5');
        
        $ObjSheet->mergeCells('B2:K2')->setCellValue('B2', "DATA PESERTA (UKM)")->getStyle('B2:K2')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'))->getFont()->setSize(14)->setUnderline(\PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE);

        $ObjSheet->setCellValue('B4', 'No')->getStyle('B4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('C4', 'NIK Peserta')->getStyle('C4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('D4', 'Nama Peserta')->getStyle('D4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('E4', 'Email Peserta')->getStyle('E4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('F4', 'No Telepon Peserta')->getStyle('F4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('G4', 'Jenis Kelamin Peserta')->getStyle('G4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('H4', 'Alamat Peserta')->getStyle('H4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('I4', 'Jabatan Peserta')->getStyle('I4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('J4', 'Asal Kota Peserta')->getStyle('J4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('K4', 'Asal Provinsi Peserta')->getStyle('K4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('L4', 'NIK Pemilik UKM')->getStyle('L4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('M4', 'Nama Pemilik UKM')->getStyle('M4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('N4', 'Status NPWP Pemilik UKM')->getStyle('N4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('O4', 'Tempat Lahir Pemilik UKM')->getStyle('O4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('P4', 'Tanggal Lahir Pemilik UKM')->getStyle('P4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('Q4', 'Jenis Kelamin Pemilik UKM')->getStyle('Q4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('R4', 'Pendidikan Terakhir Pemilik UKM')->getStyle('R4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('S4', 'No Telepon Pemilik UKM')->getStyle('S4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('T4', 'Nama UKM')->getStyle('T4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('U4', 'Alamat UKM')->getStyle('U4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('V4', 'Kota UKM')->getStyle('V4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('W4', 'Provinsi UKM')->getStyle('W4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('X4', 'Kegiatan Usaha')->getStyle('X4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('Y4', 'Produk Dihasilkan')->getStyle('Y4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('Z4', 'Kategori UKM ')->getStyle('Z4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AA4', 'Tahun Mulai')->getStyle('AA4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AB4', 'Kapasitas Produksi')->getStyle('AB4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AC4', 'Volume Usaha')->getStyle('AC4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AD4', 'Tenaga Pria')->getStyle('AD4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AE4', 'Tenaga Wanita')->getStyle('AE4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AF4', 'Badan Usaha')->getStyle('AF4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AG4', 'Lokasi Pemasaran')->getStyle('AG4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AH4', 'Nilai Realisasi')->getStyle('AH4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AI4', 'Tahun Realisasi')->getStyle('AI4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));

        $rowStart = 5;
        foreach ($data as $key => $item) {
            $ObjSheet->setCellValue('B' . $rowStart, ($key + 1))->getStyle('B' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('C' . $rowStart, $item->NIK)->getStyle('C' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('D' . $rowStart, $item->NAME)->getStyle('D' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('E' . $rowStart, (empty($item->EMAIL) ? "Belum Mengisi" : $item->EMAIL))->getStyle('E' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('F' . $rowStart, (empty($item->TELP) ? "Belum Mengisi" : $item->TELP))->getStyle('F' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('G' . $rowStart, (empty($item->JK) ? "Belum Mengisi" : $item->JK))->getStyle('G' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('H' . $rowStart, (empty($item->ALAMAT) ? "Belum Mengisi" : $item->ALAMAT))->getStyle('H' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('I' . $rowStart, (empty($item->JABATAN) ? "Belum Mengisi" : $item->JABATAN))->getStyle('I' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('J' . $rowStart, (empty($item->nama_kota_peserta) ? "Belum Mengisi" : $item->nama_kota_peserta))->getStyle('J' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('K' . $rowStart, (empty($item->nama_provinsi_peserta) ? "Belum Mengisi" : $item->nama_provinsi_peserta))->getStyle('K' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('L' . $rowStart, (empty($item->nik_pemilik) ? "Belum Mengisi" : $item->nik_pemilik))->getStyle('L' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('M' . $rowStart, (empty($item->nama_pemilik) ? "Belum Mengisi" : $item->nama_pemilik))->getStyle('M' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('N' . $rowStart, ($item->npwp == 0 ? "Tidak ada" : "Ada"))->getStyle('N' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('O' . $rowStart, (empty($item->tempat_lahir_pemilik) ? "Belum Mengisi" : $item->tempat_lahir_pemilik))->getStyle('O' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('P' . $rowStart, (empty($item->tanggal_lahir_pemilik) ? "Belum Mengisi" : $item->tanggal_lahir_pemilik))->getStyle('P' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('Q' . $rowStart, (empty($item->jenis_kelamin_pemilik) ? "Belum Mengisi" : $item->jenis_kelamin_pemilik))->getStyle('Q' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('R' . $rowStart, (empty($item->pendidikan_terakhir_pemilik) ? "Belum Mengisi" : $item->pendidikan_terakhir_pemilik))->getStyle('R' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('S' . $rowStart, (empty($item->phone_pemilik) ? "Belum Mengisi" : $item->phone_pemilik))->getStyle('S' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('T' . $rowStart, (empty($item->nama_ukm) ? "Belum Mengisi" : $item->nama_ukm))->getStyle('T' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('U' . $rowStart, (empty($item->alamat_ukm) ? "Belum Mengisi" : $item->alamat_ukm))->getStyle('U' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('V' . $rowStart, (empty($item->nama_kota_pemilik) ? "Belum Mengisi" : $item->nama_kota_pemilik))->getStyle('V' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('W' . $rowStart, (empty($item->nama_provinsi_pemilik) ? "Belum Mengisi" : $item->nama_provinsi_pemilik))->getStyle('W' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('X' . $rowStart, (empty($item->kegiatan_usaha) ? "Belum Mengisi" : $item->kegiatan_usaha))->getStyle('X' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('Y' . $rowStart, (empty($item->produk_dihasilkan) ? "Belum Mengisi" : $item->produk_dihasilkan))->getStyle('Y' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('Z' . $rowStart, (empty($item->NAMA_KATEGORI_UKM) ? "Belum Mengisi" : $item->NAMA_KATEGORI_UKM))->getStyle('Z' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('AA' . $rowStart, (empty($item->tahun_mulai) ? "Belum Mengisi" : $item->tahun_mulai))->getStyle('AA' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AB' . $rowStart, (empty($item->kapasitas_produksi) ? "Belum Mengisi" : $item->kapasitas_produksi))->getStyle('AB' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AC' . $rowStart, (empty($item->volume_usaha) ? "Belum Mengisi" : $item->volume_usaha))->getStyle('AC' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AD' . $rowStart, (empty($item->tenaga_pria) ? "Belum Mengisi" : $item->tenaga_pria))->getStyle('AD' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AE' . $rowStart, ($item->tenaga_wanita === NULL ? "Belum Mengisi" : $item->tenaga_wanita))->getStyle('AE' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AF' . $rowStart, (empty($item->NAMA_BADAN_USAHA) ? "Belum Mengisi" : $item->NAMA_BADAN_USAHA))->getStyle('AF' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AG' . $rowStart, (empty($item->lokasi_pemasaran) ? "Belum Mengisi" : $item->lokasi_pemasaran))->getStyle('AG' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('AH' . $rowStart, (empty($item->nilai_realisasi) ? "Belum Mengisi" : $item->nilai_realisasi))->getStyle('AH' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AI' . $rowStart, (empty($item->tahun_realisasi) ? "Belum Mengisi" : $item->tahun_realisasi))->getStyle('AI' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);

            $ObjSheet->getStyle('C' . $rowStart)->getNumberFormat()->setFormatCode('0');
            $ObjSheet->getStyle('F' . $rowStart)->getNumberFormat()->setFormatCode('0');
            $ObjSheet->getStyle('L' . $rowStart)->getNumberFormat()->setFormatCode('0');

            $rowStart++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'Laporan Peserta UKM';
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function laporan_koperasi($data)
    {
        set_time_limit(300);
        $spreadsheet = new Spreadsheet();

        $ObjSheet = $spreadsheet->getActiveSheet();
        $ObjSheet->setTitle("LAPORAN PESERTA Koperasi");

        $ObjSheet->getColumnDimension('C')->setWidth(18);
        $ObjSheet->getColumnDimension('D')->setWidth(40);
        $ObjSheet->getColumnDimension('E')->setWidth(37);
        $ObjSheet->getColumnDimension('F')->setWidth(18);
        $ObjSheet->getColumnDimension('G')->setWidth(20);
        $ObjSheet->getColumnDimension('H')->setWidth(57);
        $ObjSheet->getColumnDimension('I')->setWidth(29);
        $ObjSheet->getColumnDimension('J')->setWidth(24);
        $ObjSheet->getColumnDimension('K')->setWidth(20);
        $ObjSheet->getColumnDimension('L')->setAutoSize(true);
        $ObjSheet->getColumnDimension('M')->setWidth(45);
        $ObjSheet->getColumnDimension('N')->setWidth(35);
        $ObjSheet->getColumnDimension('O')->setAutoSize(true);
        $ObjSheet->getColumnDimension('P')->setAutoSize(true);
        $ObjSheet->getColumnDimension('Q')->setAutoSize(true);
        $ObjSheet->getColumnDimension('R')->setAutoSize(true);
        $ObjSheet->getColumnDimension('S')->setAutoSize(true);
        $ObjSheet->getColumnDimension('T')->setAutoSize(true);
        $ObjSheet->getColumnDimension('U')->setAutoSize(true);
        $ObjSheet->getColumnDimension('V')->setAutoSize(true);
        $ObjSheet->getColumnDimension('W')->setAutoSize(true);
        $ObjSheet->getColumnDimension('X')->setAutoSize(true);
        $ObjSheet->getColumnDimension('Y')->setAutoSize(true);
        $ObjSheet->getColumnDimension('Z')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AA')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AB')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AC')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AD')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AE')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AF')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AG')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AH')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AI')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AJ')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AK')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AL')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AM')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AN')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AO')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AP')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AQ')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AR')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AS')->setAutoSize(true);
        $ObjSheet->getColumnDimension('AT')->setAutoSize(true);

        $ObjSheet->freezePane('A5');
        
        $ObjSheet->mergeCells('B2:K2')->setCellValue('B2', "DATA PESERTA (Koperasi)")->getStyle('B2:K2')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'))->getFont()->setSize(14)->setUnderline(\PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE);

        $ObjSheet->setCellValue('B4', 'No')->getStyle('B4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('C4', 'NIK Peserta')->getStyle('C4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('D4', 'Nama Peserta')->getStyle('D4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('E4', 'Email Peserta')->getStyle('E4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('F4', 'No Telepon Peserta')->getStyle('F4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('G4', 'Jenis Kelamin Peserta')->getStyle('G4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('H4', 'Alamat Peserta')->getStyle('H4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('I4', 'Jabatan Peserta')->getStyle('I4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('J4', 'Asal Kota Peserta')->getStyle('J4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('K4', 'Asal Provinsi Peserta')->getStyle('K4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('L4', 'NIK Koperasi')->getStyle('L4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('M4', 'Nama Koperasi')->getStyle('M4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('N4', 'No Badan Hukum')->getStyle('N4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('O4', 'Tanggal Badan Hukum')->getStyle('O4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('P4', 'Alamat Koperasi')->getStyle('P4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('Q4', 'Kota')->getStyle('Q4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('R4', 'Provinsi')->getStyle('R4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('S4', 'No Telepon')->getStyle('S4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('T4', 'No PAD')->getStyle('T4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('U4', 'Tanggal PAD')->getStyle('U4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('V4', 'Status Koperasi')->getStyle('V4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('W4', 'Cabang')->getStyle('W4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('X4', 'Tanggal RAT')->getStyle('X4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('Y4', 'Nama Ketua')->getStyle('Y4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('Z4', 'No Telepon Ketua')->getStyle('Z4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AA4', 'Nama Sekretaris')->getStyle('AA4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AB4', 'No Telepon Sekretaris')->getStyle('AB4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AC4', 'Nama Bendahara')->getStyle('AC4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AD4', 'No Telepon Bendahara')->getStyle('AD4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AE4', 'Anggota Pria')->getStyle('AE4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AF4', 'Anggota Wanita')->getStyle('AF4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AG4', 'Manager Pria')->getStyle('AG4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AH4', 'Manager Wanita')->getStyle('AH4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AI4', 'Karyawan Pria')->getStyle('AI4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AJ4', 'Karyawan Wanita')->getStyle('AJ4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AK4', 'Bentuk Koperasi')->getStyle('AK4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AL4', 'Jenis Koperasi')->getStyle('AL4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AM4', 'Kelompok Koperasi')->getStyle('AM4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AN4', 'Sektor Usaha')->getStyle('AN4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AO4', 'Volume Usaha')->getStyle('AO4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AP4', 'Asset')->getStyle('AP4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AQ4', 'Unit Usaha')->getStyle('AQ4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AR4', 'Modal Sendiri')->getStyle('AR4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AS4', 'Modal Luar')->getStyle('AS4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('AT4', 'Sisa Hasil Usaha')->getStyle('AT4')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));

        $rowStart = 5;
        foreach ($data as $key => $item) {
            $ObjSheet->setCellValue('B' . $rowStart, ($key + 1))->getStyle('B' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('C' . $rowStart, $item->NIK)->getStyle('C' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('D' . $rowStart, $item->NAME)->getStyle('D' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('E' . $rowStart, (empty($item->EMAIL) ? "Belum Mengisi" : $item->EMAIL))->getStyle('E' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('F' . $rowStart, (empty($item->TELP) ? "Belum Mengisi" : $item->TELP))->getStyle('F' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('G' . $rowStart, ($item->JK == "P" ? "Perempuan" : ($item->JK == "L" ? "Laki Laki" : "Belum Mengisi")))->getStyle('G' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('H' . $rowStart, (empty($item->ALAMAT) ? "Belum Mengisi" : $item->ALAMAT))->getStyle('H' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('I' . $rowStart, (empty($item->JABATAN) ? "Belum Mengisi" : $item->JABATAN))->getStyle('I' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(true);
            $ObjSheet->setCellValue('J' . $rowStart, (empty($item->nama_kota_peserta) ? "Belum Mengisi" : $item->nama_kota_peserta))->getStyle('J' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('K' . $rowStart, (empty($item->nama_provinsi_peserta) ? "Belum Mengisi" : $item->nama_provinsi_peserta))->getStyle('K' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('L' . $rowStart, (empty($item->nik) ? "Belum Mengisi" : $item->nik))->getStyle('L' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('M' . $rowStart, (empty($item->nm_koperasi) ? "Belum Mengisi" : $item->nm_koperasi))->getStyle('M' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('N' . $rowStart, (empty($item->no_badan_hukum) ? "Belum Mengisi" : $item->no_badan_hukum))->getStyle('N' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('O' . $rowStart, (empty($item->tgl_badan_hukum) ? "Belum Mengisi" : $this->formatTanggalIndonesia($item->tgl_badan_hukum)))->getStyle('O' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('P' . $rowStart, (empty($item->alamat_koperasi) ? "Belum Mengisi" : $item->alamat_koperasi))->getStyle('P' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('Q' . $rowStart, (empty($item->nama_kota_koperasi) ? "Belum Mengisi" : $item->nama_kota_koperasi))->getStyle('Q' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('R' . $rowStart, (empty($item->nama_provinsi_koperasi) ? "Belum Mengisi" : $item->nama_provinsi_koperasi))->getStyle('R' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('S' . $rowStart, (empty($item->phone) ? "Belum Mengisi" : $item->phone))->getStyle('S' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('T' . $rowStart, (empty($item->no_pad) ? "Belum Mengisi" : $item->no_pad))->getStyle('T' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('U' . $rowStart, (empty($item->tgl_pad) ? "Belum Mengisi" : $this->formatTanggalIndonesia($item->tgl_pad)))->getStyle('U' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('V' . $rowStart, ($item->status == 1 ? "Aktif" : "Tidak Aktif"))->getStyle('V' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('W' . $rowStart, (empty($item->cabang) ? "Belum Mengisi" : $item->cabang))->getStyle('W' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('X' . $rowStart, (empty($item->tgl_rat) ? "Belum Mengisi" : $this->formatTanggalIndonesia($item->tgl_rat)))->getStyle('X' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('Y' . $rowStart, (empty($item->nm_ketua) ? "Belum Mengisi" : $item->nm_ketua))->getStyle('Y' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('Z' . $rowStart, (empty($item->phone_ketua) ? "Belum Mengisi" : $item->phone_ketua))->getStyle('Z' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AA' . $rowStart, (empty($item->nm_sekretaris) ? "Belum Mengisi" : $item->nm_sekretaris))->getStyle('AA' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AB' . $rowStart, (empty($item->phone_sekretaris) ? "Belum Mengisi" : $item->phone_sekretaris))->getStyle('AB' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AC' . $rowStart, (empty($item->nm_bendahara) ? "Belum Mengisi" : $item->nm_bendahara))->getStyle('AC' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AD' . $rowStart, (empty($item->phone_bendahara) ? "Belum Mengisi" : $item->phone_bendahara))->getStyle('AD' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AE' . $rowStart, ($item->anggota_pria !== NULL ? "Belum Mengisi" : $item->anggota_pria))->getStyle('AE' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AF' . $rowStart, ($item->anggota_wanita !== NULL) ? "Belum Mengisi" : $item->anggota_wanita))->getStyle('AF' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AG' . $rowStart, ($item->manager_pria !== NULL) ? "Belum Mengisi" : $item->manager_pria))->getStyle('AG' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AH' . $rowStart, ($item->manager_wanita !== NULL) ? "Belum Mengisi" : $item->manager_wanita))->getStyle('AH' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AI' . $rowStart, ($item->karyawan_pria !== NULL) ? "Belum Mengisi" : $item->karyawan_pria))->getStyle('AI' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AJ' . $rowStart, ($item->karyawan_wanita !== NULL) ? "Belum Mengisi" : $item->karyawan_wanita))->getStyle('AJ' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AK' . $rowStart, (empty($item->NAMA_BENTUK_KOPERASI) ? "Belum Mengisi" : $item->NAMA_BENTUK_KOPERASI))->getStyle('AK' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AL' . $rowStart, (empty($item->NAMA_JENIS_KOPERASI) ? "Belum Mengisi" : $item->NAMA_JENIS_KOPERASI))->getStyle('AL' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AM' . $rowStart, (empty($item->NAMA_KELOMPOK_KOPERASI) ? "Belum Mengisi" : $item->NAMA_KELOMPOK_KOPERASI))->getStyle('AM' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AN' . $rowStart, (empty($item->NAMA_SEKTOR_USAHA) ? "Belum Mengisi" : $item->NAMA_SEKTOR_USAHA))->getStyle('AN' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AO' . $rowStart, (empty($item->volume_usaha) ? "Belum Mengisi" : $item->volume_usaha))->getStyle('AO' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AP' . $rowStart, (empty($item->asset) ? "Belum Mengisi" : $item->asset))->getStyle('AP' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AQ' . $rowStart, (empty($item->NAMA_UNIT_USAHA) ? "Belum Mengisi" : $item->NAMA_UNIT_USAHA))->getStyle('AQ' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AR' . $rowStart, (empty($item->modal_sendiri) ? "Belum Mengisi" : $item->modal_sendiri))->getStyle('AR' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AS' . $rowStart, (empty($item->modal_luar) ? "Belum Mengisi" : $item->modal_luar))->getStyle('AS' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('AT' . $rowStart, (empty($item->sisa_hasil_usaha) ? "Belum Mengisi" : $item->sisa_hasil_usaha))->getStyle('AT' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);

            $ObjSheet->getStyle('C' . $rowStart)->getNumberFormat()->setFormatCode('0');
            $ObjSheet->getStyle('F' . $rowStart)->getNumberFormat()->setFormatCode('0');
            $ObjSheet->getStyle('L' . $rowStart)->getNumberFormat()->setFormatCode('0');
            $ObjSheet->getStyle('Z' . $rowStart)->getNumberFormat()->setFormatCode('0');
            $ObjSheet->getStyle('AB' . $rowStart)->getNumberFormat()->setFormatCode('0');
            $ObjSheet->getStyle('AD' . $rowStart)->getNumberFormat()->setFormatCode('0');
            $ObjSheet->getStyle('AO' . $rowStart)->getNumberFormat()->setFormatCode('Rp #,##0');
            $ObjSheet->getStyle('AP' . $rowStart)->getNumberFormat()->setFormatCode('Rp #,##0');
            $ObjSheet->getStyle('AR' . $rowStart)->getNumberFormat()->setFormatCode('Rp #,##0');
            $ObjSheet->getStyle('AS' . $rowStart)->getNumberFormat()->setFormatCode('Rp #,##0');
            $ObjSheet->getStyle('AT' . $rowStart)->getNumberFormat()->setFormatCode('Rp #,##0');


            $rowStart++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'Laporan Peserta Koperasi';
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    private function formatTanggalIndonesia($tanggal)
    {
        try {
            $date = new DateTime($tanggal);
            $formattedDate = $date->format('d F Y');

            $date = new DateTime($tanggal);
            $formattedDate = $date->format('d F Y');
            $monthInIndonesian = [
                'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
                'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli',
                'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober',
                'November' => 'November', 'December' => 'Desember'
            ];
            return str_replace(array_keys($monthInIndonesian), array_values($monthInIndonesian), $formattedDate);   
        } catch (Exception $e) {
            return "Belum mengisi";
        }
    }   
}
