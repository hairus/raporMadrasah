@extends('layouts.app')
@section('title','Edit Siswa')
@section('content')
<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><small>Pilih kelas</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form action="{{ url('/admin/editBioSiswa') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Pilih Kelas</label>
                    <select name="kelas_id" id="" class="form-control">
                        @foreach ($kelas as $data)
                        <option value="{{ $data->id }}">{{ $data->kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary">Pilih</button>
            </form>
        </div>
    </div>
</div>
@endsection
