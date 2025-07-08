<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | The Flying Bookstore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="w-full min-h-screen flex items-center justify-center">
        <div class="w-full max-w-5xl rounded-2xl shadow-none flex flex-col md:flex-row overflow-hidden border border-gray-200" style="min-height: 600px;">
            <!-- Columna izquierda: registro -->
            <div class="flex-1 flex flex-col justify-center px-10 py-12 bg-[#FCFCF6] relative">
                <div class="absolute left-10 top-10 md:static md:mb-10 mb-6">
                    <img src="{{ asset('bookstore1.png') }}" alt="The Flying Bookstore" class="h-20">
                </div>
                <h2 class="text-3xl font-bold mb-8 text-gray-800 mt-20 md:mt-0">Crea Tu Cuenta</h2>
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold mb-1">Nombre</label>
                        <div class="relative">
                            <input id="name" name="name" type="text" required autofocus autocomplete="name" placeholder="Tu nombre completo" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <img src="{{ asset('icons/name.svg') }}" alt="Nombre" class="w-5 h-5">
                            </span>
                        </div>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold mb-1">Correo</label>
                        <div class="relative">
                            <input id="email" name="email" type="email" required autofocus autocomplete="username" placeholder="usuario@email.com" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <img src="{{ asset('icons/mail.svg') }}" alt="Correo" class="w-5 h-5">
                            </span>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-semibold mb-1">Contraseña</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="••••••••" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer">
                                <img id="eyeClosed" src="{{ asset('icons/eye-off.svg') }}" alt="Ocultar" class="w-5 h-5 block">
                                <img id="eyeOpen" src="{{ asset('icons/eye.svg') }}" alt="Mostrar" class="w-5 h-5 hidden">
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold mb-1">Confirmar Contraseña</label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="••••••••" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <button type="button" id="togglePasswordConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer">
                                <img id="eyeClosedConfirm" src="{{ asset('icons/eye-off.svg') }}" alt="Ocultar" class="w-5 h-5 block">
                                <img id="eyeOpenConfirm" src="{{ asset('icons/eye.svg') }}" alt="Mostrar" class="w-5 h-5 hidden">
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center gap-2">
                        <input id="privacy" name="privacy" type="checkbox" required class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="privacy" class="text-sm text-gray-700">Acepto la política de privacidad</label>
                    </div>
                    <button type="submit" class="w-full bg-[#0A2342] text-white py-2 rounded-lg font-semibold hover:bg-[#16335B] transition">Registrarse</button>
                </form>
                <div class="mt-6 text-center text-sm text-gray-700">
                    ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-[#F76C6C] font-semibold hover:underline">Inicia sesión aquí</a>
                </div>
            </div>
            <!-- Columna derecha: imagen -->
            <div class="hidden md:flex flex-1 bg-[#FCFCF6] items-center justify-center p-6">
                <img src="{{ asset('frame2.png') }}" alt="Ilustración" class="w-full h-full object-contain rounded-2xl" style="max-height: 540px;">
            </div>
        </div>
    </div>
    <script>
        // Password principal
        const togglePassword = document.getElementById('togglePassword');
        if (togglePassword) {
            const passwordInput = document.getElementById('password');
            const eyeClosed = document.getElementById('eyeClosed');
            const eyeOpen = document.getElementById('eyeOpen');
            togglePassword.addEventListener('click', function() {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                eyeClosed.classList.toggle('hidden', isHidden);
                eyeOpen.classList.toggle('hidden', !isHidden);
            });
        }
        // Password confirmación
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        if (togglePasswordConfirm) {
            const passwordInput = document.getElementById('password_confirmation');
            const eyeClosed = document.getElementById('eyeClosedConfirm');
            const eyeOpen = document.getElementById('eyeOpenConfirm');
            togglePasswordConfirm.addEventListener('click', function() {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                eyeClosed.classList.toggle('hidden', isHidden);
                eyeOpen.classList.toggle('hidden', !isHidden);
            });
        }
    </script>
</body>
</html>
