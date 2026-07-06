<?php

namespace App\Http\Controllers\Admin;

use App\Models\Promo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->paginate(10);
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
            'is_active'   => 'boolean',
        ]);

        $data = $request->only(['title', 'description', 'start_date', 'end_date']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('promos');
        }

        Promo::create($data);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil dibuat!');
    }

    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
            'is_active'   => 'boolean',
        ]);

        $data = $request->only(['title', 'description', 'start_date', 'end_date']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('promos');
        }

        $promo->update($data);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil diperbarui!');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();

        return back()->with('success', 'Promo berhasil dihapus!');
    }
}
