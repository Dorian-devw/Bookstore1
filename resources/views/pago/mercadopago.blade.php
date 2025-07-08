@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12">
    <h1 class="text-2xl font-bold mb-6">Pagar con MercadoPago</h1>
    <div id="wallet_container" class="mb-8"></div>
    <a href="/" class="text-blue-600 hover:underline">Volver al inicio</a>
</div>
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
const mp = new MercadoPago('{{ config('services.mercadopago.public_key') }}', {
    locale: 'es-PE'
});
mp.bricks().create("wallet", "wallet_container", {
    initialization: {
        preferenceId: "{{ $preference->id }}"
    }
});
</script>
@endsection 