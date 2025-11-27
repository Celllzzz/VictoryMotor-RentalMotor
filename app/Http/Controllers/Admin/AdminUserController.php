<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    // Tampilkan semua admin
    public function index()
    {
        // Ambil user yang role-nya admin, urutkan terbaru
        $admins = User::where('role', 'admin')->latest()->get();
        return view('admin.users.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    // Simpan Admin Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tbl_akun'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Set otomatis jadi admin
        ]);

        return redirect()->route('admin.users.index')->with('success', 'New admin successfully added!');
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.users.edit', compact('admin'));
    }

    // Update Admin
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tbl_akun,email,'.$admin->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Password boleh kosong jika tidak diganti
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
        ];

        // Jika password diisi, update password. Jika kosong, biarkan lama.
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Admin data updated!');
    }

    // Hapus Admin
    public function destroy($id)
    {
        $admin = User::findOrFail($id);

        // Cegah admin menghapus dirinya sendiri
        if (auth()->id() == $admin->id) {
            return back()->with('error', "You can't delete your own account!");
        }

        $admin->delete();

        return back()->with('success', 'Admin successfully deleted!');
    }
}