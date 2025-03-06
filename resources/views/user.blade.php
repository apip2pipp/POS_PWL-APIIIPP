<html>
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
        </tr>
        {{-- @foreach($data as $d) --}}
        <tr>
            <td>{{$data->user_id}}</td>
            <td>{{$data->username}}</td>
            <td>{{$data->name}}</td>
            <td>{{$data->level_id}}</td>
        </tr>
        {{-- @endforeach --}}
    </table>
</body>
</html>