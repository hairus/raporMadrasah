@extends('layouts.app')
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
        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Rangking Rapor</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example">
                            <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Semester</th>
                            <th>Tahun</th>
                            <th>Rangking</th>
                            </thead>
                            <tbody>
                            @foreach($na as $key => $data)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ strtoupper($data->siswas->nama) }}</td>
                                <td>{{ $data->kelas_id }}</td>
                                <td>{{ $data->smt }}</td>
                                <td>{{ $data->tas->tahun }}</td>
                                <td>{{ $data->ranking }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @push('scripts')
            <script>
                $(document).ready(function () {
                    $('#example').DataTable();
                });
            </script>
    @endpush

