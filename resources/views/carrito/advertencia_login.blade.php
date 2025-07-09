@extends('layouts.app')

@section('content')
<div class="container mx-auto py-16 flex flex-col items-center justify-center min-h-[60vh]">
    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full text-center">
        <svg class="mx-auto mb-4 w-16 h-16 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h2 class="text-2xl font-bold mb-2 text-[#16183E]">¡Debes iniciar sesión!</h2>
        <p class="text-gray-600 mb-6">Para continuar con tu compra necesitas crear una cuenta o iniciar sesión.<br>Así podrás llevar el control de tus pedidos y favoritos.</p>
        <div class="flex flex-col gap-3">
            <a href="{{ route('login') }}" class="bg-[#EAA451] text-white px-6 py-2 rounded hover:bg-[#FF9921] transition-colors font-semibold">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="bg-[#00254F] border border-[#00254F] text-white px-6 py-2 rounded hover:bg-[#16183E] hover:text-white transition-colors font-semibold">Crear cuenta</a>
           
        </div>
    </div>
</div>
@endsection 