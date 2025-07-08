@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Mi Perfil</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('user.panel') }}" class="text-blue-700 hover:underline mb-4 inline-block">&larr; Volver al panel</a>
    
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Información personal</h2>
        <form action="{{ route('user.perfil.update') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold mb-1">Nombre completo</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2" required>
                @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block font-semibold mb-1">Correo electrónico</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2" required>
                @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block font-semibold mb-1">Fecha de registro</label>
                <input type="text" value="{{ $user->created_at->format('d/m/Y H:i') }}" class="w-full border rounded p-2 bg-gray-100" readonly>
            </div>
            <div class="pt-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Actualizar perfil</button>
            </div>
        </form>
    </div>
</div>
@endsection 