@extends('layouts.app')
@section('title','Edit Siswa')
@section('content')
<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><small>Biodata Siswa</small></h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form action="{{ url('/admin/updateBio') }}" method="post">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="">NIS</label>
                    <input type="text" class="form-control" value="{{ $siswa->nis }}" disabled>
                    <input name="siswa_id" type="hidden" class="form-control" value="{{ $siswa->id }}">
                </div>
                <div class="form-group">
                    <label for="">Nama Siswa</label>
                    <input name="nama" type="text" class="form-control" value="{{ $siswa->nama }}">
                </div>
                <button class="btn btn-primary" type="submit">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
