@extends('layouts.app')
@section('title','Add User')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
@if (session('status'))
<div class="alert alert-success">
  {{ session('status') }}
</div>
@endif
@if (session('error'))
<div class="alert alert-danger">
  {{ session('error') }}
</div>
@endif
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Input Siswa Perorangan</h2>
    </div>
    <div class="x_content">
      <br>
      <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate=""
        action="{{ url('/admin/simpanNilaiPerorangan')}}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama User <span
              class="required"></span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="siswa_id" id="" class="form-control">
                @foreach ($mst_siswa as $data)
                <option value="{{$data->id}}">{{ $data->nama }}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mapel<span class="required"></span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="mapel_id" id="" class="form-control">
                @foreach ($mapel as $data)
                <option value="{{$data->id}}">{{ $data->mapel }}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nilai<span
              class="required"></span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" id="last-name" name="nilai" required="required"
              class="form-control col-md-7 col-xs-12">
          </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
