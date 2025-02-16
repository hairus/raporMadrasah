@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h4>Menghapus Siswa</h4>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form-horizontal form-label-left" action="{{ url('/admin/delSiswa/kelas') }}" method="get">
                        <div class="form-group">
                            <label class="control-label ">Pilih Kelas</label>
                            <select class="select2_single form-control" tabindex="-1" name="kelas">
                                <option>---</option>
                                @foreach($kelas as $data)
                                    <option value="{{$data->id}}">{{$data->kelas}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-danger">Pilih</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection