@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ route('barang.import.excel') }}')" class="btn btn-sm btn btn-info mt-1">Import Barang</button>
                <a href="{{ route('barang.export.excel') }}" class="btn btn-sm btn-primary mt-1">
                    <i class="fa fa-file-excel"></i> Export Barang Excel
                </a>

                <a href="{{ route('barang.export.pdf') }}" class="btn btn-sm btn-warning mt-1">
                    <i class="fa fa-fa-file-pdf"></i> Export Barang PDF
                </a>
                <button onclick="modalAction('{{ route('barang.create-ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="barang_kode" id="barang_id" class="form-control">
                                <option value="">- Semua -</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->barang_id }}">{{ $item->barang_kode }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Barang Kode</small>
                        </div>
                    </div>
                </div>
            </div>

            <table id="table-barang" class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div 
        id="myModal" 
        class="modal fade animate shake" 
        tabindex="-1" role="dialog" 
        data-backdrop="static" 
        data-keyboard="false" 
        data-width="75%" 
        aria-hidden="true">
    </div>
@endsection

@push('js')
<script>
    function modalAction(url) {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    let dataBarang;
    $(document).ready(() => {
        dataBarang = $('#table-barang').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ route('barang.list') }}",
                "dataType": "json",
                "type": "POST",
                "data": (d) => {
                    d.barang_id = $('#barang_id').val()
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "barang_kode",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "barang_nama",
                    className: "",
                    width: "37%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "harga_beli",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        return new Intl.NumberFormat('id-ID').format(data);
                    }
                },
                {
                    data: "harga_jual",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        return new Intl.NumberFormat('id-ID').format(data);
                    }
                },
                {
                    data: "aksi",
                    className: "",
                    width: "14%",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#barang_id').on('change', () => {
            dataBarang.ajax.reload();
        });

        $('#table-barang_filter input').unbind().on('keyup', function(e) {
            if (e.keyCode == 13) {
                dataBarang.search(this.value).draw();
            }
        });

       
    });
</script>
@endpush