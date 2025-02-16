@extends('layouts.app')
@section('title','Legger Kelas')
@section('content')
    <div class="row">
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
        <div class="container">
            <div class="x_content">
                <div class="card-body">
                    @foreach($kelas as $data)
                        <a href="{{ url('/admin/rapor/showLegger/'.$data->kelas) }}">
                        <button class="btn btn-dark">Kelas {{ $data->kelas }}</button>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection