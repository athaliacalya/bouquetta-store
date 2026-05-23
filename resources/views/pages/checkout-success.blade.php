@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
<div style="padding:4rem 5%;text-align:center">
    <h1 style="font-size:2rem;color:#E91E63;margin-bottom:1rem">
        🌸 Pesanan Berhasil!
    </h1>

    <p style="margin-bottom:1rem">
        Terima kasih sudah memesan di Bouquetta.
    </p>

    <p style="margin-bottom:2rem">
        Nomor Pesanan:
        <strong>{{ $order->order_number }}</strong>
    </p>

    <a href="{{ route('home') }}"
       style="background:#E91E63;color:#fff;padding:1rem 2rem;border-radius:50px;text-decoration:none">
        Kembali ke Home
    </a>
</div>
@endsection