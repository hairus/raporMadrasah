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
            <table class="table table-bordered">
                <thead>
                    <th>No</th>
                    <th>Nis</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>#</th>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($siswas as $siswa)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->kls }}</td>
                        <td>
                            <a href="{{ url('/admin/showBioSiswa1/'.$siswa->id) }}">
                                <button class="btn btn-primary">Pilih siswa</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
