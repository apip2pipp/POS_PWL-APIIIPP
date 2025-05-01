    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register Pengguna</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <h2><strong>BIKIN AKUN BURU!!</strong></h2>
                </div>
                <div class="card-body">
                    <form id="form-register" action="{{ route('signup.post') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" name="nama" class="form-control" placeholder="Nama">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <select name="level_id" class="form-control">
                                <option value="" disabled selected>Select User Level</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user-tag"></span>
                                </div>
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="col-8">
                                <a href="{{ route('login') }}">Sudah punya akun?</a>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- jQuery -->
        <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
        <!-- jQuery Validation -->
        <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
        <!-- SweetAlert2 -->
        <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#form-register').validate({
                    rules: {
                        username: { required: true, minlength: 4, maxlength: 20, nowhitespace: true },
                        nama: { required: true, minlength: 4, maxlength: 100 },
                        password: { required: true, minlength: 6, maxlength: 20 },
                        password_confirmation: { required: true, equalTo: '[name="password"]' }
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pendaftaran akun berhasil!',
                                    text: res.message
                                }).then(() => {
                                    window.location = res.redirect;
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Registration Failed',
                                    text: xhr.responseJSON ? xhr.responseJSON.message : 'Gagal mendaftar akun!'
                                });
                            }
                        });
                        return false;
                    }
                });
            });
        </script>
    </body>

    </html>