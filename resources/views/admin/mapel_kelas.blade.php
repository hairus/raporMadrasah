@extends('layouts.app')
@section('title','Setting Mapel Kelas')
@section('content')
    <div class="row">
        <div class="x_title">
            <h3>Mapping Mapel Kelas</h3>
            <div class="col-12">
                <div class="x_panel">
                    <form action="{{ url('/admin/saveMapel') }}" class="form-actions" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Pilih Mapel</label>
                            <select name="mapel_id" id="" class="form-control">
                                @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih Kelas</label>
                            <select name="kelas_id" id="" class="form-control">
                                @foreach($mst_kelas as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Semester Aktif Sekarang</label>
                            <select name="smt_id" id="" class="form-control">
                                    <option value="{{ $smt->id }}">{{ $smt->smt }}</option>
                            </select>
                        </div>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                    <hr>
                    <br>
                    <br>
                    <div class="table table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Semester</th>
                            <th>#</th>
                            </thead>
                            <tbody>
                            @php $no = 1 @endphp
                            @foreach($mapel_kelas as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->kelass->kelas }}</td>
                                <td>{{ $data->mapels->mapel }}</td>
                                <td>{{ $data->smt }}</td>
                                <td>
                                    <a href="{{ url('/admin/delMapelKelas/'.$data->id) }}">
                                        <button class="btn btn-danger delete" onclick="return confirm(' Anda Yakin Menghapus?');">Delete</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection