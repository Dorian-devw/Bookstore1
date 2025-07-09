@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 max-w-2xl flex flex-col items-left">
    <h1 class="text-3xl font-bold mb-6">Mi Perfil</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow text-center w-full">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('user.panel') }}" class="text-blue-700 hover:underline mb-4 inline-block self-start">&larr; Volver al panel</a>
    
    <div class="bg-white rounded-2xl shadow-lg p-8 w-full flex flex-col items-center">
        <!-- Sin avatar -->
        <h2 class="text-2xl font-semibold mb-6 text-[#16183E]">Información personal</h2>
        <form action="{{ route('user.perfil.update') }}" method="POST" class="space-y-5 w-full max-w-md">
            @csrf
            <div>
                <label class="block font-semibold mb-1 flex items-center gap-2">
                    <img src="{{ asset('icons/nombrenaranja.svg') }}" alt="Nombre" class="w-5 h-5">
                    Nombre completo
                </label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2 focus:ring-2 focus:ring-[#EAA451]" required>
                @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block font-semibold mb-1 flex items-center gap-2">
                    <img src="{{ asset('icons/correonaranja.svg') }}" alt="Correo" class="w-5 h-5">
                    Correo electrónico
                </label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2 focus:ring-2 focus:ring-[#EAA451]" required>
                @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block font-semibold mb-1 flex items-center gap-2">
                    <img src="{{ asset('icons/calendarionaranja.svg') }}" alt="Fecha de registro" class="w-5 h-5">
                    Fecha de registro
                </label>
                <input type="text" value="{{ $user->created_at->format('d/m/Y H:i') }}" class="w-full border rounded p-2 bg-gray-100" readonly>
            </div>
            <div class="pt-4 flex justify-center">
                <button type="submit" class="bg-[#EAA451] text-white px-8 py-2 rounded hover:bg-orange-500 transition-colors font-semibold shadow">Actualizar perfil</button>
            </div>
        </form>
    </div>
</div>
@endsection 