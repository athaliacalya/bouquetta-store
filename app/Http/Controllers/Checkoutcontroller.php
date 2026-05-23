<?php

namespace App\Http\Controllers;

use App\Models\Bouquet;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    private function sessionId(): string
    {
        return session()->getId();
    }

    public function index()
    {
        $cartItems = CartItem::where('session_id', $this->sessionId())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        $subtotal    = $cartItems->sum(fn($i) => $i->price * $i->quantity);
        $deliveryFee = 25000;
        $total       = $subtotal + $deliveryFee;
        $user        = Auth::user();

        return view('pages.checkout', compact('cartItems', 'subtotal', 'deliveryFee', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $cartItems = CartItem::where('session_id', $this->sessionId())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email|max:255',
            'customer_phone'   => 'required|string|max:20',
            'delivery_address' => 'required|string|max:1000',
            'delivery_city'    => 'required|string|max:100',
            'delivery_notes'   => 'nullable|string|max:500',
            'personal_letter'  => 'nullable|string|max:2000',
            'payment_method'   => 'required|in:transfer,cod,qris',
        ]);

        $subtotal    = $cartItems->sum(fn($i) => $i->price * $i->quantity);
        $deliveryFee = 25000;

        // Create a bouquet record for the first cart item
        $firstItem = $cartItems->first();
        $bouquet = Bouquet::create([
            'code'        => strtoupper(Str::random(8)),
            'flower_ids'  => $firstItem->flower_ids,
            'message'     => $firstItem->personal_message,
            'total_price' => $subtotal,
            'status'      => 'pending',
            'user_id'     => Auth::id(),
            'ip_address'  => $request->ip(),
        ]);

        $order = Order::create([
            'order_number'     => 'BQT-' . strtoupper(Str::random(8)),
            'bouquet_id'       => $bouquet->id,
            'user_id'          => Auth::id(),
            'customer_name'    => $request->customer_name,
            'customer_email'   => $request->customer_email,
            'customer_phone'   => $request->customer_phone,
            'delivery_address' => $request->delivery_address,
            'delivery_city'    => $request->delivery_city,
            'delivery_notes'   => $request->delivery_notes,
            'personal_letter'  => $request->personal_letter,
            'subtotal'         => $subtotal,
            'delivery_fee'     => $deliveryFee,
            'total'            => $subtotal + $deliveryFee,
            'status'           => 'pending',
            'payment_method'   => $request->payment_method,
            'payment_status'   => 'unpaid',
        ]);

        // Clear cart
        CartItem::where('session_id', $this->sessionId())->delete();

        return redirect()->route('checkout.success', $order->order_number)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        return view('pages.checkout-success', compact('order'));
    }
}