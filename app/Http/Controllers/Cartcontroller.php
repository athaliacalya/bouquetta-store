<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Flower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function sessionId(): string
    {
        return session()->getId();
    }

    private function getCart()
    {
        return CartItem::where('session_id', $this->sessionId())->get();
    }

    public function index()
    {
        $cartItems = $this->getCart();
        $total = $cartItems->sum(fn($i) => $i->price * $i->quantity);
        $deliveryFee = $cartItems->isEmpty() ? 0 : 25000;
        return view('pages.cart', compact('cartItems', 'total', 'deliveryFee'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_name'     => 'required|string|max:255',
            'flower_ids'       => 'required|array|min:1',
            'flower_ids.*'     => 'string',
            'personal_message' => 'nullable|string|max:1000',
            'price'            => 'required|integer|min:0',
        ]);

        CartItem::create([
            'session_id'       => $this->sessionId(),
            'user_id'          => Auth::id(),
            'product_name'     => $request->product_name,
            'flower_ids'       => $request->flower_ids,
            'personal_message' => $request->personal_message,
            'price'            => $request->price,
            'quantity'         => 1,
        ]);

        $count = $this->getCart()->count();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'count' => $count, 'message' => 'Bouquet ditambahkan ke keranjang!']);
        }

        return back()->with('success', 'Bouquet ditambahkan ke keranjang!');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->session_id !== $this->sessionId()) {
            abort(403);
        }
        $cartItem->delete();

        if (request()->expectsJson()) {
            $count = $this->getCart()->count();
            $total = $this->getCart()->sum(fn($i) => $i->price * $i->quantity);
            return response()->json(['success' => true, 'count' => $count, 'total' => $total]);
        }

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function count()
    {
        return response()->json(['count' => $this->getCart()->count()]);
    }
}