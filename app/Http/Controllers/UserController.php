<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index()
    {

        $breadcrumb = (object) [
            'title' => 'User',
            'list' => ['Home', 'User']
        ];
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
        $activeMenu = 'user';

        $level = LevelModel::all();
        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'level' => $level, 'activeMenu' => $activeMenu]);

    }

    // Ambil data user dalam bentuk json untuk datatables
//     public function list(Request $request){
//     $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
//         ->with('level');

//     // Filter data user berdasarkan level_id
//     if ($request->level_id) {
//         $users->where('level_id', $request->level_id);
//     }

//     return DataTables::of($users)
//         ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
//         ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
//             // $btn digunakan untuk membuat tombol dengan aksi tertentu
//             /* $btn = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
//             $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
//             $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user->user_id).'">'
//                 . csrf_field() . method_field('DELETE') .
//                 '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button></form>'; */

//             $btn = '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
//             $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
//             $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

//             return $btn;
//         })
//         ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
//         ->make(true);
// }

public function list(Request $request){
    $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
        ->with('level');

    // Filter data user berdasarkan level_id
    if ($request->level_id) {
        $users->where('level_id', $request->level_id);
    }

    return DataTables::of($users)
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
        ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
            // $btn digunakan untuk membuat tombol dengan aksi tertentu
            $btn = '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
}

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah user baru'
        ];
        $level = LevelModel::all();
        $activeMenu = 'user';
        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_id' => 'required | integer',
            'username' => 'required | string | min:3 | unique:m_user,username',
            'nama' => 'required | string | max:100',
            'password' => 'required | min:5'
        ]);

        UserModel::create([
            'level_id' => $request->level_id,
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/user')->with('success', 'Data user berhasil ditambahkan');
    }

    public function show($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail user'
        ];
        $user = UserModel::with('level')->find($id);
        $activeMenu = 'user';
        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }


    public function show_ajax(String $id){
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.show_ajax', compact('user', 'level'));

    }


    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();
        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit user'
        ];
        $activeMenu = 'user';
        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'level_id' => 'required | integer',
            'username' => 'required | string | min:3 | unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required | string | max:100',
            'password' => 'nullable | min:5'
        ]);

        $user = UserModel::find($id);
        $user->level_id = $request->level_id;
        $user->username = $request->username;
        $user->nama = $request->nama;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(int $id)
    {
        $check = UserModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }
        try {
            UserModel::destroy($id);
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'Data user tidak bisa dihapus karena masih terdapat data terkait');
        }
    }

    public function create_ajax(){
        $level = LevelModel::select('level_id','level_nama')->get();
        return view('user.create_ajax')
                    -> with ('level', $level);
    }

    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama'     => 'required|string|max:100',
                'password' => 'required|min:4'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                return response()->json([
                    'status'    => false, // response status, false: error/gagal, true: berhasil
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(), // pesan error validasi
                ]);
            }

            UserModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Ambil data user dalam bentuk json untuk datatables

//menampilkan halaman from edit user ajax
public function edit_ajax(string $id){
    $user= UserModel::find($id);
    $level= LevelModel::select('level_id','level_nama')->get();
    return view('user.edit_ajax',['user'=>$user,'level' =>$level]);
}

public function update_ajax(Request $request, $id){
    // cek apakah request dari ajax
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|max:20|unique:m_user,username,'.$id.',user_id',
            'nama'     => 'required|max:100',
            'password' => 'nullable|min:6|max:20'
        ];
// use Illuminate\Support\Facades\Validator;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,    // respon json, true: berhasil, false: gagal
                'message'  => 'Validasi gagal.',
                'msgField' => $validator->errors()  // menunjukkan field mana yang error
            ]);
        }

        $check = UserModel::find($id);
        if ($check) {
            if(!$request->filled('password') ){ // jika password tidak diisi, maka hapus dari request
                $request->request->remove('password');
            }

            $check->update($request->all());
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else{
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    return redirect('/');
}

public function confirm_ajax(string $id){
    $user = UserModel::find($id);

    return view ('user.confirm_ajax',['user' =>$user]);
}

public function delete_ajax(Request $request, $id)
{
    // cek apakah request dari ajax
    if ($request->ajax() || $request->wantsJson()) {
        $user = UserModel::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    return redirect('/');
}

public function showUserProfile()
    {
        return view('user.profile', [
            'breadcrumb' => (object) [
                'title' => 'Profil',
                'list' => ['Home', 'Profile']
            ],
            'page' => (object) [
                'title' => 'Profile'
            ],
            'user' => auth()->user(),
            'activeMenu' => 'profile'
        ]);
    }

    public function updateUserPhotoProfile(Request $req)
    {
        if (!$req->hasFile('photo') && !$req->file('photo')->isValid()) {
            return response()->json([
                "message" => "Image file is invalid"
            ], Response::HTTP_BAD_REQUEST);
        }

        $img = $req->file('photo');
        $path = $img->store('public/img');
        $filename = basename($path);

        $user = Auth::user();
        $user->photo_profile = $filename;
        $user->save();

        return response()->json([
            "message" => "Successfully update user photo profile",
        ], Response::HTTP_OK);
    }

     public function showImportModal()
    {
        return view('user.import-excel');
    }

    public function importExcel(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $rules = [
            'file_user' => ['required', 'mimes:xlsx', 'max:1024']
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $file = $req->file('file_user');

        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();

        $data = $sheet->toArray(null, false, true, true);

        $insert = [];
        if (count($data) <= 1) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ], Response::HTTP_BAD_REQUEST);
        }

        foreach ($data as $row => $val) {
            if ($row > 1) {
                $insert[] = [
                    'level_id' => $val['A'],
                    'username' => $val['B'],
                    'nama' => $val['C'],
                    'password' => bcrypt($val['D']),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        if (count($insert) > 0) {
            UserModel::insertOrIgnore($insert);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diimport'
        ], Response::HTTP_OK);
    }

    public function exportExcel()
    {
        $user = UserModel::select('level_id', 'username', 'nama')
            ->orderBy('level_id')
            ->with('level')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Level Kode')
            ->setCellValue('C1', 'Username')
            ->setCellValue('D1', 'Nama');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $no = 1;
        $row = 2;

        foreach ($user as $key => $value) {
            $sheet->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $value->level->level_kode)
                ->setCellValue('C' . $row, $value->username)
                ->setCellValue('D' . $row, $value->nama);
            $row++;
        }

        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Pengguna');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Pengguna ' . date('Y-m-d H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
    {
        $user = UserModel::select('level_id', 'username', 'nama')
            ->orderBy('level_id')
            ->with('level')
            ->get();

        $pdf = Pdf::loadView('user.export_pdf', [ 'user' => $user ])
                ->setPaper('A4', 'landscape')
                ->setOption('isRemoteEnabled', true)
                ->setOption('isHtml5ParserEnabled', true);

        $pdf->render();

        return $pdf->stream('Data Pengguna ' . date('Y-m-d H-i-s') . '.pdf');
    }
}
