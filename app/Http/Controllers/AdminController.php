<?php

namespace App\Http\Controllers;

use App\Models\MapelKelas;
use App\Models\mst_siswa;
use App\Models\User;
use App\Models\wali;
use Carbon\Carbon;
use App\Models\ket;
use App\Models\smt;
use App\Models\Kelas;
use App\Models\siswa;
use App\Models\mapels;
use App\Models\nilai_akhir;
use App\Models\ta;
use App\Models\trx_absen;
use App\Models\trx_nilai;
use App\Models\trx_mapel;
use App\Models\tgl_rapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (isset($request->kelas)) {
            $siswa = siswa::where('kls', $request->kelas)->OrderBy('nis', 'asc')->get();
        }

        $kelas = Kelas::all();

        return view('admin/formAb', compact('kelas'));
    }

    public function saveA(Request $request)
    {
        /*cek dulu di table absen ada data atau tidak di tanggal sekarang*/
        $smt = smt::select('id')->where('flag', 1)->first();
        $cekAbsen = DB::table('trx_absen')
            ->where('kelas_id', $request->input('kelas_id'))
            ->whereMonth('created_at', date('m'))
            ->whereDay('created_at', date('d'))
            ->count();
        /*-----------------------------------------------------------------*/
        /*simpan jika tidak ada data */
        if ($cekAbsen == 0) {
            /*cek ada berapa siswa yang ada id mst_siswa karena akan melakukan looping untuk penyimpanan*/

            $siswa = DB::table('mst_siswa')
                ->where('kls', $request->input('kelas_id'))
                ->get();
            foreach ($siswa as $siswas) {
                $data[] = array(
                    'nis' => $request->input('nis' . $siswas->nis),
                    'kelas_id' => $request->input('kelas_id'),
                    'ket' => $request->input('radio' . $siswas->nis),
                    'ta' => $smt->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                );
            }
            $simpan = DB::table('trx_absen')->insert($data);
            return redirect('/admin/absen')->with('status', 'Penyimpanan berhasil');
        } else {
            return redirect('/admin/absen')->with('error', 'Penyimpanan Gagal');
        }
    }

    public function cek()
    {
        $tahun = date('Y'); //Mengambil tahun saat ini
        $bulan = date('m'); //Mengambil bulan saat ini
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); // jumlah hari saat ini


    }

    public function listSiswa(Request $request)
    {
        $kelas = DB::table('mst_kelas')->get();
        dd($kelas);
        if (isset($_GET['kelas'])) {
            $siswa = DB::table('mst_siswa')
                ->where('kls', $request->kelas)
                ->get();
        }

        return view('/admin/listSiswa', compact('kelas', 'siswa'));
    }

    public function cetak($id)
    {
        $siswa = DB::table('mst_siswa')
            ->where('id', $id)
            ->first();
        /*convert id siswa ke nis di table trx_absen*/
        $con = DB::table('trx_absen')
            ->where('nis', $siswa->nis)
            ->first();

        /* menghitung jumlah hari dalam bulan ini dengan menggunakan coding di bawah ini*/
        $tahun = date('Y'); //Mengambil tahun saat ini
        $bulan = date('m'); //Mengambil bulan saat ini
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        /* pengambilan absen di database dengan bulan sekrang /
            -> ada berapa hari di bulan sekrang ?
            -> coding pertama di bawah ini adalah logika dimmana nis di bawah berada di hari apa saja
            -> tapi ingat dari kodingan tersebut masih berbentuk array
        */

        for ($x = 1; $x <= $tanggal; $x++) {
            $absen[] = array(DB::table('trx_absen')
                ->whereDay('created_at', $x)
                ->whereMonth('created_at', date('m'))
                ->where('nis', $siswa->nis)
                ->first());
        }
        /*
         * karena data berbentuk arraya maka harus di pecah lagi contoh seperti ini
         */
        for ($y = 0; $y < $tanggal; $y++) {
            $test[] = $absen[$y][0];
        }
        $try = $test;

        /*
         * menghitung jumlah sakit ijin dan alpa
         */
        $sakit = DB::table('trx_absen')
            ->where('nis', $con->nis)
            ->where('ket', '2')
            ->whereMonth('created_at', date('m'))
            ->count();

        $ijin = DB::table('trx_absen')
            ->where('nis', $con->nis)
            ->where('ket', '3')
            ->whereMonth('created_at', date('m'))
            ->count();

        $alpa = DB::table('trx_absen')
            ->where('nis', $con->nis)
            ->where('ket', '4')
            ->whereMonth('created_at', date('m'))
            ->count();


        return view('/admin/cetak', compact('siswa', 'tanggal', 'try', 'sakit', 'ijin', 'alpa'));
    }

    public function kelas()
    {
        $kelas = Kelas::all();
        $mapel = mapels::OrderBy('mapel', 'ASC')->get();
        $smt = ta::where('aktif', 1)->first();

        return view('/admin/kelas', compact('kelas', 'mapel', 'smt'));
    }

    public function inputNilai(Request $request)
    {
        $ta = ta::where('aktif', 1)->first();
        $cek = trx_nilai::select('id')->where([
            ['mapel_id', $request->mapel],
            ['kelas_id', $request->kelas],
            ['smt', $request->smt],
            ['tas_id', $ta->id]
        ])->count();
        if ($cek > 1) {
            $datas = trx_nilai::with('siswa')->select('id', 'nis', 'nilai', 'kelas_id', 'mapel_id')->where([
                ['kelas_id', $request->kelas],
                ['mapel_id', $request->mapel],
                ['smt', $request->smt],
                ['tas_id', $ta->id]
            ])->get()->sortBy('siswa.nama');
            $smt = smt::where('flag', 1)->first();

            return view('admin.updateNilai', compact('datas', 'smt'));
        }
        $siswa = siswa::select('nis', 'nama', 'kls', 'flag')->where([
            ['kls', $request->kelas],
            ['flag', 1]
        ])->orderBy('nama')->get();
        $mapel = mapels::where('id', $request->mapel)->first();
        $smt = smt::where('flag', 1)->first();

        return view('/admin/formIN', compact('siswa', 'mapel', 'smt'));
    }

    public function simNilai(Request $request)
    {
        $ta = ta::where('aktif', 1)->first();
        $siswa = siswa::select('nis', 'nama', 'kls')->where([
            ['kls', $request->kelas]
        ])->get();

        $cekNilai = trx_nilai::where([
            ['mapel_id', $request->mapel],
            ['kelas_id', $request->kelas],
            ['smt', $request->smt],
            ['tas_id', $ta->id]
        ])->count();

        if ($cekNilai == 0) {
            foreach ($siswa as $sis) {
                $data[] = array(
                    'mapel_id' => $request->mapel,
                    'kelas_id' => $request->kelas,
                    'nilai' => $request->input('nilai' . $sis->nis),
                    'nis' => $request->input('nis' . $sis->nis),
                    'smt' => $request->smt,
                    'tas_id' => $ta->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                );
            }
            $save = DB::table('trx_nilai')->insert($data);
            return redirect('/admin/kelas')->with('status', 'Penyimpanan Berhasil');
        } else {
            return redirect('/admin/kelas')->with('error', 'Maaf kelas dan Mapel Sudah di Input');
        }
    }

    public function indexKM()
    {
        $kelas = Kelas::all();
        $mapel = mapels::all();

        return view('/admin/indexKM', compact('kelas', 'mapel'));
    }

    public function editNi(Request $request)
    {
        $cekData = trx_nilai::where([
            ['mapel_id', $request->mapel],
            ['kelas_id', $request->kelas]
        ])->count();
        if ($cekData > 1) {
            $edit = trx_nilai::where([
                ['mapel_id', $request->mapel],
                ['kelas_id', $request->kelas]
            ])->get();

            $mapel = mapels::where('id', $request->mapel)->first();

            return view('admin/edit', compact('edit', 'mapel'));
        } else {
            return redirect('admin/kelas')->with('error', 'Maaf kelas dan Mapel Tersebut Belum ada Data');
        }
    }

    public function updateNilai(Request $request)
    {
        $kelas = siswa::select('nis')->where('kls', $request->kelas)->get();

        foreach ($kelas as $data) {
            DB::table('trx_nilai')
                ->where('kelas_id', $request->kelas)
                ->where('mapel_id', $request->mapel)
                ->where('nis', $request->input('nis' . $data->nis))
                ->update([
                    'nilai' => $request->input('nilai' . $data->nis),
                    'updated_at' => Carbon::now()
                ]);
        }

        return redirect('/admin/kelas')->with('status', 'Perubahan Nilai Berhasil');
    }

    public function edata($id)
    {
        $trx_nilai = trx_nilai::select('nilai', 'nis', 'mapel_id', 'id')->where('id', $id)->first();

        return view('admin.editNilai', compact('trx_nilai'));
    }

    public function tester()
    {
        $sis = siswa::with(['kelas' => function ($query) {
            $query->select('id');
        }])->where('nis', 155)->toSql();
        dd($sis);
    }

    public function luki()
    {
        $tanggal1 = date('Y-m-d');
        $tanggal2 = $tanggal1;
        $tanggal3 = date('d-m-Y');
        dd($tanggal3);
    }

    public function update(Request $request)
    {

        $simpan = trx_nilai::find($request->id);
        $simpan->nilai = $request->nilai;
        $simpan->save();

        return back()->with('status', 'Penyimpanan sukses');
    }

    public function formSmt()
    {
        $smt = smt::all();
        return view('admin.formSmt', compact('smt'));
    }

    public function updatesmt(Request $request)
    {
        $default = smt::all();
        foreach ($default as $smt) {
            $smt->flag = 0;
            $smt->save();
        }

        $smt = smt::find($request->smt);
        $smt->flag = 1;
        $smt->save();

        return redirect('/admin/smt')->with('status', 'Perubahan Nilai Berhasil');
    }

    public function export()
    {
        // $nilai = trx_nilai::select('nis', 'mapel_id', 'kelas_id', 'nilai', 'smt')->where([
        //     ['smt', 1],
        //     ['mapel_id', 1]
        // ])->get();
        // return FacadesExcel::create('nilai_export', function ($excel) use ($nilai) {
        //     $excel->sheet('mysheet', function ($sheet) use ($nilai) {
        //         $sheet->fromArray($nilai);
        //     });
        // })->download('xls');
    }

    public function niperorang()
    {
        $mst_siswa = mst_siswa::where("flag", 1)->get();
        $mapel = mapels::get();

        return view('admin.perorangan', compact('mst_siswa', 'mapel'));
    }

    public function simpanNilaiPerorangan(Request $request)
    {
        // dd($request);
        $siswa = mst_siswa::find($request->siswa_id);
        $mapel_id = mapels::find($request->mapel_id);
        $ta = ta::where('aktif', 1)->first();
        $smt = smt::where('flag', 1)->first();
        $cek = trx_nilai::where([
            "nis" => $siswa->nis,
            "tas_id" => $ta->id,
            "mapel_id" => $mapel_id->id,
            "smt" => $smt->smt,
            ])->count();
        if($cek == 0){
            $sim = trx_nilai::create([
                "nis" => $siswa->nis,
                "mapel_id" => $mapel_id->id,
                "nilai" => $request->nilai,
                "kelas_id" => $siswa->kls,
                "smt" => $smt->smt,
                "tas_id" => $ta->id,
            ]);
            return back()->with("status", "input NIlai sukses");
        }else{
            return back()->with("error", "maaf siswa nilainya ada");
        }
    }

    public function formImport()
    {
        return view('admin.import');
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $data = Facade::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    $simpan = new trx_nilai();
                    $simpan->nis = $value->nis;
                    $simpan->nilai = $value->nilai;
                    $simpan->mapel_id = $value->mapel_id;
                    $simpan->kelas_id = $value->kelas_id;
                    $simpan->smt = $value->smt;
                    $simpan->save();
                }
            }
        }
        return back();
    }

    public function showForm($id)
    {
        $now = trx_absen::select('nis', 'ket', 'kelas_id')->where('nis', $id)->whereDate('created_at', Carbon::today())->first();
        $ket = ket::all();


        return view('admin.formEdit', compact('now', 'ket'));
    }

    public function updateNow(Request $request)
    {
        $request->validate([
            'ket' => 'required|numeric',
        ]);
        DB::table('trx_absen')
            ->where('nis', $request->nis)
            ->whereDay('created_at', date('d'))
            ->update([
                'ket' => $request->ket,
                'updated_at' => Carbon::now()
            ]);

        return back()->with('status', 'Edit Sukses');
    }

    public function formTgl($id)
    {
        $idSiswa = $id;
        $tahun = date('Y'); //Mengambil tahun saat ini
        $bulan = date('m'); //Mengambil bulan saat ini
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        return view('admin.formTgl', compact('tanggal', 'idSiswa'));
    }

    public function updateTgl(Request $request)
    {

        $tgl = $request->tgl;
        $bln = $request->bln;
        $nis = $request->nis;
        $now = trx_absen::where('nis', $request->nis)->whereDay('created_at', $request->tgl)->whereMonth('created_at', $request->bln)->first();
        if ($now == false) {
            return back()->with('status', 'Perubahan Nilai Berhasil');
        }
        $ket = ket::all();


        return view('admin.editTgl', compact('now', 'ket', 'tgl', 'bln'));
    }

    public function updateTgl1(Request $request)
    {
        $update = DB::table('trx_absen')
            ->where('nis', $request->nis)
            ->whereDay('created_at', $request->tgl)
            ->whereMonth('created_at', $request->bln)
            ->update([
                'ket' => $request->ket,
                'updated_at' => Carbon::now(),
            ]);

        return redirect('/admin/laporan')->with('status', 'Edit Berhasil');
    }

    public function addIndex()
    {
        return view('admin.addIndex');
    }

    public function simAdd(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $simpan = new user;
        $simpan->name = $request->nama;
        $simpan->password = bcrypt($request->password);
        $simpan->email = $request->email;
        $simpan->status = 1;
        $simpan->save();

        return back()->with('status', 'Penambahan user sukses');
    }

    public function showuser()
    {
        $user = user::all();

        return view('admin.showUser', compact('user'));
    }

    public function delSiswa()
    {
        $kelas = Kelas::all();

        return view('admin.delSiswa', compact('kelas'));
    }

    public function showSiswa()
    {
        $kelas = Input::get('kelas');
        $mst_siswa = mst_siswa::where('kls', $kelas)->orderBy('nama')->get();

        return view('admin.showSiswa', compact('mst_siswa'));
    }

    public function deleteSiswa(Request $request)
    {
        /* menghapus semua nilai siswa yang akan di delete*/
        $mst_nilai = trx_nilai::where('nis', $request->nis)->get();
        $delete_nilai = trx_nilai::where('nis', $request->nis)->delete();
        $delete_siswa = mst_siswa::where('nis', $request->nis)->delete();

        return back();
    }

    public function legger()
    {
        $kelas = Kelas::where('id', '<', 7)->get();

        return view('admin.showKelas', compact('kelas'));
    }

    public function showLegger($kelas)
    {
        // butuh ta aktif
        $ta = ta::where('aktif', 1)->first();

        //butuh semester aktif
        $smt = smt::where('flag', 1)->first();

        //butuh mapel Kelas
        $mapel_kelas = MapelKelas::where([
            ['kelas_id', $kelas],
            ['smt', $smt->id]
        ])->get();

        //ambil siswa
        $siswa = mst_siswa::where('kls', $kelas)->get();

        //butuh trx_nilai
        $trx_nilai = trx_nilai::where([
            ['tas_id', $ta->id],
            ['smt', $smt->id],
            ['kelas_id', $kelas]
        ])->get();

        return view('admin.showLegger', compact('kelas', 'ta', 'smt', 'mapel_kelas', 'trx_nilai', 'siswa'));
    }

    public function mapel_kelas()
    {
        // butuh ta aktif
        $ta = ta::where('aktif', 1)->first();

        //butuh semester aktif
        $smt = smt::where('flag', 1)->first();

        //ambil semua mapel untuk bisa di crate di viewnya
        $mapels = mapels::all();

        //butuh semua kelas
        $mst_kelas = Kelas::where('id', '<', 7)->get();

        $mapel_kelas = MapelKelas::where([
            ['smt', $smt->smt]
        ])->orderBy('kelas_id')->orderBy('mapel_id')->get();

        return view('admin.mapel_kelas', compact('mapel_kelas', 'mapels', 'mst_kelas', 'smt'));
    }

    public function saveMapel(Request $request)
    {
        // cek dulu mapel sudah ada
        $mapel_kelas = MapelKelas::where([
            ['mapel_id', $request->mapel_id],
            ['smt', $request->smt_id],
            ['kelas_id', $request->kelas_id],
        ])->count();
        if ($mapel_kelas >= 1) {
            return back();
        } else {
            $simpan = new MapelKelas();
            $simpan->mapel_id = $request->mapel_id;
            $simpan->kelas_id = $request->kelas_id;
            $simpan->smt = $request->smt_id;
            $simpan->save();
        }

        return back();
    }

    public function saveMapelbaru(Request $request)
    {
       $mapel = mapels::create([
           "mapel" => $request->mapel
       ]);

        return back();
    }

    public function delMapelKelas($id)
    {
        MapelKelas::where('id', $id)->delete();

        return back();
    }

    public function delMapel($id)
    {
        $mapel = mapels::find($id);
        $mapel->delete();

        return back();
    }

    public function addTa()
    {
        $ta = ta::all();

        return view('admin.addTa', compact('ta'));
    }

    public function saveTa(Request $request)
    {
        $sim = new ta();
        $sim->ta = $request->ta;
        $sim->smt = $request->semester_id;
        $sim->aktif = 0;
        $sim->save();

        return back();
    }

    public function aktifTa($id)
    {
        $tas = ta::get();
//        dd($tas);
        foreach ($tas as $data) {
            $update = ta::where('id', $data->id)->first();
            $update->aktif = 0;
            $update->save();
        }
        $aktif = ta::where('id', $id)->first();
        $aktif->aktif = 1;
        $aktif->save();

        return back();
    }

    public function KelasSiswa()
    {
        $kelas = Kelas::all();

        return view('admin.kelasSiswa', compact('kelas'));
    }

    public function createMapel()
    {
        $mapels = mapels::all();

        return view('admin.createMapel', compact('mapels'));
    }




    public function KelasSiswaId($id)
    {
        $kelas = Kelas::where('id', $id)->first();
        $siswas = siswa::where([
            ['kls', $id],
        ])->orderBy('nama')->get();

        return view('admin.kelas_siswa', compact('siswas', 'kelas'));
    }

    public function kembaliKelas($id)
    {
        $siswa = siswa::where('id', $id)->first();
        $siswa->kls = $siswa->kls - 1;
        $siswa->save();

        return back();
    }

    public function naikKelas1($id)
    {
        $siswa = siswa::where('id', $id)->first();
        $siswa->kls = $siswa->kls + 1;
        $siswa->save();

        return back();
    }

    public function naikKelas(Request $request)
    {
        $siswa = siswa::where([
            ['kls', $request->kelas_id],
            ['flag', 1]
        ])->get();

        foreach ($siswa as $item) {
            $update = siswa::where('id', $item->id)->first();
            $update->kls = $request->kelas_id + 1;
            $update->save();
        }

        return back();
    }

    public function hapusSiswa($id)
    {
        $siswa = siswa::where('id', $id)->first();

        $siswa->flag = 0;
        $siswa->save();

        return back();
    }

    public function singkron()
    {
        //sinkron jika semester ganjil tidak ada naik kelas
        $rangking = 1;
        $kelas = Kelas::where('kelas', '<>', 'lulus')->get();
        $ta = ta::where('aktif', 1)->first();
        if($ta->smt == 1){
            // ini funsi untuk insert dan update nilai ke table nilai_akhirs
            foreach ($kelas as $data) {
                $kelas_siswa = mst_siswa::where([
                    ['kls', $data->id],
                    ['flag', 1]
                ])->get();
                foreach ($kelas_siswa as $data1) {
                    $nilai_total = trx_nilai::where([
                        ['tas_id', $ta->id],
                        ['smt', 1],
                        ['nis', $data1->nis],
                        ['kelas_id', $data->id]
                    ])->avg('nilai');
                    //simpan nilai total;
                    //jika data ada maka di update
                    $nilai_akhir = nilai_akhir::where([
                        ['tas_id', $ta->id],
                        ['smt', 1],
                        ['nis', $data1->nis],
                        ['kelas_id', $data->id]
                    ])->first();
                    if ($nilai_akhir) {
                        //update nilai
                        $nilai_akhir->total_nilai = $nilai_total;
                        $nilai_akhir->save();
                    } else {
                        // INPUT NILAI TOTAL JIKA TIDAK ADA DI DB
                        $sim = new nilai_akhir();
                        $sim->nis = $data1->nis;
                        $sim->kelas_id = $data->id;
                        $sim->smt = 1;
                        $sim->ranking = 0;
                        $sim->tas_id = $ta->id;
                        $sim->total_nilai = $nilai_total;
                        $sim->save();
                    }
                }
            }

            //ini fungsi utk singkron rangking di table nilai_akhirs
            foreach ($kelas as $data) {
                $no = 1;
                $na = nilai_akhir::where([
                    ['kelas_id', $data->id],
                    ['tas_id', $ta->id]
                ])->orderby('total_nilai', 'DESC')->get();
                foreach ($na as $dt) {
                    $up = nilai_akhir::where('id', $dt->id)->first();
                    $up->ranking = $no++;
                    $up->save();
                }
            }
            return 'sukses singkron semester 1';
        }else {
            // ini funsi untuk insert dan update nilai ke table nilai_akhirs
            foreach ($kelas as $data) {
                $kelas_siswa = mst_siswa::where('kls', $data->id)->get();
                foreach ($kelas_siswa as $data1) {
                    $nilai_total = trx_nilai::where([
                        ['tas_id', $ta->id],
                        ['smt', 2],
                        ['nis', $data1->nis],
                        ['kelas_id', $data->id]
                    ])->avg('nilai');
                    //simpan nilai total;
                    //jika data ada maka di update
                    $nilai_akhir = nilai_akhir::where([
                        ['tas_id', $ta->id],
                        ['smt', 2],
                        ['nis', $data1->nis],
                        ['kelas_id', $data->id]
                    ])->first();
                    if ($nilai_akhir) {
                        //update nilai
                        $nilai_akhir->total_nilai = $nilai_total;
                        $nilai_akhir->save();
                    } else {
                        // INPUT NILAI TOTAL JIKA TIDAK ADA DI DB
                        $sim = new nilai_akhir();
                        $sim->nis = $data1->nis;
                        $sim->kelas_id = $data->id;
                        $sim->smt = 2;
                        $sim->ranking = 0;
                        $sim->tas_id = $ta->id;
                        $sim->total_nilai = $nilai_total;
                        $sim->save();
                    }
                }
            }

            //ini fungsi utk singkron rangking di table nilai_akhirs
            foreach ($kelas as $data) {
                $no = 1;
                $na = nilai_akhir::where([
                    ['kelas_id', $data->id],
                    ['tas_id', $ta->id]
                ])->orderby('total_nilai', 'DESC')->get();
                foreach ($na as $dt) {
                    $up = nilai_akhir::where('id', $dt->id)->first();
                    $up->ranking = $no++;
                    $up->save();
                }
            }
            return 'sukses singkron semester 2';
        }
    }

    public function addTgl()
    {
        $tgl = tgl_rapor::all();
        return view("rapor.addtgl", compact('tgl'));
    }

    public function addTgl1(Request $request)
    {
        $tgl = tgl_rapor::create([
            "tgl_rapor" => $request->tgl
        ]);

        return view("rapor.addtgl");
    }

    public function addWali()
    {
        $wali = wali::all();

        return view("admin.addwali", compact('wali'));
    }

    public function saveWali(Request $request)
    {
        $sim = wali::create([
            "nama" => $request->nama,
            "kelas_id" => $request->kelas_id
        ]);

        return back();
    }

    public function delWali($id)
    {
        $wali = wali::find($id);
        $wali->delete();

        return back();
    }
}
