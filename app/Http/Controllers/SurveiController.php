<?php

namespace App\Http\Controllers;

use App\Models\Checkbox;
use Illuminate\Http\Request;
use App\Models\SurveiMaster as Survei;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurveiController extends Controller
{
    public function index()
    {
        $data['title'] = "Badan Usaha";

        $survei = Survei::with('checkbox')
            ->whereNull('DELETED_AT')
            ->get();

        return view('template.header', $data) .
            view('template_admin.master_data.survei.survei', compact('survei')) .
            view('template.footer', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:rating,checkbox,komentar',
            'text' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $survei = Survei::create([
                'KATEGORI'   => $request->kategori,
                'TEXT'       => $request->text,
                'CREATED_AT' => now(),
                'CREATED_BY' => session('NAMA_USER')
            ]);

            // checkbox
            if ($request->kategori == 'checkbox' && is_array($request->checkbox)) {
                foreach ($request->checkbox as $val) {
                    if (!empty(trim($val))) {
                        Checkbox::create([
                            'ID_SURVEI' => $survei->ID_SURVEI,
                            'VALUE'     => $val
                        ]);
                    }
                }
            }

            DB::commit();
            return back()->with('success', 'Berhasil tambah');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('STORE SURVEI: ' . $e->getMessage());

            return back()->with('error', 'Gagal tambah');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_survei' => 'required',
            'kategori'  => 'required|in:rating,checkbox,komentar',
            'text'      => 'required'
        ]);

        DB::beginTransaction();
        try {
            $survei = Survei::find($request->id_survei);

            if (!$survei) {
                return back()->with('error', 'Data tidak ditemukan');
            }

            $survei->update([
                'KATEGORI'   => $request->kategori,
                'TEXT'       => $request->text,
                'UPDATED_AT' => now(),
                'UPDATED_BY' => session('NAMA_USER')
            ]);

            // hapus checkbox lama
            Checkbox::where('ID_SURVEI', $survei->ID_SURVEI)->delete();

            // insert ulang jika checkbox
            if ($request->kategori == 'checkbox' && is_array($request->checkbox)) {
                foreach ($request->checkbox as $val) {
                    if (!empty(trim($val))) {
                        Checkbox::create([
                            'ID_SURVEI' => $survei->ID_SURVEI,
                            'VALUE'     => $val
                        ]);
                    }
                }
            }

            DB::commit();
            return back()->with('success', 'Berhasil update');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('UPDATE SURVEI: ' . $e->getMessage());

            return back()->with('error', 'Gagal update');
        }
    }

    public function delete(Request $request)
    {
        try {
            $survei = Survei::find($request->id_survei);

            if (!$survei) {
                return back()->with('error', 'Data tidak ditemukan');
            }

            $survei->update([
                'DELETED_AT' => now(),
                'DELETED_BY' => session('NAMA_USER')
            ]);

            return back()->with('success', 'Berhasil hapus');
        } catch (\Exception $e) {
            Log::error('DELETE SURVEI: ' . $e->getMessage());

            return back()->with('error', 'Gagal hapus');
        }
    }

    public function submitSurvei(Request $request)
    {
        $request->validate([
            'id_activity' => 'required',
            'id_user'     => 'required'
        ]);

        DB::beginTransaction();
        try {
            $idUser     = $request->id_user;
            $idActivity = $request->id_activity;

            $cek = DB::table('tb_survei_rating')
                ->where('ID_USER', $idUser)
                ->where('ID_ACTIVITY', $idActivity)
                ->exists();

            if ($cek) {
                return back()->with('error', 'Anda sudah mengisi survei');
            }

            // ================= RATING =================
            if ($request->rating && is_array($request->rating)) {
                foreach ($request->rating as $id_survei => $value) {
                    if (!is_null($value)) {
                        DB::table('tb_survei_rating')->insert([
                            'ID_SURVEI'   => $id_survei,
                            'ID_USER'     => $idUser,
                            'ID_ACTIVITY' => $idActivity,
                            'RATING'      => $value
                        ]);
                    }
                }
            }

            // ================= CHECKBOX =================
            if ($request->checkbox && is_array($request->checkbox)) {
                foreach ($request->checkbox as $id_survei => $values) {
                    if (is_array($values)) {
                        foreach ($values as $id_checkbox) {

                            DB::table('tb_survei_checkbox')->insert([
                                'ID_SURVEI'   => $id_survei,
                                'ID_USER'     => $idUser,
                                'ID_ACTIVITY' => $idActivity,
                                'ID_CHECKBOX' => $id_checkbox
                            ]);
                        }
                    }
                }
            }

            // ================= KOMENTAR =================
            if ($request->komentar && is_array($request->komentar)) {
                foreach ($request->komentar as $id_survei => $text) {
                    if (!empty(trim($text))) {
                        DB::table('tb_survei_komentar')->insert([
                            'ID_SURVEI'   => $id_survei,
                            'ID_USER'     => $idUser,
                            'ID_ACTIVITY' => $idActivity,
                            'TEXT'        => $text
                        ]);
                    }
                }
            }

            DB::commit();

            return back()->with('success', 'Terima kasih, survei berhasil dikirim');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SUBMIT SURVEI: ' . $e->getMessage());

            return back()->with('error', 'Gagal mengirim survei');
        }
    }
}
