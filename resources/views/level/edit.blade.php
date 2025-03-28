@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            @empty($level)
                <div class="alert alert-danger alert-dismissable">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('level') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form action="{{ url('/level/'.$level->level_id) }}" method="post" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kode Level</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="level_kode" name="level_kode" value="{{ old('level_kode', $level->level_kode) }}" required>

                            @error('level_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama Level</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="level_nama" name="level_nama" value="{{ old('level_nama', $level->level_nama) }}" required>

                            @error('level_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a href="{{ url('level') }}" class="btn btn-sm btn-default ml-1">Kembali</a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush