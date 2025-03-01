@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h4>Create Mapel</h4>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form-horizontal form-label-left" action="{{ url('/admin/saveMapelbaru') }}"
                          method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Mapel</label>
                            <input type="text" class="form-control" name="mapel">
                        </div>
                        <button class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h4>Mapel</h4>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table" id="example">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mapels as $key => $mapel)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $mapel->mapel }}</td>
                                    <td>
                                        <a href="{{ url('/admin/delMapel/'.$mapel->id) }}">
                                            <button class="btn btn-sm btn-danger">Delete</button>
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
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
@endpush

