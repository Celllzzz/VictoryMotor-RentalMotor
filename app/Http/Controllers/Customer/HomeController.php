<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\{Motor, Merk};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Motor::where('status', 'tersedia')->with('merk');

        // Fitur Filter Merk (Opsional)
        if ($request->has('merk')) {
            $query->whereHas('merk', function($q) use ($request) {
                $q->where('merk', $request->merk);
            });
        }

        $motors = $query->get();
        $merks = Merk::all(); // Untuk dropdown filter

        return view('welcome', compact('motors', 'merks'));
    }

    public function detail($id)
    {
        $motor = Motor::with('merk')->findOrFail($id);
        return view('customer.detail', compact('motor'));
    }
}