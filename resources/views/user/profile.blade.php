@extends('layouts.template')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex flex-col md:flex-row items-center md:items-start">
            <div class="w-32 h-32 mb-4 md:mb-0 md:mr-6">
                <img class="w-full h-full object-cover rounded-full border"
                    src="{{ asset((auth()->user()->photo_profile == null) ? 'storage/unknown-profile-pict.jpg' : 'storage/img/' . $user->photo_profile) }}"
                    alt="Profile Picture">
            </div>

            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    {{ $user->nama }}
                    <span class="ml-2 text-gray-600">@ {{ $user->username }}</span>
                </h2>
                <div class="mt-4">
                    <div>
                        <button id="btn-edit-photo" type="button" class="btn btn-primary">Edit foto profil</button>
                    </div>
                </div>
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