{{-- <html>
<head>
    <title>Data user</title>
</head>
<body>
    <h1>Data user</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
        </tr> --}}
        {{-- @foreach($data as $d) --}}
        {{-- <tr>
            <td>{{$data->user_id}}</td>
            <td>{{$data->username}}</td>
            <td>{{$data->name}}</td>
            <td>{{$data->level_id}}</td>
        </tr> --}}
        {{-- @endforeach --}}
    {{-- </table>
</body>
</html> --}}

{{-- PRAKTIKUM 2.3 JOBSHEET 4 STEP 3 --}}
{{-- <!DOCTYPE html>  
<html>  
<head>  
    <title>User List</title>  
</head>  
<body>  
    <h1>Jumlah Pengguna dengan Level ID 2: {{ $data }}</h1>  
</body>  
</html>   --}}


{{-- practicum 2.6 jobsheet 4 step2 --}}
{{-- <html>
<head>
    <title>Data user</title>
    
</head>
<body>
    <h1>Data user</h1>
    <a href="{{route('/user/tambah')}}">tambah User</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
            <th>Aksi</th>
        </tr> --}}
        {{-- @foreach($data as $d)
        <tr>
            <td>{{$d->user_id}}</td>
            <td>{{$d->username}}</td>
            <td>{{$d->name}}</td>
            <td>{{$d->level_id}}</td>
            <td><a href="{{route('/user/ubah',$d->user_id)}}">ubah</a> | <a href="{{route('/user/hapus',$d->user_id)}}">Hapus</a></td>
        </tr> --}}
        {{-- @endforeach
    </table>
</body> --}}
{{-- </html> --}}

<body>
    <h1>Data User</h1>
    <a href="/user/tambah">Tambah User</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Nama</td>
            <td>ID Level Pengguna</td>
            <td>Kode Level</td>
            <td>Nama Level</td>
            <td>Aksi</td>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->user_id }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->level_id }}</td>
            <td>{{ $d->level->level_kode }}</td>
            <td>{{ $d->level->level_nama }}</td>
            <td>
                <a href="/user/ubah/{{ $d->user_id }}">Ubah</a> | 
                <a href="/user/hapus/{{ $d->user_id }}">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
