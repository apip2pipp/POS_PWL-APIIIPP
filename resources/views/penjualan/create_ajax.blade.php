<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
            <div class="form-group">
                <label>User</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">- Pilih User -</option>
                    @foreach($user as $user)
                        <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
                    @endforeach
                </select>
                <small id="error-user_id" class="error-text form-text text-danger"></small>
            </div>

            <div class="form-group">
                <label>Nama Pembeli</label>
                <input value="" type="text" name="pembeli" id="pembeli" class="form-control" required>
                <small id="error-pembeli" class="error-text form-text text-danger"></small>
            </div>

            <div class="form-group">
                <label>Kode Penjualan</label>
                <input value="" type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" required>
                <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
            </div>

            <div class="form-group">
                <label>Tanggal Penjualan</label>
                <input type="datetime-local" name="penjualan_tanggal" id="penjualan_kode" class="form-control" required>
                <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
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
        $("#form-tambah").validate({
            rules: {
                user_id: { required: true },
                pembeli: { required: true },
                penjualan_kode: { required: true },
                penjualan_tanggal: { required: true }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#modal-master').modal('hide'); // ID modal yang sesuai
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataPenjualan.ajax.reload(); // pastikan variable ini sesuai dengan DataTable
                        } else {
                            $('.error-text').text(''); // clear all error text
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                }
                );
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