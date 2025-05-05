@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('penjualan-detail/create') }}">Tambah</a>
                <button onclick="modalAction('{{ url('penjualan-detail/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" name="user_id" id="user_id">
                                <option value="">- Semua Username -</option>
                                @foreach($user as $item)
                                    <option value="{{ $item->detail_id }}">{{ $item->jumlah }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Data User</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan_detail">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Penjualan ID</th>
                        <th>Barang ID</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }
        var dataPenjualanDetail;
        $(document).ready(function () {
            dataPenjualanDetail = $('#table_penjualan_detail').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('penjualan-detail/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "penjualan_id", className: "", orderable: true, searchable: true },
                    { data: "barang_id", className: "", orderable: true, searchable: true },
                    { data: "harga", className: "", orderable: true, searchable: true },
                    { data: "jumlah", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush