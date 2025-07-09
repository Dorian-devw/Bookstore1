<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmación de Pedido</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #2563eb; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9fafb; }
        .footer { background: #374151; color: white; padding: 20px; text-align: center; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background: #f3f4f6; }
        .total { font-size: 18px; font-weight: bold; text-align: right; margin-top: 20px; }
        .info-box { background: white; padding: 15px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Flying Bookstore</h1>
            <h2>¡Gracias por tu compra!</h2>
        </div>
        
        <div class="content">
            <p>Hola <strong>{{ $pedido->user->name }}</strong>,</p>
            <p>¡Tu pedido ha sido confirmado exitosamente! Aquí tienes todos los detalles para que sigas tu compra:</p>
            <div class="info-box">
                <h3>Información del Pedido</h3>
                <p><strong>Número de pedido:</strong> #{{ $pedido->id }}</p>
                <p><strong>Fecha del pedido:</strong> {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : 'N/A' }}</p>
                <p><strong>Fecha de entrega:</strong> {{ $pedido->fecha_entrega ? \Carbon\Carbon::parse($pedido->fecha_entrega)->format('d/m/Y') : 'N/A' }}</p>
                <p><strong>Dirección de entrega:</strong> {{ $pedido->direccion_entrega ?? '-' }}</p>
                <p><strong>Método de pago:</strong> {{ ucfirst($pedido->metodo_pago) }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($pedido->estado) }}</p>
            </div>
            <h3>Libros Comprados</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Libro</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->libro->titulo }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>S/ {{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="total">
                <p>Costo de envío: <span style="font-weight:normal">S/ 15.00</span></p>
            </div>
            @if($pedido->descuento > 0)
                <div class="total">
                    <p>Subtotal: S/ {{ number_format($pedido->total + $pedido->descuento, 2) }}</p>
                    <p>Descuento: -S/ {{ number_format($pedido->descuento, 2) }}</p>
                </div>
            @endif
            <div class="total">
                <p>Total: S/ {{ number_format($pedido->total, 2) }}</p>
            </div>
            <p style="margin-top: 32px;">Puedes hacer seguimiento y ver el detalle de tu pedido en el siguiente enlace:</p>
            <p style="text-align:center; margin: 24px 0;">
                <a href="{{ url('/user/pedidos/' . $pedido->id) }}" style="background:#2563eb; color:#fff; padding:12px 24px; border-radius:6px; text-decoration:none; font-weight:bold;">Ver mi pedido</a>
            </p>
            <p>Te mantendremos informado sobre el estado de tu pedido. Si tienes alguna pregunta, no dudes en contactarnos respondiendo a este correo o escribiendo a <a href="mailto:soporte@flying.bookstore">soporte@flying.bookstore</a>.</p>
            <p>¡Disfruta de tus nuevos libros y gracias por confiar en nosotros!</p>
            <p>Saludos,<br>El equipo de Flying Bookstore</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Flying Bookstore. Todos los derechos reservados.</p>
            <p>Este es un email automático, por favor no respondas a este mensaje.</p>
        </div>
    </div>
</body>
</html> 