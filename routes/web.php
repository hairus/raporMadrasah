<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => ['admin']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('admin/inputSiswa', [App\Http\Controllers\HomeController::class, 'inputSiswa']);
    Route::get('admin/delSiswa/{id}', [App\Http\Controllers\HomeController::class, 'delSiswa']);
    Route::post('admin/SimSis', [App\Http\Controllers\HomeController::class, 'save']);
    Route::get('admin/absen', [App\Http\Controllers\AdminController::class, 'index']);
    Route::post('admin/saveA', [App\Http\Controllers\AdminController::class, 'index']);
    Route::get('admin/cekhari', [App\Http\Controllers\AdminController::class, 'cek']);
    Route::get('admin/laporan', [App\Http\Controllers\AdminController::class, 'listSiswa']);
    Route::get('admin/cetak/{id}', [App\Http\Controllers\AdminController::class, 'cetak']);
    Route::get('admin/FormEdit/{id}', [App\Http\Controllers\AdminController::class, 'showForm']);
    Route::post('admin/editNow', [App\Http\Controllers\AdminController::class, 'updateNow']);
    Route::get('admin/editTgl/{id}', [App\Http\Controllers\AdminController::class, 'formTgl']);
    Route::post('admin/editTgl', [App\Http\Controllers\AdminController::class, 'updateTgl']);
    Route::put('admin/updateTgl', [App\Http\Controllers\AdminController::class, 'updateTgl1']);
    Route::get('admin/add', [App\Http\Controllers\AdminController::class, 'addIndex']);
    Route::post('admin/add', [App\Http\Controllers\AdminController::class, 'simAdd']);
    Route::get('admin/showUser', [App\Http\Controllers\AdminController::class, 'showUser']);
    Route::post('/admin/saveTa', [App\Http\Controllers\AdminController::class, 'saveTa']);
    Route::get('/admin/aktifTa/{id}', [App\Http\Controllers\AdminController::class, 'aktifTa']);
    Route::get('/admin/KelasSiswa', [App\Http\Controllers\AdminController::class, 'KelasSiswa']);
    Route::get('/admin/KelasSiswa/{id}', [App\Http\Controllers\AdminController::class, 'KelasSiswaId']);
    Route::get('/admin/createMapel', [App\Http\Controllers\AdminController::class, 'createMapel']);
    Route::post('/admin/saveMapel', [App\Http\Controllers\AdminController::class, 'saveMapel']);
    Route::get('/admin/kembaliKelas/{id}', [App\Http\Controllers\AdminController::class, 'kembaliKelas']);
    Route::get('/admin/naikKelas/{id}', [App\Http\Controllers\AdminController::class, 'naikKelas1']);
    Route::post('/admin/naikKelas/', [App\Http\Controllers\AdminController::class, 'naikKelas']);
    Route::get('/admin/hapusSiswa/{id}', [App\Http\Controllers\AdminController::class, 'hapusSiswa']);


    /* penilaian */
    Route::get('/admin/kelas', [App\Http\Controllers\AdminController::class, 'kelas']);
    Route::post('admin/InputNilai', [App\Http\Controllers\AdminController::class, 'inputNilai'])->name('IN');
    Route::get('admin/niperorang', [App\Http\Controllers\AdminController::class, 'niperorang']);
    Route::post('admin/simpanNilaiPerorangan', [App\Http\Controllers\AdminController::class, 'simpanNilaiPerorangan']);
    Route::post('admin/simNilai', [App\Http\Controllers\AdminController::class, 'simNilai'])->name('simNilai');
    Route::get('admin/nilai/indexKM', [App\Http\Controllers\AdminController::class, 'hapusSiswa']);
    Route::post('admin/edit', [App\Http\Controllers\AdminController::class, 'editNi'])->name('edit');
    Route::get('admin/nilai/e/{id}', [App\Http\Controllers\AdminController::class, 'hapusSiswa']);
    Route::get('test', [App\Http\Controllers\AdminController::class, 'tester']);
    Route::get('/luki', [App\Http\Controllers\AdminController::class, 'luki']);
    Route::put('/admin/upadmin/KelasSiswa/2date', [App\Http\Controllers\AdminController::class, 'update']);
    Route::put('/admin/updateNilai', [App\Http\Controllers\AdminController::class, 'updateNilai'])->name('updateNilai');
    Route::get('/admin/smt', [App\Http\Controllers\AdminController::class, 'formSmt']);
    Route::put('/admin/smt', [App\Http\Controllers\AdminController::class, 'updatesmt'])->name('aktifsmt');
    Route::get('/admin/formImport', [App\Http\Controllers\AdminController::class, 'formImport']);
    Route::get('/admin/DelSiswa', [App\Http\Controllers\AdminController::class, 'delSiswa']);
    Route::get('/admin/delSiswa/{kelas}', [App\Http\Controllers\AdminController::class, 'showSiswa']);
    Route::post('/admin/delSis/fix', [App\Http\Controllers\AdminController::class, 'deleteSiswa']);
    Route::post('/admin/delSis/fix', [App\Http\Controllers\AdminController::class, 'deleteSiswa']);
    Route::get('/admin/addTa', [App\Http\Controllers\AdminController::class, 'addTa']);
    Route::get('/admin/addWali', [App\Http\Controllers\AdminController::class, 'addWali']);
    Route::post('/admin/addWali', [App\Http\Controllers\AdminController::class, 'saveWali']);
    Route::get('/admin/{id}/del', [App\Http\Controllers\AdminController::class, 'delWali']);


    /*export excel*/
    Route::get('/admin/export', [App\Http\Controllers\AdminController::class, 'export']);

    /*import excel*/
    Route::post('/admin/import', [App\Http\Controllers\AdminController::class, 'import'])->name('import');


    /* cetak legger*/
    Route::get('/admin/rapor/cetakLegger', [App\Http\Controllers\AdminController::class, 'legger']);
    Route::get('/admin/rapor/showLegger/{kelas}', [App\Http\Controllers\AdminController::class, 'showLegger']);
    /*---------------*/

    /* settigan mapel kelas*/
    Route::get('/admin/mapelKelas', [App\Http\Controllers\AdminController::class, 'mapel_kelas']);
    Route::post('admin/saveMapelbaru', [App\Http\Controllers\AdminController::class, 'saveMapelbaru']);
    Route::post('admin/saveMapel', [App\Http\Controllers\AdminController::class, 'saveMapel']);
    Route::get('/admin/delMapelKelas/{id}', [App\Http\Controllers\AdminController::class, 'delMapelKelas']);
    Route::get('/admin/delMapel/{id}', [App\Http\Controllers\AdminController::class, 'delMapel']);
    /*----------*/


    /*--------- setingan untuk kwnaikan siswa ------------*/
    Route::get('/admin/singkron', [App\Http\Controllers\AdminController::class, 'singkron']);
    Route::get('/admin/addTgl', [App\Http\Controllers\AdminController::class, 'addTgl']);
    Route::post('/admin/addTgl1', [App\Http\Controllers\AdminController::class, 'addTgl1']);

    /*----------------------------------------------------*/

    Route::get('/rapor/cetak', [App\Http\Controllers\raporController::class, 'index']);
    Route::get('/admin/showSiswaEdit', [App\Http\Controllers\raporController::class, 'showSiswaEdit'])->name('siswaEdit');
    Route::post('/admin/editBioSiswa', [App\Http\Controllers\raporController::class, 'editBioSiswa']);
    Route::get('/admin/showBioSiswa1/{id}', [App\Http\Controllers\raporController::class, 'showBioSiswa1']);
    Route::patch('/admin/updateBio', [App\Http\Controllers\raporController::class, 'updateBio']);
    Route::get('/rapor/kep', [App\Http\Controllers\raporController::class, 'kep']);
    Route::post('rapor/formKep', [App\Http\Controllers\raporController::class, 'formKep']);
    Route::post('/rapor/showSiswa', [App\Http\Controllers\raporController::class, 'showSiswa']);
    Route::get('rapor/cover/{nis}', [App\Http\Controllers\raporController::class, 'cover']);
    Route::get('rapor/petunjuk', [App\Http\Controllers\raporController::class, 'petunjuk']);
    Route::get('rapor/keterangan/{nis}', [App\Http\Controllers\raporController::class, 'keterangan']);
    Route::get('rapor/nilai/{nis}', [App\Http\Controllers\raporController::class, 'nilai']);
    Route::post('rapor/kep', [App\Http\Controllers\raporController::class, 'simKep'])->name('simKep');
    Route::put('rapor/kep', [App\Http\Controllers\raporController::class, 'update'])->name('updateKep');
    Route::get('rapor/sia', [App\Http\Controllers\raporController::class, 'formSia']);
    Route::post('rapor/saveSIA', [App\Http\Controllers\raporController::class, 'saveSIA']);
    Route::post('rapor/simSia', [App\Http\Controllers\raporController::class, 'simSIA'])->name('simpanSIA');
    Route::get('rapor/rangRapor', [App\Http\Controllers\raporController::class, 'rangRapor']);
});
