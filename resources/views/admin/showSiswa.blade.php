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
                    <table class="table table-bordered">
                        <thead>
                        <th>Nis</th>
                        <th>Nama</th>
                        <th>#</th>
                        </thead>
                        <tbody>
                        @foreach($mst_siswa as $data)
                            <tr>
                                <td>{{ $data->nis }}</td>
                                <td>{{$data->nama}}</td>
                                <td>
                                    <form action="{{ url('/admin/delSis/fix') }}" method="post">
                                        @csrf
                                        <button class="btn btn-dark"
                                                onclick="return confirm('Apakah Anda Sudah Yakin Menhapus siswa');">
                                            Delete
                                        </button>
                                        <input type="hidden" name="nis" value="{{ $data->nis }}">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection