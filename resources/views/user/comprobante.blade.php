<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante Pedido #{{ $pedido->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #333; padding: 6px; text-align: left; }
        .table th { background: #f0f0f0; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Comprobante de Pedido - Flying Bookstore</h2>
        <p><strong>Pedido #{{ $pedido->id }}</strong></p>
        <p>Fecha: {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : '-' }}</p>
    </div>
    <p><strong>Cliente:</strong> {{ $pedido->user->name ?? '-' }}<br>
    <strong>Correo:</strong> {{ $pedido->user->email ?? '-' }}</p>
    <table class="table">
        <thead>
            <tr>
                <th>Libro</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->libro->titulo ?? '-' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>S/ {{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="right bold">Total: S/ {{ number_format($pedido->total, 2) }}</p>
    <p><strong>Estado del pedido:</strong> {{ ucfirst($pedido->estado) }}<br>
    <strong>Método de pago:</strong> {{ $pedido->metodo_pago }}<br>
    <strong>Estado del pago:</strong> {{ $pedido->pago->estado ?? 'pendiente' }}</p>
    <br>
    <p>Gracias por tu compra en Flying Bookstore.</p>
    <p>Para cualquier consulta, contáctanos a través de nuestro servicio al cliente.</p>
</body>
</html> 