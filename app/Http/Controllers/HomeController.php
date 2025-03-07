<?php

namespace App\Http\Controllers;

use App\Models\mapels;
use App\Models\mst_siswa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }

    public function index()
    {
        $jumMapel = mapels::count();
        $jumSis = mst_siswa::count();

        return view('dashboard', compact(['jumMapel', 'jumSis']));
    }

    public function inputSiswa()
    {
        $siswas = mst_siswa::all();

        return view('admin/formInput', compact('siswas'));
    }

    public function delSiswa($id)
    {
        $del = mst_siswa::where('id', $id)->delete();

        return back();
    }

    public function save(Request $request)
    {
        $cek = mst_siswa::where('nis', $request->nis)->count();

        if ($cek) {
            return back()->with('error', 'Maaf sudah ada');
        }
        $simpan = new mst_siswa;
        $simpan->nama = $request->input('nsis');
        $simpan->kls = $request->input('kls');
        $simpan->almt = $request->input('almt');
        $simpan->na = $request->input('Na');
        $simpan->ni = $request->input('Ni');
        $simpan->nis = $request->input('nis');
        $simpan->save();

        return back();
    }
}
