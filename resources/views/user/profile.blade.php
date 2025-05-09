@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Profile Picture Section -->
            <div class="col-md-4 text-center">
                <div class="profile-picture-container mb-3">
                    <img id="profile-image" src="{{ asset((auth()->user()->photo_profile == null) ? 'storage/unknown-profile-pict.jpg' : 'storage/img/' . $user->photo_profile) }}"
                        class="img-circle elevation-2" alt="User Image" style="width: 150px; height: 150px; object-fit: cover;">

                    <div class="mt-3">
                        <!-- Edit Button for Profile Picture -->
                        <button id="btn-edit-photo" type="button" class="btn btn-primary btn-sm">
                            <i class="fas fa-camera mr-1"></i> Edit foto profil
                        </button>
                    </div>
                </div>

                <!-- Form for Profile Picture Upload -->
                <form id="profile-picture-form" style="display: none;">
                    @csrf
                    <input type="file" name="image" id="image" accept="image/*">
                </form>
            </div>

            <!-- User Info Section -->
            <div class="col-md-8">
                <h4>Informasi Akun</h4>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%">Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ $user->getRoleName() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>








<script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.getElementById("btn-edit-photo").addEventListener("click", () => {
        Swal.fire({
                title: 'Perbarui Foto Profil',
                text: 'Mohon unggah foto profil terbaru anda',
                icon: 'question',
                input: 'file',
                inputAttributes: {
                    accept: 'image/*',
                    'aria-label': 'Unggah foto profil anda'
                },
                showCancelButton: true,
                confirmButtonText: 'Unggah',
                cancelButtonText: 'Batalkan',
                preConfirm: (file) => {
                    if (!file) {
                        Swal.showValidationMessage('You need to upload an image file!');
                        return false;
                    }

                    const formData = new FormData();
                    formData.append("photo", file);
                    formData.append("_method", "PATCH");

                    fetch('{{ route('user.profile.update-photo-profile') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        body: formData
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }

                            response.json();
                        })
                        .then(data => {
                            console.log(data);
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('Error uploading the image:', error);
                        });
                    return file;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Sukses!',
                        'Foto profil berhasil diperbarui',
                        'success'
                    );
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Dibatalkan!',
                        'Foto profil tidak jadi diperbarui',
                        'info'
                    );
                }
            });
    });
</script>
@endsection