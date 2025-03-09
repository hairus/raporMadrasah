@extends('layouts.app')
@section('title','Add TA')
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
                <h2>Tambah Tahun Ajaran</h2>
            </div>
            <div class="x_content">
                <br>
                <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate=""
                      action="{{ url('/admin/saveTa')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama Tahun Ajaran
                            <span
                                    class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="first-name" required="required"
                                   class="form-control col-md-7 col-xs-12" name="ta">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Semester</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="semester_id" id="" class="form-control col-md-6 col-xs-12" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div class="x_content">
                <table class="table">
                    <thead>
                    <th>No</th>
                    <th>Nama Ta</th>
                    <th>Semester</th>
                    <th>Aktif</th>
                    <th>#</th>
                    </thead>
                    <tbody>
                    @foreach($ta as $data)
                    <tr>
                        <td>1</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->semester }}</td>
                        <td>{{ $data->aktif }}</td>
                        <td>
                            @if($data->aktif == 0)
                                <button class="btn btn-danger">Tidak aktif</button>
                            @else
                            <a href="{{ url('/admin/aktifTa/'.$data->id) }}">
                            <button class="btn btn-primary">Aktif</button>
                            </a>
                                @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
