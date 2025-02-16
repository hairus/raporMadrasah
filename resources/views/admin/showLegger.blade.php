@extends('layouts.app')
@section('title','Detail Legger')
@section('content')
    <div class="container">
        <div class="x_title">
            <h1>Kelas {{ $kelas }} <small>semester {{ $smt->smt }}</small></h1>

        <div class="col-12">
            <div class="x_panel">
                <div class="table table-responsive">
                    <table class="table table-striped">
                        <th>No</th>
                        <th>Nis</th>
                        <th>Nama</th>
                        @foreach($mapel_kelas as $data)
                        <th>{{ $data->mapels->mapel }}</th>
                        @endforeach
                        <th>RERATA</th>
                        @php $no = 1; @endphp
                        @foreach($siswa as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->nis }}</td>
                            <td>{{ $data->nama }}</td>
                            {{-- query nilai siswa  --}}
                            @foreach($mapel_kelas as $data1)
                                <td>
                                    @php
                                    // cari nilai dengan acuan semester, tas_id, dan nis
                                    $nilai = \App\Models\trx_nilai::where([
                                        ['mapel_id', $data1->mapel_id],
                                        ['smt', $smt->smt],
                                        ['tas_id', $ta->id],
                                        ['nis', $data->nis]
                                        ])->first();
                                    $rerata = \App\Models\trx_nilai::where([
                                        ['smt', $smt->smt],
                                        ['tas_id', $ta->id],
                                        ['nis', $data->nis]
                                        ])->avg('nilai');
                                    @endphp
                                    @if($nilai)
                                    {{ $nilai->nilai }}
                                    @endif
                                </td>
                            @endforeach
                            <td>{{ round($rerata) }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection