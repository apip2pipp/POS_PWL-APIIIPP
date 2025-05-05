@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title ?? 'Tambah Detail Penjualan' }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('penjualandetail.store') }}" class="form-horizontal">
            @csrf

            {{-- Penjualan --}}
            <div class="form-group row">
                <label class="col-2 col-form-label">Kode Penjualan</label>
                <div class="col-10">
                    <select name="penjualan_id" class="form-control" required>
                        <option value="">- Pilih Kode Penjualan -</option>
                        @foreach ($penjualan as $item)
                            <option value="{{ $item->penjualan_id }}" {{ old('penjualan_id') == $item->penjualan_id ? 'selected' : '' }}>
                                {{ $item->penjualan_kode ?? 'ID: '.$item->penjualan_id }}
                            </option>
                        @endforeach
                    </select>
                    @error('penjualan_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Barang --}}
            <div class="form-group row">
                <label class="col-2 col-form-label">Barang</label>
                <div class="col-10">
                    <select name="barang_id" class="form-control" required>
                        <option value="">- Pilih Barang -</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->barang_id }}" {{ old('barang_id') == $barang->barang_id ? 'selected' : '' }}>
                                {{ $barang->barang_kode }} - {{ $barang->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                    @error('barang_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>


            {{-- Harga --}}
            <div class="form-group row">
                <label class="col-2 col-form-label">Harga</label>
                <div class="col-10">
                    <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" required>
                    @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Jumlah --}}
            <div class="form-group row">
                <label class="col-2 col-form-label">Jumlah</label>
                <div class="col-10">
                    <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}" required>
                    @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Tombol --}}
            <div class="form-group row">
                <div class="col-10 offset-2">
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    <a href="{{ route('penjualandetail.index') }}" class="btn btn-sm btn-secondary ml-1">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
<script>
    $('#form_create').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ url('/penjualandetail/ajax') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                if (res.status) {
                    $('#modalAction').modal('hide'); // tutup modal
                    $('#table_detail').DataTable().ajax.reload(); // reload datatable

                    // Notifikasi sukses (pakai Bootstrap alert atau SweetAlert)
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: res.message
                    });
                } else {
                    // Tampilkan error validasi
                    $.each(res.msgField, function (key, value) {
                        $(`[name="${key}"]`).addClass('is-invalid');
                        $(`[name="${key}"]`).after(`<div class="invalid-feedback">${value[0]}</div>`);
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat menyimpan data.'
                });
            }
        });
    });
</script>