<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotorController extends Controller
{
    public function index(Request $request)
    {
        $query = Motor::query();

        // 1. SMART SEARCH LOGIC (Multi-word)
        if ($request->has('search') && $request->search != '') {
            $keywords = explode(' ', $request->search); // Pecah kalimat jadi kata-kata
            
            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function($subQ) use ($word) {
                        $subQ->where('nama', 'like', "%{$word}%")
                            ->orWhere('merk', 'like', "%{$word}%")
                            ->orWhere('warna', 'like', "%{$word}%")
                            ->orWhere('no_polisi', 'like', "%{$word}%");
                    });
                }
            });
        }

        // 2. Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 3. Pagination
        $perPage = $request->input('per_page', 10);
        $motors = $query->latest()->paginate($perPage)->withQueryString();

        // Jika request dari AJAX (Ketik-ketik), return view utuh (akan diparsing JS)
        return view('admin.motor.index', compact('motors'));
    }

    public function create()
    {
        return view('admin.motor.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'merk' => 'required|string|max:255', // Input manual string
            'warna' => 'required|string',
            'no_polisi' => 'required|unique:tbl_motor,no_polisi',
            'tahun_beli' => 'required|integer|min:2000|max:'.(date('Y')+1),
            'harga_sewa' => 'required|integer|min:0',
            'gambar' => 'required|image|max:2048', // Max 2MB
        ]);

        // Upload Gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('motor_images', 'public');
        }
        
        $data['status'] = 'tersedia'; // Default status

        Motor::create($data);

        return redirect()->route('admin.motor.index')->with('success', 'Motorbike added successfully!');
    }

    public function edit(Motor $motor)
    {
        return view('admin.motor.edit', compact('motor'));
    }

    public function update(Request $request, Motor $motor)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'warna' => 'required|string',
            'tahun_beli' => 'required|integer',
            'harga_sewa' => 'required|integer',
            'gambar' => 'nullable|image|max:2048',
        ];

        // Cek unik plat nomor kecuali milik motor ini sendiri
        if ($request->no_polisi != $motor->no_polisi) {
            $rules['no_polisi'] = 'required|unique:tbl_motor,no_polisi';
        }

        $data = $request->validate($rules);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada (dan bukan placeholder/link luar)
            if ($motor->gambar && !filter_var($motor->gambar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($motor->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('motor_images', 'public');
        }

        $motor->update($data);

        return redirect()->route('admin.motor.index')->with('success', 'Motorbike data updated!');
    }

    public function destroy(Motor $motor)
    {
        // Hapus gambar fisik
        if ($motor->gambar && !filter_var($motor->gambar, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($motor->gambar);
        }
        
        $motor->delete();
        return back()->with('success', 'Motorbike successfully removed!');
    }
}