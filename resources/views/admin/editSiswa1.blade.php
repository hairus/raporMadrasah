@extends('layouts.app')
@section('title','Edit Siswa')
@section('content')
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
    <div class="col-md-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Biodata Siswa</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"><i
                                class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left input_mask" action="{{ url('/admin/updateSiswas') }}"
                      method="post">
                    {{ csrf_field() }}

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input name="id" type="hidden" class="form-control has-feedback-left" id="inputSuccess2"
                               placeholder="nama siswa" value="{{ $siswa->id }}">
                        <input name="nama" type="text" class="form-control has-feedback-left" id="inputSuccess2"
                               placeholder="nama siswa" value="{{ $siswa->nama }}">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input name="alamat" type="text" class="form-control has-feedback-left" id="inputSuccess2"
                               placeholder="Kelas" value="{{ $siswa->almt }}" >
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input name="nis" type="text" class="form-control has-feedback-left" id="inputSuccess2"
                               placeholder="Kelas" value="{{ $siswa->nis }}" disabled>
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input name="na" type="text" class="form-control has-feedback-left" id="inputSuccess2"
                               placeholder="Kelas" value="{{ $siswa->na }}" disabled>
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input name="ni" type="text" class="form-control has-feedback-left" id="inputSuccess2"
                               placeholder="Kelas" value="{{ $siswa->ni }}" disabled>
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input name="pa" type="text" class="form-control has-feedback-left" id="inputSuccess2"
                               placeholder="Kelas" value="{{ $siswa->kls }}" disabled>
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input name="tempat" type="text" class="form-control has-feedback-left" id="inputSuccess2"
                               placeholder="tempat" value="{{ $siswa->tempat }}" required>
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input name="tgl_lahir" type="text" class="form-control has-feedback-left" id="inputSuccess2"
                               placeholder="tgl_lahir contoh 01-12-2025" value="{{ $siswa->tgl_lahir }}" required>
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <a href=" {{ url('/admin/inputSiswa') }}">
                            <button type="button" class="btn btn-primary">Cancel</button>
                            </a>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
