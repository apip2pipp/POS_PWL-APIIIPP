@empty($stok)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/stok') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/stok/' . $stok->stok_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Stok</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Barang --}}
                    <div class="form-group">
                        <label>Barang</label>
                        <select name="barang_id" id="barang_id" class="form-control" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach($barang as $barang)
                                <option value="{{ $barang->barang_id }}" @if($stok->barang_id == $barang->barang_id) selected @endif>
                                    {{ $barang->barang_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-barang_id" class="error-text form-text text-danger"></small>
                    </div>

                    {{-- User --}}
                    <div class="form-group">
                        <label>User</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">- Pilih User -</option>
                            @foreach($user as $user)
                                <option value="{{ $user->user_id }}" @if($stok->user_id == $user->user_id) selected @endif>
                                    {{ $user->nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-user_id" class="error-text form-text text-danger"></small>
                    </div>

                    {{-- Tanggal --}}
                    <div class="form-group">
                        <label>Tanggal Stok</label>
                        <input type="datetime-local" name="stok_tanggal" id="stok_tanggal" class="form-control"
                            value="{{ date('Y-m-d\TH:i', strtotime($stok->stok_tanggal)) }}" required>
                        <small id="error-stok_tanggal" class="error-text form-text text-danger"></small>
                    </div>

                    {{-- Jumlah --}}
                    <div class="form-group">
                        <label>Jumlah Stok</label>
                        <input type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" value="{{ $stok->stok_jumlah }}" min="1" required>
                        <small id="error-stok_jumlah" class="error-text form-text text-danger"></small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#form-edit").validate({
                rules: {
                    barang_id: { required: true },
                    user_id: { required: true },
                    stok_tanggal: { required: true },
                    stok_jumlah: { required: true, min: 1 }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        method: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide'); // pastikan ID modal = #myModal
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });

                                // Reload datatable
                                if (typeof dataStok !== 'undefined') {
                                    dataStok.ajax.reload(null, false); // false = tidak reset pagination
                                }
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan pada server.'
                            });
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty