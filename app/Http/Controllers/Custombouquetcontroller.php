<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Flower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomBouquetController extends Controller
{
    public function index()
    {
        $flowers = Flower::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('custom-bouquet.index', compact('flowers'));
    }

    public function store(Request $request)
    {
        // ── 1. Validasi ────────────────────────────────────────────────────
        $request->validate([
            'bouquet_name'        => 'nullable|string|max:100',
            'flowers'             => 'required|array|min:1',
            'flowers.*.flower_id' => 'required|exists:flowers,id',
            'flowers.*.qty'       => 'required|integer|min:1|max:50',
        ], [
            'flowers.required'           => 'Pilih setidaknya satu jenis bunga.',
            'flowers.*.flower_id.exists' => 'Bunga tidak ditemukan.',
            'flowers.*.qty.min'          => 'Jumlah bunga minimal 1 batang.',
        ]);

        // ── 2. Cek minimal 3 batang ────────────────────────────────────────
        $totalStems = collect($request->flowers)->sum('qty');

        if ($totalStems < 3) {
            return back()->withInput()->withErrors([
                'total_stems' => 'Minimal 3 bunga untuk membuat bouquet. Saat ini kamu memilih ' . $totalStems . ' batang.'
            ]);
        }

        // ── 3. Ambil data bunga & hitung harga ────────────────────────────
        $flowerIds = collect($request->flowers)->pluck('flower_id');
        $flowers   = Flower::whereIn('id', $flowerIds)->get()->keyBy('id');

        $totalPrice  = 0;
        $flowerSlugs = [];
        $flowerNames = [];

        foreach ($request->flowers as $item) {
            $flower = $flowers->get($item['flower_id']);
            if (!$flower) continue;

            $totalPrice   += $flower->price * $item['qty'];
            $flowerSlugs[] = strtolower($flower->name);
            $flowerNames[] = $flower->name . ' ×' . $item['qty'];
        }

        // ── 4. Buat nama bouquet ──────────────────────────────────────────
        $bouquetName = $request->bouquet_name
            ?: 'Custom: ' . implode(', ', array_slice($flowerNames, 0, 2))
                . (count($flowerNames) > 2 ? ' +lainnya' : '');

        // ── 5. Simpan ke cart (pakai sistem session yang sudah ada) ────────
        CartItem::create([
            'session_id'       => session()->getId(),
            'user_id'          => Auth::id(),
            'product_name'     => $bouquetName,
            'flower_ids'       => $flowerSlugs,
            'personal_message' => implode(', ', $flowerNames) . ' | Total ' . $totalStems . ' batang',
            'price'            => $totalPrice,
            'quantity'         => 1,
        ]);

        return redirect()->route('cart.index')
            ->with('success', 'Bouquet custom berhasil ditambahkan ke keranjang!');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'flowers'             => 'required|array',
            'flowers.*.flower_id' => 'required|exists:flowers,id',
            'flowers.*.qty'       => 'required|integer|min:0',
        ]);

        $flowerIds = collect($request->flowers)->where('qty', '>', 0)->pluck('flower_id');
        $flowers   = Flower::whereIn('id', $flowerIds)->get()->keyBy('id');

        $totalPrice = 0;
        $totalStems = 0;
        $items      = [];

        foreach ($request->flowers as $item) {
            if ($item['qty'] <= 0) continue;
            $flower = $flowers->get($item['flower_id']);
            if (!$flower) continue;

            $subtotal    = $flower->price * $item['qty'];
            $totalPrice += $subtotal;
            $totalStems += $item['qty'];
            $items[]     = [
                'name'     => $flower->name,
                'qty'      => $item['qty'],
                'subtotal' => $subtotal,
            ];
        }

        return response()->json([
            'items'       => $items,
            'total_stems' => $totalStems,
            'total_price' => $totalPrice,
            'formatted'   => [
                'total_price' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
            ],
            'valid'   => $totalStems >= 3,
            'message' => $totalStems < 3
                ? 'Minimal 3 bunga (' . $totalStems . '/3 batang)'
                : $totalStems . ' batang dipilih ✓',
        ]);
    }
}