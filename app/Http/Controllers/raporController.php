<?php

namespace App\Http\Controllers;

use App\Models\nilai_akhir;
use App\Models\smt;
use App\Models\kep;
use Carbon\Carbon;
use App\Models\siswa;
use App\Models\Kelas;
use App\Models\mapels;
use App\Models\trx_absen;
use App\Models\mst_siswa;
use App\Models\MapelKelas;
use App\Models\trx_nilai;
use App\Models\SIA;
use App\Models\ta;
use App\Models\wali;
use App\Models\tgl_rapor;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class raporController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('rapor.Ckelas');
    }

    public function showSiswa(Request $request)
    {
        $ta = ta::where('aktif', 1)->first();
        $nilai = trx_nilai::select('nis')->with('siswa')->where([
            ['kelas_id', $request->kelas],
            ['smt', $request->smt],
            ['tas_id', $ta->id],
        ])->distinct('nis')->get()->sortBy('siswa.nama');
//        dd($nilai);
//        $siswas = mst_siswa::where([
//            ['kls', $request->kelas],
//            ['flag', 1]
//        ])->get();

        return view('rapor.show', compact('nilai'));
    }

    public function cover($nis)
    {

        $siswa = siswa::where([
            ['nis', $nis],
            ['flag', 1]
        ])->first();

        return view('rapor.cover', compact('siswa'));
    }

    public function petunjuk()
    {
        return view('rapor.petunjuk');
    }

    public function nilai($nis)
    {
        $smt = smt::where('flag', 1)->first();
        $tgl = tgl_rapor::orderBy('id', "desc")->first();

        $siswa = mst_siswa::where('nis', $nis)->first();
        $kls = mst_siswa::select('kls')->where('nis', $nis)->first();
        if ($smt->smt % 2 === 0) {
            $ta = ta::where('aktif', 1)->first();
            $smt = smt::where('flag', 1)->first();
            $siswa = mst_siswa::where('nis', $nis)->first();
            $kls = mst_siswa::select('kls')->where('nis', $nis)->first();
            $jum_siswa = mst_siswa::where('kls', $siswa->kls)->count();

            $mapel = MapelKelas::where([
                ['kelas_id', $kls->kls],
                ['smt', $smt->smt]
            ])->get();

            $nilai = trx_nilai::where([
                ['nis', $nis],
                ['smt', $smt->smt],
                ['tas_id', $ta->id]
            ])->get();

            $rata = trx_nilai::where([
                ['smt', $smt->smt],
                ['kelas_id', $kls->kls],
                ['tas_id', $ta->id]
            ])->get();

            $rataAnak = trx_nilai::where([
                ['smt', $smt->smt],
                ['kelas_id', $kls->kls],
                ['nis', $nis],
                ['tas_id', $ta->id]
            ])->avg('nilai');

            $kep = kep::where([
                ['kelas_id', $kls->kls],
                ['nis', $nis],
                ['smt', $smt->id],
                ['tas_id', $ta->id]
            ])->first();

            $total = trx_nilai::select('nilai', 'mapel_id')->where([
                ['nis', $nis],
                ['smt', $smt->id],
                ['tas_id', $ta->id]
            ])->sum('nilai');

            $totalRata = trx_nilai::select('nilai')->where([
                ['kelas_id', $kls->kls],
                ['smt', $smt->smt],
                ['tas_id', $ta->id]
            ])->avg('nilai');

            $sakit = SIA::select('sakit')->where([
                ['nis', $nis],
                ['smt_id', $smt->id],
                ['tas_id', $ta->id]
            ])->sum('sakit');

            $ijin = SIA::select('ijin')->where([
                ['nis', $nis],
                ['smt_id', $smt->id],
                ['tas_id', $ta->id]
            ])->sum('ijin');

            $alpa = SIA::select('alpha')->where([
                ['nis', $nis],
                ['smt_id', $smt->id],
                ['tas_id', $ta->id]
            ])->sum('alpha');

            $wali = wali::where('kelas_id', $kls->kls)->first();
            $na = nilai_akhir::where([
                'nis' => $nis,
                'tas_id' => $ta->id,
                "smt" => $smt->id
            ])->first();

            return view('rapor.nilai2', compact('wali','mapel', 'nilai', 'rata', 'smt', 'siswa', 'total', 'totalRata', 'kep', 'sakit', 'ijin', 'alpa', 'rataAnak', 'tgl', 'na', 'jum_siswa'));
        } else {
            $ta = ta::where('aktif', 1)->first();
            $smt = smt::where('flag', 1)->first();
            $siswa = mst_siswa::where('nis', $nis)->first();
            $kls = mst_siswa::select('kls')->where('nis', $nis)->first();
            $jum_siswa = mst_siswa::where('kls', $siswa->kls)->count();

            $mapel = MapelKelas::where([
                ['kelas_id', $kls->kls],
                ['smt', $smt->smt]
            ])->get();

            $nilai = trx_nilai::where([
                ['nis', $nis],
                ['smt', $smt->smt],
                ['tas_id', $ta->id]
            ])->get();

            $rata = trx_nilai::where([
                ['smt', $smt->smt],
                ['kelas_id', $kls->kls],
                ['tas_id', $ta->id]
            ])->get();

            $rataAnak = trx_nilai::where([
                ['smt', $smt->smt],
                ['kelas_id', $kls->kls],
                ['nis', $nis],
                ['tas_id', $ta->id]
            ])->avg('nilai');

            $kep = kep::where([
                ['kelas_id', $kls->kls],
                ['nis', $nis],
                ['smt', $smt->id],
                ['tas_id', $ta->id]
            ])->first();

            $total = trx_nilai::select('nilai', 'mapel_id')->where([
                ['nis', $nis],
                ['smt', $smt->id],
                ['tas_id', $ta->id]
            ])->sum('nilai');

            $totalRata = trx_nilai::select('nilai')->where([
                ['kelas_id', $kls->kls],
                ['smt', $smt->smt],
                ['tas_id', $ta->id]
            ])->avg('nilai');

            $sakit = SIA::select('sakit')->where([
                ['nis', $nis],
                ['smt_id', $smt->id],
                ['tas_id', $ta->id]
            ])->sum('sakit');

            $ijin = SIA::select('ijin')->where([
                ['nis', $nis],
                ['smt_id', $smt->id],
                ['tas_id', $ta->id]
            ])->sum('ijin');

            $alpa = SIA::select('alpha')->where([
                ['nis', $nis],
                ['smt_id', $smt->id],
                ['tas_id', $ta->id]
            ])->sum('alpha');

            $wali = wali::where('kelas_id', $kls->kls)->first();
        }
        return view('rapor.nilai', compact('wali', 'ta', 'mapel', 'nilai', 'rata', 'smt', 'siswa', 'total', 'totalRata', 'kep', 'sakit', 'ijin', 'alpa', 'rataAnak', 'jum_siswa', "tgl"));
    }

    public function keterangan($nis)
    {
        $bio = mst_siswa::where('nis', $nis)->first();
        $tgl_raport = tgl_rapor::orderBy('id', "desc")->first();

        return view('rapor.keterangan', compact('bio', 'tgl_raport'));
    }

    public function kep()
    {
        $kelas = Kelas::all();
        $mapel = mapels::all();
        $smt = smt::where('flag', 1)->first();

        return view('rapor.kelas', compact('kelas', 'mapel', 'smt'));
    }

    public function formKep(Request $request)
    {
        $ta = ta::where('aktif', 1)->first();
        $smt = smt::where('flag', 1)->first();
        $jum = kep::select('id')->where([
            ['kelas_id', $request->kelas],
            ['smt', $smt->smt],
            ['tas_id', $ta->id]
        ])->count();
        if ($jum > 1) {

            $nilaiKep = kep::with('siswas')->where([
                ['kelas_id', $request->kelas],
                ['smt', $request->smt],
                ['tas_id', $ta->id]
            ])->get()->sortBy('siswas.nama');
            return view('rapor.updateKep', compact('nilaiKep'));
        } else {
            $siswa = mst_siswa::where('kls', $request->kelas)->orderBy('nama')->get();
            return view('rapor.formKep', compact('siswa'));
        }
    }

    public function simKep(Request $request)
    {
        $ta = ta::where('aktif', 1)->first();
        $smt = smt::where('flag', 1)->first();
        $siswa = mst_siswa::where('kls', $request->kelas)->get();
        foreach ($siswa as $data) {
            $simpan[] = array(
                'nis'          => $request->input('nis' . $data->nis),
                'kelakuan'     => $request->input('kelakuan' . $data->nis),
                'kerajinan'    => $request->input('kerajinan' . $data->nis),
                'kebersihan'   => $request->input('kebersihan' . $data->nis),
                'kelas_id'     => $request->kelas,
                'smt'          => $smt->smt,
                'tas_id'       => $ta->id,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now()
            );
        }
        $save = DB::table('kep')->insert($simpan);

        return redirect('/rapor/kep')->with('status', 'Penyimpanan Kepribadian Berhasil');
    }

    public function update(Request $request)
    {
        $ta = ta::where('aktif', 1)->first();
        $siswa = mst_siswa::where('kls', $request->kelas)->get();
        foreach ($siswa as $data) {
            $update = kep::where([
                ['nis', $request->input('nis' . $data->nis)],
                ['tas_id', $ta->id]
            ])->first();
            $update->kelakuan = $request->input('kelakuan' . $data->nis);
            $update->kerajinan = $request->input('kerajinan' . $data->nis);
            $update->kebersihan = $request->input('kebersihan' . $data->nis);
            $update->save();
        }
        return redirect('/rapor/kep')->with('status', 'Pengeditan Kepribadian Berhasil');
    }

    public function formSia()
    {
        $kelas = Kelas::all();

        return view('rapor.formKelas', compact('kelas'));
    }

    public function saveSIA(Request $request)
    {
        $kelas = mst_siswa::where('kls', $request->kelas)->get();
        $smt = smt::where('flag', 1)->first();

        return view('rapor.inputSIA', compact('kelas', 'smt'));
    }



    public function simSIA(Request $request)
    {
        $ta = ta::where('aktif', 1)->first();
        $siswa_kelas = mst_siswa::where('kls', $request->kelas)->get();
        foreach ($siswa_kelas as $data) {
//            dd($data);
            $simpan = SIA::updateOrCreate(
                [
                    /* ini acuannya data atau primary key */
                    'nis'       => $data->nis,
                    'kelas_id'  => $request->input('kelas'),
                    'smt_id'    => $request->smt,
                    'tas_id'    => $ta->id
                ],
                [
                    /* ini adalah data yang akan di update jika tidak maka akan di save */
                    'sakit' => $request->input('sakit' . $data->nis),
                    'ijin'  => $request->input('ijin' . $data->nis),
                    'alpha' => $request->input('alpha' . $data->nis),
                ]
            );
        }

        return redirect('/rapor/sia');
    }

    public function showSiswaEdit()
    {
        $kelas = Kelas::all();

        return view('admin.editSiswa', compact('kelas'));
    }

    public function editBioSiswa(Request $request)
    {
        $siswas = mst_siswa::where('kls', $request->kelas_id)->orderBy('nama')->get();

        return view('admin.showSiswaEdit', compact('siswas'));
    }
    public function showBioSiswa1($id)
    {
        $siswa = siswa::where('id', $id)->first();

        return view('admin.showSiswaEdit1', compact('siswa'));
    }

    public function updateBio(Request $request)
    {
        $siswa = mst_siswa::where('id', $request->siswa_id)->first();

        $siswa->nama = $request->nama;
        $siswa->save();

        return redirect()->route('siswaEdit');
    }

    public function rangRapor()
    {
        $ta = ta::where('aktif', 1)->first();
        $na = nilai_akhir::with('siswas', 'tas')->orderBy('kelas_id')->orderBy('ranking')->get()->sortBy('siswas.nama');

        return view('rapor.rangRapor', compact( 'na'));
    }
}
