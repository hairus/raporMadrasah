@extends('layouts.app')
@section('title','Tanggal Rapor')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Tanggal Rapor</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="demo-form2" action="{{url('/admin/addTgl1')}}" method="POST" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Masukkan Tgl</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="tgl" placeholder="contoh 31 Janurai 2012">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Pilih</button>
                            </div>
                        </div>
                    </form>
                </div>
                <ul>
                    @foreach ($tgl as $data)
                    <li>{{ $data->tgl_rapor }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
