@extends('layouts.app')
@section('title','Kelas')
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
                <h2>Kelas Siswa</h2>
            </div>
            <div class="x_content">
                @foreach($kelas as $data)
                    <a href="{{ url('/admin/KelasSiswa/'.$data->id) }}">
                        <button class="btn btn-success">{{ $data->kelas }}</button>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
