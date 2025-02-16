@extends('layouts.app')
@section('title','kelas siswa')
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
                <h2>Kelas {{ $kelas->kelas }}</h2>
            </div>
            <div class="x_content">
{{--                <small>--}}
{{--                    Catatan:--}}
{{--                    jika ingin menaikkan siswa di mulai dari kelas 6--}}
{{--                </small>--}}
{{--                <p></p>--}}
{{--                <form action="{{ url('/admin/naikKelas') }}" method="post">--}}
{{--                    @csrf--}}
{{--                    <div class="form-group">--}}
{{--                        <input type="hidden" value="{{$kelas->id}}" name="kelas_id">--}}
{{--                    </div>--}}
{{--                <button class="btn btn-danger">Naikkan Siswa</button>--}}
{{--                </form>--}}
                <table class="table table-bordered">
                    <thead>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>#</th>
                    </thead>
                    <tbody>
                    @foreach($siswas as $siswa)
                    <tr>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ strtoupper($siswa->nama) }}</td>
                        <td>
                            <a href="{{ url('/admin/hapusSiswa/'.$siswa->id) }}">
                            <button class="btn btn-danger btn-sm">Pindah</button>
                            </a>
                            <a href="{{ url('/admin/kembaliKelas/'.$siswa->id) }}">
                                <button class="btn btn-primary btn-sm">Kembali Kelas Asal</button>
                            </a>
                            <a href="{{ url('/admin/naikKelas/'.$siswa->id) }}">
                                <button class="btn btn-success btn-sm">Naik kelas</button>
                            </a>

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
{{--                <small>--}}
{{--                    Catatan:--}}
{{--                    jika ingin menaikkan siswa di mulai dari kelas 6--}}
{{--                </small>--}}
            </div>
        </div>
    </div>
@endsection
