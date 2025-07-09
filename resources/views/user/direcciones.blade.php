@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Mis Direcciones</h1>
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        
        <a href="{{ route('user.panel') }}" class="text-blue-700 hover:underline mb-4 inline-block">&larr; Volver al panel</a>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Formulario para agregar dirección -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-xl font-semibold mb-4 text-[#16183E]">Agregar nueva dirección</h2>
                <form action="{{ route('user.direcciones.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block font-semibold mb-1 flex items-center gap-2">
                            <img src='{{ asset('icons/direccionnaranja.svg') }}' class='w-5 h-5'> Dirección
                        </label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}" class="w-full border rounded p-2 focus:ring-2 focus:ring-[#EAA451]" required>
                        @error('direccion')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block font-semibold mb-1 flex items-center gap-2">
                                <img src='{{ asset('icons/ciudadnaranja.svg') }}' class='w-5 h-5'> Departamento
                            </label>
                            <select name="departamento" value="{{ old('departamento') }}" class="w-full border rounded p-2 focus:ring-2 focus:ring-[#EAA451]" required>
                                @php $deps = ["Amazonas","Áncash","Apurímac","Arequipa","Ayacucho","Cajamarca","Callao","Cusco","Huancavelica","Huánuco","Ica","Junín","La Libertad","Lambayeque","Lima","Loreto","Madre de Dios","Moquegua","Pasco","Piura","Puno","San Martín","Tacna","Tumbes","Ucayali"]; @endphp
                                <option value="">Seleccione departamento</option>
                                @foreach($deps as $dep)
                                    <option value="{{ $dep }}" {{ old('departamento') == $dep ? 'selected' : '' }}>{{ $dep }}</option>
                                @endforeach
                            </select>
                            @error('departamento')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                        </div>
                        <div class="w-1/2">
                            <label class="block font-semibold mb-1 flex items-center gap-2">
                                <img src='{{ asset('icons/ciudadnaranja.svg') }}' class='w-5 h-5'> Ciudad
                            </label>
                            <input type="text" name="ciudad" value="{{ old('ciudad') }}" class="w-full border rounded p-2 focus:ring-2 focus:ring-[#EAA451]" required>
                            @error('ciudad')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 flex items-center gap-2">
                            <img src='{{ asset('icons/referencia.svg') }}' class='w-5 h-5'> Referencia (opcional)
                        </label>
                        <input type="text" name="referencia" value="{{ old('referencia') }}" class="w-full border rounded p-2 focus:ring-2 focus:ring-[#EAA451]">
                        @error('referencia')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 flex items-center gap-2">
                            <img src='{{ asset('icons/telefononaranja.svg') }}' class='w-5 h-5'> Teléfono
                        </label>
                        <input type="tel" name="telefono" value="{{ old('telefono') }}" class="w-full border rounded p-2 focus:ring-2 focus:ring-[#EAA451]" required pattern="[0-9]{9}" maxlength="9" minlength="9" title="Debe ser un número de 9 dígitos" inputmode="numeric">
                        <span class="text-xs text-gray-500">Debe ser un número de 9 dígitos</span>
                        @error('telefono')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div class="pt-4 flex justify-center">
                        <button type="submit" class="bg-[#EAA451] text-white px-8 py-2 rounded hover:bg-orange-500 transition-colors font-semibold shadow">Agregar dirección</button>
                    </div>
                </form>
            </div>

            <!-- Listado de direcciones -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-xl font-semibold mb-4 text-[#16183E]">Mis direcciones</h2>
                @if($direcciones->isEmpty())
                    <div class="text-gray-500 text-center">No tienes direcciones guardadas.<br><a href="#" class="text-[#EAA451] hover:underline">Agrega tu primera dirección</a></div>
                @else
                    <div class="space-y-4">
                        @foreach($direcciones as $direccion)
                            <div class="border rounded-xl p-4 shadow flex items-center gap-4 bg-gray-50">
                                <div class="flex-1">
                                    <div class="font-semibold text-lg flex items-center gap-2 mb-1">
                                        <img src='{{ asset('icons/direccionnaranja.svg') }}' class='w-5 h-5'> {{ $direccion->direccion }}
                                    </div>
                                    <div class="text-gray-600 flex items-center gap-2 mb-1">
                                        <img src='{{ asset('icons/ciudadnaranja.svg') }}' class='w-4 h-4'> {{ $direccion->departamento }}, {{ $direccion->ciudad }}
                                    </div>
                                    @if($direccion->referencia)
                                        <div class="text-sm text-gray-500 flex items-center gap-2 mb-1">
                                            <img src='{{ asset('icons/referencianaranja.svg') }}' class='w-4 h-4'> Ref: {{ $direccion->referencia }}
                                        </div>
                                    @endif
                                    <div class="text-sm text-gray-500 flex items-center gap-2">
                                        <img src='{{ asset('icons/telefononaranja.svg') }}' class='w-4 h-4'> {{ $direccion->telefono }}
                                    </div>
                                </div>
                                <form action="{{ route('user.direcciones.destroy', $direccion->id) }}" method="POST" class="ml-4">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-full bg-white shadow border border-gray-200 hover:bg-red-50 hover:border-red-300 transition" onclick="return confirm('¿Estás seguro de eliminar esta dirección?')" title="Eliminar dirección">
                                        <img src="{{ asset('icons/equis.svg') }}" alt="Eliminar" class="w-5 h-5 text-red-500">
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection 