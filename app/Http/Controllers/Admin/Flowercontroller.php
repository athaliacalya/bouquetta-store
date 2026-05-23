<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flower;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FlowerController extends Controller
{
    public function index(Request $request)
    {
        $flowers = Flower::when($request->search, fn($q) =>
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('meaning', 'like', "%{$request->search}%")
        )->orderBy('sort_order')->paginate(10)->withQueryString();

        return view('admin.flowers.index', compact('flowers'));
    }

    public function create()
    {
        return view('admin.flowers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:100',
            'meaning'         => 'required|string|max:255',
            'price'           => 'required|integer|min:0',
            'color_primary'   => 'required|string|max:20',
            'color_secondary' => 'required|string|max:20',
            'sort_order'      => 'integer|min:0',
            'is_active'       => 'boolean',
            'description'     => 'nullable|string|max:500',
        ]);

        $data['slug']      = Str::slug($request->name);
        $data['is_active'] = $request->boolean('is_active');

        // Ensure unique slug
        $slug  = $data['slug'];
        $count = 1;
        while (Flower::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $slug . '-' . $count++;
        }

        Flower::create($data);

        return redirect()->route('admin.flowers.index')
            ->with('success', "Bunga '{$data['name']}' berhasil ditambahkan!");
    }

    public function edit(Flower $flower)
    {
        return view('admin.flowers.edit', compact('flower'));
    }

    public function update(Request $request, Flower $flower)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:100',
            'meaning'         => 'required|string|max:255',
            'price'           => 'required|integer|min:0',
            'color_primary'   => 'required|string|max:20',
            'color_secondary' => 'required|string|max:20',
            'sort_order'      => 'integer|min:0',
            'description'     => 'nullable|string|max:500',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $flower->update($data);

        return redirect()->route('admin.flowers.index')
            ->with('success', "Bunga '{$flower->name}' berhasil diperbarui!");
    }

    public function destroy(Flower $flower)
    {
        $name = $flower->name;
        $flower->delete();

        return redirect()->route('admin.flowers.index')
            ->with('success', "Bunga '{$name}' berhasil dihapus!");
    }
}