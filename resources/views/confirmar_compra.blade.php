@extends('layouts.app')

@section('content')
<div class="bg-[#FCFCF6] min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Barra de pasos -->
        <div class="flex items-center justify-center mb-10">
            <div class="flex items-center gap-4">
                <div class="flex flex-col items-center">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center bg-[#EAA451] text-white font-bold">✓</div>
                    <span class="text-xs mt-1 text-[#0A2342]">Complete la información</span>
                </div>
                <div class="w-24 h-1 bg-[#EAA451] rounded"></div>
                <div class="flex flex-col items-center">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center border-2 border-[#EAA451] bg-white text-[#EAA451] font-bold">2</div>
                    <span class="text-xs mt-1 text-[#0A2342]">Crear orden</span>
                </div>
                <div class="w-24 h-1 bg-gray-200 rounded"></div>
                <div class="flex flex-col items-center">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center border-2 border-gray-300 bg-white text-gray-400 font-bold">3</div>
                    <span class="text-xs mt-1 text-gray-400">Entrega</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Columna izquierda: Información editable -->
            <form id="formPedido" action="{{ route('pedido.procesar') }}" method="POST" class="bg-white rounded-lg shadow p-8 flex flex-col gap-8">
                @csrf
                <input type="hidden" name="metodo_pago" id="inputMetodoPago" value="">
                <div>
                    <h2 class="text-xl font-bold mb-4 text-[#0A2342]">Información del pedido</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nombre y segundo nombre</label>
                            <input type="text" id="inputNombre" name="nombre" value="{{ old('nombre', Auth::user()->name ?? '') }}" required class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Correo</label>
                            <input type="email" id="inputCorreo" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required class="w-full border rounded px-3 py-2">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">Seleccionar dirección guardada</label>
                            <select id="selectDireccion" class="w-full border rounded px-3 py-2">
                                <option value="">Selecciona una dirección o crea una nueva</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">Dirección completa</label>
                            <input type="text" id="inputDireccion" name="direccion_completa" value="{{ old('direccion_completa') }}" required class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Departamento</label>
                            <select id="inputDepartamento" name="departamento" class="w-full border rounded px-3 py-2" required>
                                <option value="">Seleccione departamento</option>
                                <option value="Amazonas">Amazonas</option>
                                <option value="Áncash">Áncash</option>
                                <option value="Apurímac">Apurímac</option>
                                <option value="Arequipa">Arequipa</option>
                                <option value="Ayacucho">Ayacucho</option>
                                <option value="Cajamarca">Cajamarca</option>
                                <option value="Callao">Callao</option>
                                <option value="Cusco">Cusco</option>
                                <option value="Huancavelica">Huancavelica</option>
                                <option value="Huánuco">Huánuco</option>
                                <option value="Ica">Ica</option>
                                <option value="Junín">Junín</option>
                                <option value="La Libertad">La Libertad</option>
                                <option value="Lambayeque">Lambayeque</option>
                                <option value="Lima" selected>Lima</option>
                                <option value="Loreto">Loreto</option>
                                <option value="Madre de Dios">Madre de Dios</option>
                                <option value="Moquegua">Moquegua</option>
                                <option value="Pasco">Pasco</option>
                                <option value="Piura">Piura</option>
                                <option value="Puno">Puno</option>
                                <option value="San Martín">San Martín</option>
                                <option value="Tacna">Tacna</option>
                                <option value="Tumbes">Tumbes</option>
                                <option value="Ucayali">Ucayali</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Ciudad</label>
                            <input type="text" id="inputCiudad" name="ciudad" value="{{ old('ciudad', 'Lima') }}" required class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Número de teléfono</label>
                            <input type="tel" id="inputTelefono" name="telefono" value="{{ old('telefono', Auth::user()->telefono ?? '') }}" required class="w-full border rounded px-3 py-2" pattern="[0-9]{9}" maxlength="9" minlength="9" title="Debe ser un número de 9 dígitos" inputmode="numeric">
                            <span class="text-xs text-gray-500">Debe ser un número de 9 dígitos</span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Fecha de entrega</label>
                            <input type="date" id="inputFecha" name="fecha_entrega" value="{{ old('fecha_entrega', date('Y-m-d', strtotime('+4 days'))) }}" required class="w-full border rounded px-3 py-2" min="{{ date('Y-m-d', strtotime('+4 days')) }}">
                        </div>
                        <div class="md:col-span-2">
                            <button type="button" onclick="guardarDireccionActual()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                                💾 Guardar esta dirección para futuras compras
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-4 text-[#0A2342]">Información para la entrega</h2>
                    <div class="space-y-2 text-sm text-[#0A2342]" id="infoEntrega">
                        <div class="flex items-center gap-2">Cliente <span class="font-semibold ml-2" id="entregaNombre">{{ old('nombre', Auth::user()->name ?? '') }}</span></div>
                        <div class="flex items-center gap-2">Fecha de entrega <span class="font-semibold ml-2" id="entregaFecha">{{ old('fecha_entrega', date('d/m/Y')) }}</span></div>
                        <div class="flex items-center gap-2">Dirección <span class="font-semibold ml-2" id="entregaDireccion">{{ old('direccion_completa') }}</span></div>
                        <div class="flex items-center gap-2">Número de teléfono <span class="font-semibold ml-2" id="entregaTelefono">{{ old('telefono', Auth::user()->telefono ?? '') }}</span></div>
                    </div>
                </div>
            </form>
            <!-- Columna derecha: Resumen y métodos de pago -->
            <div class="flex flex-col gap-8">
                <div class="bg-white rounded-lg shadow p-8 mb-4">
                    <h2 class="text-xl font-bold mb-4 text-[#0A2342]">Información de la compra</h2>
                    <div class="flex flex-col gap-2 text-sm">
                        <div class="flex justify-between items-center"><span>Cantidad de productos</span><span>{{ $carrito->sum('cantidad') }} unidades</span></div>
                        <div class="flex justify-between items-center"><span>Subtotal</span><span>S/ {{ number_format($total, 2) }}</span></div>
                        @if(($descuento ?? 0) > 0)
                        <div class="flex justify-between items-center text-green-600"><span>Cupón aplicado</span><span>- S/ {{ number_format($descuento, 2) }}</span></div>
                        @endif
                        <div class="flex justify-between items-center"><span>Costos de envío</span><span>S/ 15.00</span></div>
                        <div class="flex justify-between items-center font-bold text-lg mt-2"><span>Cantidad a pagar</span><span>S/ {{ number_format($total + 15 - ($descuento ?? 0), 2) }}</span></div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-8 mb-4">
                    <h2 class="text-xl font-bold mb-4 text-[#0A2342]">Métodos de Pago</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6" id="metodosPagoBtns">
                        <button type="button" onclick="seleccionarMetodoPago('transferencia')" class="metodo-pago-btn border-2 border-[#EAA451] rounded-lg p-4 flex flex-col items-center cursor-pointer bg-white w-full relative" disabled>
                            <img src="{{ asset('icons/transfer.svg') }}" alt="Transferencia" class="h-10 mb-2">
                            <span class="font-semibold mt-2 text-[#0A2342]">Transferencia Bancaria</span>
                        </button>
                        <button type="button" onclick="seleccionarMetodoPago('tarjeta')" class="metodo-pago-btn border-2 border-[#EAA451] rounded-lg p-4 flex flex-col items-center cursor-pointer bg-white w-full relative" disabled>
                            <img src="{{ asset('icons/atm.svg') }}" alt="Tarjeta" class="h-10 mb-2">
                            <span class="font-semibold mt-2 text-[#0A2342]">Tarjeta de crédito</span>
                        </button>
                        <button type="button" onclick="seleccionarMetodoPago('yape')" class="metodo-pago-btn border-2 border-[#EAA451] rounded-lg p-4 flex flex-col items-center cursor-pointer bg-white w-full relative" disabled>
                            <img src="{{ asset('icons/yapelogo.svg') }}" alt="Yape" class="h-10 mb-2">
                            <span class="font-semibold mt-2 text-[#0A2342]">Yape</span>
                        </button>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mt-8">
                    <button type="button" onclick="window.location='{{ route('carrito.index') }}'" class="bg-[#EAA451] hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded shadow flex items-center gap-2 w-max">Volver al carrito</button>
                    <button type="submit" form="formPedido" id="btnConfirmarCompra" class="w-full bg-[#0A2342] hover:bg-[#EAA451] text-white font-bold py-3 rounded-lg text-lg transition">CONFIRMAR COMPRA</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Transferencia Bancaria -->
<div id="modalTransferencia" class="modal-pago hidden">
    <div class="modal-bg" onclick="cerrarModal('modalTransferencia')"></div>
    <div class="modal-content">
        <h3 class="text-lg font-bold mb-4">Transferencia Bancaria</h3>
        <form id="formTransferencia" onsubmit="return simularPago('modalTransferencia')">
            <div class="mb-2">
                <label class="block text-sm font-medium mb-1">Banco de destino</label>
                <select id="bancoSelect" required class="w-full border rounded px-3 py-2">
                    <option value="">Seleccione un banco o caja</option>
                    <option>BCP (Banco de Crédito del Perú)</option>
                    <option>BBVA</option>
                    <option>Interbank</option>
                    <option>Scotiabank</option>
                    <option>BanBif</option>
                    <option>Banco Pichincha</option>
                    <option>Banco GNB</option>
                    <option>Banco Ripley</option>
                    <option>Banco Falabella</option>
                    <option>MiBanco</option>
                    <option>Banco de la Nación</option>
                    <option>Caja Arequipa</option>
                    <option>Caja Piura</option>
                    <option>Caja Huancayo</option>
                    <option>Caja Sullana</option>
                    <option>Caja Trujillo</option>
                    <option>Caja Cusco</option>
                    <option>Caja Ica</option>
                    <option>Caja Tacna</option>
                    <option>Caja Metropolitana</option>
                    <option>Caja Los Andes</option>
                    <option>Caja Raíz</option>
                    <option>Caja Rural Los Andes</option>
                    <option>Caja Rural Prymera</option>
                    <option>Caja Rural Del Centro</option>
                    <option>Caja Rural Señor de Luren</option>
                    <option>Caja Rural Credinka</option>
                    <option>Caja Rural Profinanzas</option>
                    <option>Caja Rural Sipán</option>
                </select>
            </div>
            <div class="mb-2">
                <label class="block text-sm font-medium mb-1">Número de operación</label>
                <input type="text" required class="w-full border rounded px-3 py-2" placeholder="N° de operación">
            </div>
            <div class="mb-2">
                <label class="block text-sm font-medium mb-1">Monto transferido</label>
                <input type="text" value="S/ {{ number_format($total + 15 - ($descuento ?? 0), 2) }}" readonly class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed" placeholder="S/ {{ number_format($total + 15 - ($descuento ?? 0), 2) }}">
            </div>
            <button type="submit" class="bg-[#EAA451] text-white px-4 py-2 rounded font-semibold w-full mt-2">Confirmar transferencia</button>
        </form>
        <div class="hidden mt-4 text-center" id="cargandoTransferencia">
            <div class="loader mb-2"></div>
            <span>Procesando pago...</span>
        </div>
        <div class="hidden mt-4 text-center text-green-600 font-bold" id="exitoTransferencia">
            ¡Pago realizado con éxito!
        </div>
    </div>
</div>

<!-- Modal Tarjeta de Crédito -->
<div id="modalTarjeta" class="modal-pago hidden">
    <div class="modal-bg" onclick="cerrarModal('modalTarjeta')"></div>
    <div class="modal-content max-w-md relative">
        <h3 class="text-lg font-bold mb-4">Tarjeta de crédito o débito</h3>
        <div class="absolute right-6 top-6 flex gap-2">
            <img src="{{ asset('icons/visa.svg') }}" alt="Visa" class="h-6">
            <img src="{{ asset('icons/diners-club.svg') }}" alt="Diners Club" class="h-6">
            <img src="{{ asset('icons/mastercard.svg') }}" alt="Mastercard" class="h-6">
            <img src="{{ asset('icons/american-express.svg') }}" alt="American Express" class="h-6">
        </div>
        <form id="formTarjeta" onsubmit="return validarTarjetaYEnviar()">
            <div class="mb-2">
                <label class="block text-sm font-medium mb-1">Número de tarjeta</label>
                <input type="text" id="numeroTarjeta" required maxlength="19" class="w-full border rounded px-3 py-2" placeholder="XXXX XXXX XXXX XXXX">
            </div>
            <div class="flex gap-2 mb-2">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Vencimiento</label>
                    <input type="text" id="vencimientoTarjeta" required maxlength="5" class="w-full border rounded px-3 py-2" placeholder="MM/AA">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Código de seguridad</label>
                    <input type="text" id="cvvTarjeta" required maxlength="4" class="w-full border rounded px-3 py-2" placeholder="Ej.: 123">
                </div>
            </div>
            <div class="mb-2">
                <label class="block text-sm font-medium mb-1">Nombre del titular</label>
                <input type="text" id="nombreTitularTarjeta" required class="w-full border rounded px-3 py-2" placeholder="Nombre del titular">
            </div>
            <div class="mb-2">
                <label class="block text-sm font-medium mb-1">Documento del titular</label>
                <input type="text" id="documentoTitularTarjeta" required class="w-full border rounded px-3 py-2" placeholder="Documento de identidad">
            </div>
            <div class="mb-2">
                <label class="block text-sm font-medium mb-1">Correo electrónico</label>
                <input type="email" id="emailTarjeta" required class="w-full border rounded px-3 py-2" placeholder="ejemplo@email.com">
                <span id="errorEmailTarjeta" class="text-red-600 text-xs hidden">El correo debe terminar en .com</span>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold w-full mt-2">
                Pagar S/ {{ number_format($total + 15 - ($descuento ?? 0), 2) }}
            </button>
        </form>
        <div class="hidden mt-4 text-center" id="cargandoTarjeta">
            <div class="loader mb-2"></div>
            <span>Procesando pago...</span>
        </div>
        <div class="hidden mt-4 text-center text-green-600 font-bold" id="exitoTarjeta">
            ¡Pago realizado con éxito!
        </div>
    </div>
</div>

<!-- Modal Yape -->
<div id="modalYape" class="modal-pago hidden">
    <div class="modal-bg" onclick="cerrarModal('modalYape')"></div>
    <div class="modal-content max-w-xs flex flex-col items-center">
        <img src="{{ asset('images/yape1.png') }}" alt="Yape QR" class="w-100 h-600 object-contain mb-4">
        <span class="text-lg text-center efont-bold mb-2">Escanea el código QR con Yape</span>
        <div class="hidden mt-4 text-center" id="cargandoYape">
            <div class="loader mb-2"></div>
            <span>Procesando pago...</span>
        </div>
        <div class="hidden mt-4 text-center text-green-600 font-bold" id="exitoYape">
            ¡Pago realizado con éxito!
        </div>
    </div>
</div>

<!-- Estilos y lógica de modales y loader -->
<style>
.modal-pago { position: fixed; z-index: 50; left: 0; top: 0; width: 100vw; height: 100vh; display: flex; align-items: center; justify-content: center; }
.modal-pago.hidden { display: none !important; }
.modal-bg { position: absolute; width: 100vw; height: 100vh; background: rgba(0,0,0,0.4); top: 0; left: 0; }
.modal-content { position: relative; background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 8px 32px rgba(0,0,0,0.18); z-index: 10; }
.loader { border: 4px solid #f3f3f3; border-top: 4px solid #EAA451; border-radius: 50%; width: 36px; height: 36px; animation: spin 1s linear infinite; margin: 0 auto; }
@keyframes spin { 100% { transform: rotate(360deg); } }
.metodo-pago-btn.selected {
    background: #FFF0DF !important;
    border-color: #EAA451 !important;
    position: relative;
}
</style>
<script>
// Configurar fecha mínima para entrega (día actual +  días)
document.addEventListener('DOMContentLoaded', function() {
    const inputFecha = document.getElementById('inputFecha');
    if (inputFecha) {
        // Calcular fecha mínima (hoy + 4 días)
        const hoy = new Date();
        const fechaMinima = new Date(hoy);
        fechaMinima.setDate(hoy.getDate() + 4);
        
        // Formatear fecha para el atributo min
        const fechaMinimaStr = fechaMinima.toISOString().split('T')[0];
        inputFecha.setAttribute('min', fechaMinimaStr);
        
        // Si no hay valor o el valor es anterior a la fecha mínima, establecer la fecha mínima
        if (!inputFecha.value || inputFecha.value < fechaMinimaStr) {
            inputFecha.value = fechaMinimaStr;
        }
        
        // Validar cuando el usuario cambie la fecha
        inputFecha.addEventListener('change', function() {
            if (this.value < fechaMinimaStr) {
                alert('La fecha de entrega debe ser al menos 4 días después de hoy.');
                this.value = fechaMinimaStr;
            }
        });
    }
});

function actualizarEntrega() {
    document.getElementById('entregaNombre').textContent = document.getElementById('inputNombre').value;
    // Formatear fecha a dd/mm/yyyy
    let fecha = document.getElementById('inputFecha').value;
    if(fecha) {
        let partes = fecha.split('-');
        if(partes.length === 3) {
            document.getElementById('entregaFecha').textContent = partes[2] + '/' + partes[1] + '/' + partes[0];
        } else {
            document.getElementById('entregaFecha').textContent = fecha;
        }
    } else {
        document.getElementById('entregaFecha').textContent = '';
    }
    document.getElementById('entregaDireccion').textContent = document.getElementById('inputDireccion').value;
    document.getElementById('entregaTelefono').textContent = document.getElementById('inputTelefono').value;
}
// Actualizar automáticamente al cargar por si hay valores precargados
window.addEventListener('DOMContentLoaded', actualizarEntrega);
document.getElementById('inputNombre').addEventListener('input', actualizarEntrega);
document.getElementById('inputFecha').addEventListener('input', actualizarEntrega);
document.getElementById('inputDireccion').addEventListener('input', actualizarEntrega);
document.getElementById('inputTelefono').addEventListener('input', actualizarEntrega);

function abrirModal(id) {
    document.getElementById(id).classList.remove('hidden');
}
function cerrarModal(id) {
    document.getElementById(id).classList.add('hidden');
    // Resetear formularios y estados
    if(id === 'modalTransferencia') {
        document.getElementById('formTransferencia').reset();
        document.getElementById('cargandoTransferencia').classList.add('hidden');
        document.getElementById('exitoTransferencia').classList.add('hidden');
    }
    if(id === 'modalTarjeta') {
        document.getElementById('formTarjeta').reset();
        document.getElementById('cargandoTarjeta').classList.add('hidden');
        document.getElementById('exitoTarjeta').classList.add('hidden');
    }
    if(id === 'modalYape') {
        document.getElementById('cargandoYape').classList.add('hidden');
        document.getElementById('exitoYape').classList.add('hidden');
    }
}
let metodoSeleccionado = null;
function seleccionarMetodoPago(metodo) {
    if(document.querySelector('.metodo-pago-btn[disabled]')) return; // No permitir si ya se pagó
    const botones = document.querySelectorAll('.metodo-pago-btn');
    botones.forEach((btn, idx) => {
        btn.classList.remove('selected');
    });
    let idx = 0;
    if(metodo === 'transferencia') idx = 0;
    if(metodo === 'tarjeta') idx = 1;
    if(metodo === 'yape') idx = 2;
    const btn = botones[idx];
    btn.classList.add('selected');
    metodoSeleccionado = metodo;
    document.getElementById('inputMetodoPago').value = metodo;
    // Habilitar el botón de confirmar compra
    document.getElementById('btnConfirmarCompra').disabled = false;
    // Abrir el modal correspondiente
    if(metodo === 'transferencia') abrirModal('modalTransferencia');
    if(metodo === 'tarjeta') abrirModal('modalTarjeta');
    if(metodo === 'yape') abrirModal('modalYape');
}
// Simulación automática para Yape
let yapeTimer = null;
document.getElementById('modalYape').addEventListener('click', function(e) {
    if(e.target.classList.contains('modal-bg')) return;
    if(!document.getElementById('cargandoYape').classList.contains('hidden')) return;
    document.getElementById('cargandoYape').classList.remove('hidden');
    yapeTimer = setTimeout(function() {
        document.getElementById('cargandoYape').classList.add('hidden');
        document.getElementById('exitoYape').classList.remove('hidden');
        setTimeout(function() {
            cerrarModal('modalYape');
            deshabilitarMetodosPago();
        }, 1500);
    }, 2000);
});

// Mejoras para el modal de tarjeta
const inputNumeroTarjeta = document.getElementById('numeroTarjeta');
const inputVencimiento = document.getElementById('vencimientoTarjeta');
const inputCVV = document.getElementById('cvvTarjeta');
const inputNombre = document.getElementById('nombreTitularTarjeta');
const inputDocumento = document.getElementById('documentoTitularTarjeta');
const inputEmailTarjeta = document.getElementById('emailTarjeta');
const errorEmailTarjeta = document.getElementById('errorEmailTarjeta');

if(inputNumeroTarjeta) {
    inputNumeroTarjeta.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.substring(0, 16);
        let formatted = '';
        for(let i = 0; i < value.length; i += 4) {
            if(i > 0) formatted += ' ';
            formatted += value.substring(i, i+4);
        }
        e.target.value = formatted;
    });
}
if(inputVencimiento) {
    inputVencimiento.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if(value.length > 4) value = value.substring(0,4);
        // Validar mes
        if(value.length >= 2) {
            let mes = parseInt(value.substring(0,2));
            if(mes > 12) mes = 12;
            if(mes < 1 && value.length >= 2) mes = '01';
            value = mes.toString().padStart(2,'0') + value.substring(2,4);
        }
        if(value.length > 2) {
            value = value.substring(0,2) + '/' + value.substring(2,4);
        }
        e.target.value = value;
    });
}
if(inputCVV) {
    inputCVV.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '').substring(0,4);
    });
}
if(inputNombre) {
    inputNombre.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '');
    });
}
if(inputDocumento) {
    inputDocumento.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });
}

function validarTarjetaYEnviar() {
    // Validar email termine en .com
    if(inputEmailTarjeta && !inputEmailTarjeta.value.trim().endsWith('.com')) {
        errorEmailTarjeta.classList.remove('hidden');
        inputEmailTarjeta.focus();
        return false;
    } else if(errorEmailTarjeta) {
        errorEmailTarjeta.classList.add('hidden');
    }
    return simularPago('modalTarjeta');
}

function filtrarBancos() {
    const filtro = document.getElementById('bancoFiltro').value.toLowerCase();
    const select = document.getElementById('bancoSelect');
    for (let i = 0; i < select.options.length; i++) {
        const texto = select.options[i].text.toLowerCase();
        if (i === 0 || texto.includes(filtro)) {
            select.options[i].style.display = '';
        } else {
            select.options[i].style.display = 'none';
        }
    }
    // Si hay coincidencias, selecciona la primera visible (que no sea el placeholder)
    for (let i = 1; i < select.options.length; i++) {
        if (select.options[i].style.display !== 'none') {
            select.selectedIndex = i;
            break;
        }
    }
}

function verificarCamposPedido() {
    // IDs de los campos requeridos
    const campos = [
        'inputNombre', 'inputCorreo', 'inputDireccion', 'inputTelefono', 'inputFecha'
    ];
    let completos = true;
    campos.forEach(id => {
        const el = document.getElementById(id);
        if(!el || !el.value.trim()) completos = false;
    });
    // Habilitar o deshabilitar métodos de pago
    const botones = document.querySelectorAll('.metodo-pago-btn');
    botones.forEach(btn => {
        if(btn.hasAttribute('data-pagado')) return; // Si ya se pagó, no cambiar estado
        if(completos) {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            btn.classList.remove('selected');
        }
    });
}
// Ejecutar al cargar y al cambiar campos
window.addEventListener('DOMContentLoaded', verificarCamposPedido);
['inputNombre','inputCorreo','inputDireccion','inputTelefono','inputFecha'].forEach(id => {
    const el = document.getElementById(id);
    if(el) el.addEventListener('input', verificarCamposPedido);
});

function deshabilitarMetodosPago() {
    const botones = document.querySelectorAll('.metodo-pago-btn');
    botones.forEach(btn => {
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        btn.setAttribute('data-pagado','1');
    });
    // Mantener el sombreado en el método seleccionado
    if(metodoSeleccionado) {
        let idx = 0;
        if(metodoSeleccionado === 'transferencia') idx = 0;
        if(metodoSeleccionado === 'tarjeta') idx = 1;
        if(metodoSeleccionado === 'yape') idx = 2;
        const botonesArr = Array.from(botones);
        botonesArr.forEach((btn, i) => {
            if(i === idx) btn.classList.add('selected');
            else btn.classList.remove('selected');
        });
    }
}

function simularPago(modalId) {
    let cargandoId = '', exitoId = '';
    if(modalId === 'modalTransferencia') {
        cargandoId = 'cargandoTransferencia'; exitoId = 'exitoTransferencia';
    }
    if(modalId === 'modalTarjeta') {
        cargandoId = 'cargandoTarjeta'; exitoId = 'exitoTarjeta';
    }
    document.getElementById(cargandoId).classList.remove('hidden');
    setTimeout(function() {
        document.getElementById(cargandoId).classList.add('hidden');
        document.getElementById(exitoId).classList.remove('hidden');
        setTimeout(function() {
            cerrarModal(modalId);
            deshabilitarMetodosPago();
        }, 1500);
    }, 2000);
    return false;
}

// Deshabilitar el botón de confirmar compra hasta que se seleccione método de pago
window.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btnConfirmarCompra');
    if(btn) btn.disabled = true;
    
    // Cargar direcciones del usuario
    cargarDirecciones();
});

// Funciones para manejar direcciones
function cargarDirecciones() {
    fetch('{{ route("user.direcciones.obtener") }}', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(direcciones => {
        const select = document.getElementById('selectDireccion');
        select.innerHTML = '<option value="">Selecciona una dirección o crea una nueva</option>';
        
        if (direcciones.length === 0) {
            // Si no hay direcciones, crear una automática
            crearDireccionAutomatica();
        } else {
            // Agregar las direcciones existentes
            direcciones.forEach(direccion => {
                const option = document.createElement('option');
                option.value = direccion.id;
                option.textContent = `${direccion.direccion} - ${direccion.departamento}, ${direccion.ciudad}`;
                select.appendChild(option);
            });
        }
    })
    .catch(error => {
        console.error('Error al cargar direcciones:', error);
    });
}

function crearDireccionAutomatica() {
    fetch('{{ route("user.direcciones.crear-automatica") }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Recargar direcciones después de crear la automática
            cargarDirecciones();
        }
    })
    .catch(error => {
        console.error('Error al crear dirección automática:', error);
    });
}

// Manejar selección de dirección
document.getElementById('selectDireccion').addEventListener('change', function() {
    const direccionId = this.value;
    if (direccionId) {
        // Obtener los datos de la dirección seleccionada
        fetch('{{ route("user.direcciones.obtener") }}', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(direcciones => {
            const direccion = direcciones.find(d => d.id == direccionId);
            if (direccion) {
                // Llenar los campos con los datos de la dirección
                document.getElementById('inputDireccion').value = direccion.direccion;
                document.getElementById('inputDepartamento').value = direccion.departamento;
                document.getElementById('inputCiudad').value = direccion.ciudad;
                document.getElementById('inputTelefono').value = direccion.telefono;
                
                // Actualizar la información de entrega
                actualizarEntrega();
            }
        });
    }
});

// Función para guardar la dirección actual como nueva dirección
function guardarDireccionActual() {
    const direccion = document.getElementById('inputDireccion').value;
    const departamento = document.getElementById('inputDepartamento').value;
    const ciudad = document.getElementById('inputCiudad').value;
    const telefono = document.getElementById('inputTelefono').value;
    
    if (!direccion || !departamento || !ciudad || !telefono) {
        alert('Por favor completa todos los campos de dirección antes de guardar');
        return;
    }
    
    const formData = new FormData();
    formData.append('direccion', direccion);
    formData.append('departamento', departamento);
    formData.append('ciudad', ciudad);
    formData.append('telefono', telefono);
    formData.append('referencia', 'Dirección de compra');
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch('{{ route("user.direcciones.store") }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Dirección guardada correctamente');
            cargarDirecciones();
        } else {
            alert('Error al guardar la dirección');
        }
    })
    .catch(error => {
        console.error('Error al guardar dirección:', error);
        alert('Error al guardar la dirección');
    });
}

// Actualizar la función actualizarEntrega para incluir los nuevos campos
function actualizarEntrega() {
    document.getElementById('entregaNombre').textContent = document.getElementById('inputNombre').value;
    // Formatear fecha a dd/mm/yyyy
    let fecha = document.getElementById('inputFecha').value;
    if(fecha) {
        let partes = fecha.split('-');
        if(partes.length === 3) {
            document.getElementById('entregaFecha').textContent = partes[2] + '/' + partes[1] + '/' + partes[0];
        } else {
            document.getElementById('entregaFecha').textContent = fecha;
        }
    } else {
        document.getElementById('entregaFecha').textContent = '';
    }
    
    // Construir dirección completa con departamento y ciudad
    const direccion = document.getElementById('inputDireccion').value;
    const departamento = document.getElementById('inputDepartamento').value;
    const ciudad = document.getElementById('inputCiudad').value;
    const direccionCompleta = `${direccion}, ${ciudad}, ${departamento}`;
    
    document.getElementById('entregaDireccion').textContent = direccionCompleta;
    document.getElementById('entregaTelefono').textContent = document.getElementById('inputTelefono').value;
}

// Agregar event listeners para los nuevos campos
document.getElementById('inputDepartamento').addEventListener('input', actualizarEntrega);
document.getElementById('inputCiudad').addEventListener('input', actualizarEntrega);
</script>
@endsection 