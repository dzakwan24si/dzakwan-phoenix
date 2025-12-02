<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // <--- PENTING: Tambahkan ini

class UserController extends Controller
{
    public function index()
    {
        $data['dataUser'] = User::all();
        return view('admin.user.index', $data);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:100',
            'email' => ['required','email','unique:users,email'],
            'password' => 'required|min:8',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $data['name']     = $request->name;
        $data['email']    = $request->email;
        $data['role']    = $request->role;
        $data['password'] = Hash::make($request->password);

        // Logika Upload Foto
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $data['profile_picture'] = $path;
        }

        User::create($data);

        return redirect()->route('user.index')->with('success', 'Penambahan Data Berhasil!');
    }

    public function edit(string $id)
    {
        $data['dataUser'] = User::findOrFail($id);
        return view('admin.user.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'  => 'required|max:100',
            'email' => 'required|email|unique:users,email,'.$id, // Ignore unique for current user
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $dataUser = User::findOrFail($id);

        $dataUser->name = $request->name;
        $dataUser->email = $request->email;

        // Update password hanya jika diisi
        if($request->filled('password')){
             $dataUser->password = Hash::make($request->password);
        }

        // Logika Update Foto
        if ($request->hasFile('profile_picture')) {
            // 1. Hapus foto lama jika ada
            if ($dataUser->profile_picture && Storage::disk('public')->exists($dataUser->profile_picture)) {
                Storage::disk('public')->delete($dataUser->profile_picture);
            }

            // 2. Simpan foto baru
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $dataUser->profile_picture = $path;
        }

        $dataUser->save();
        return redirect()->route('user.index')->with('success','Data Berhasil Diupdate!');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Hapus file fisik foto jika ada sebelum hapus data user
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();
        return redirect()->route('user.index')->with('success','Data Berhasil Dihapus!');
    }
}
