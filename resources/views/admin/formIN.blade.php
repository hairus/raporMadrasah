@extends('layouts.app')
@section('content')
<form action="{{ route('simNilai') }}" method="post">
    {{ csrf_field() }}
    <div class="col-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Tabel Penilaian <small>Mapel :{{ $mapel->mapel }} Semester : {{ $smt->smt }}</small></h2>
                <div class="clearfix"></div>
                <div class="x_content">
                    <?php
                    $no = 1;
                ?>
                <div class="table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $sis)
                            <tr>
                                <th>{{ $no++ }}</th>
                                <td><input name="nis{{ $sis->nis }}" type="hidden"
                                        value="{{ $sis->nis }}">{{ strtoupper($sis->nama) }}</td>
                                <td><input type="hidden" name="kelas" value="{{ $sis->kls }}">{{ $sis->kls }}</td>
                                <td><input type="number" name="nilai{{ $sis->nis }}" class="form-control"></td>
                                <input type="hidden" name="mapel" value="{{ $mapel->id }}">
                                <input type="hidden" name="smt" value="{{ $smt->id }}">
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</form>
@endsection
