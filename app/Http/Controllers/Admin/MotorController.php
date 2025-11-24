<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotorController extends Controller
{
    public function index()
    {
        $motors = Motor::latest()->get();
        return view('admin.motor.index', compact('motors'));
    }

    public function create()
    {
        return view('admin.motor.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'merk' => 'required', // String biasa
            'warna' => 'required',
            'no_polisi' => 'required|unique:tbl_motor',
            'tahun_beli' => 'required|integer',
            'harga_sewa' => 'required|integer',
            'gambar' => 'required|image|max:2048',
        ]);

        // Upload Gambar
        $data['gambar'] = $request->file('gambar')->store('motor_images', 'public');
        $data['status'] = 'tersedia';

        Motor::create($data);

        return redirect()->route('admin.motor.index')->with('success', 'Motor berhasil ditambahkan');
    }

    public function edit(Motor $motor)
    {
        return view('admin.motor.edit', compact('motor'));
    }

    public function update(Request $request, Motor $motor)
    {
        $rules = [
            'nama' => 'required',
            'merk' => 'required',
            'warna' => 'required',
            'tahun_beli' => 'required|integer',
            'harga_sewa' => 'required|integer',
            'gambar' => 'nullable|image|max:2048',
        ];

        // Cek unik plat nomor jika berubah
        if ($request->no_polisi != $motor->no_polisi) {
            $rules['no_polisi'] = 'required|unique:tbl_motor';
        }

        $data = $request->validate($rules);

        // Cek jika ganti gambar
        if ($request->hasFile('gambar')) {
            if ($motor->gambar) Storage::disk('public')->delete($motor->gambar);
            $data['gambar'] = $request->file('gambar')->store('motor_images', 'public');
        }

        $motor->update($data);

        return redirect()->route('admin.motor.index')->with('success', 'Motor berhasil diupdate');
    }

    public function destroy(Motor $motor)
    {
        if ($motor->gambar) Storage::disk('public')->delete($motor->gambar);
        $motor->delete();
        return back()->with('success', 'Motor dihapus');
    }
}