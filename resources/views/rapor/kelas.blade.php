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
                <h2>Kelas</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left" action="{{url('rapor/formKep')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Kelas</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="select2_single form-control" tabindex="-1" name="kelas">
                                <option></option>
                                @foreach($kelas as $kls)
                                <option value="{{ $kls->id }}">Kelas {{ $kls->kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Semester</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="select2_single form-control" tabindex="-1" name="smt">
                                <option></option>
                                <option value="{{ $smt->smt }}">{{ $smt->smt }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="reset" class="btn btn-primary">Batal</button>
                            <button type="submit" class="btn btn-success">Pilih</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
