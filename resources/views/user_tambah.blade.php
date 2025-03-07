<body>
<h1>Form Tambah Data User</h1>
<a href="{{ route('/user') }}">Kembali</a>
<form method="post" action="{{ route('/user/tambah_simpan') }}">
{{ csrf_field() }}
<label>Username</label>
<input type="text" name="username" placeholder="Masukkan Username">
<br>
<label>Nama</label>
<input type="text" name="name" placeholder="Masukkan Nama">
<br>
<label>Password</label>
<input type="password" name="password" placeholder="Masukkan Password">
<br>
<label>Level ID</label>
<input type="number" name="level_id" placeholder="Masukkan level ID">
<br>
<input type="submit" name="btn" class="btn btn-success" value="Simpan">
</form>
</body>