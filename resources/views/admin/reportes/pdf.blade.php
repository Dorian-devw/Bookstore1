<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo ?? 'Reporte' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        h1 { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>{{ $titulo ?? 'Reporte' }}</h1>
    @if(isset($pedidos))
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->user->name ?? '-' }}</td>
                        <td>{{ $pedido->fecha }}</td>
                        <td>S/ {{ number_format($pedido->total, 2) }}</td>
                        <td>{{ ucfirst($pedido->estado) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif(isset($libros))
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($libros as $libro)
                    <tr>
                        <td>{{ $libro->id }}</td>
                        <td>{{ $libro->titulo }}</td>
                        <td>{{ $libro->autor->nombre ?? '-' }}</td>
                        <td>{{ $libro->categoria->nombre ?? '-' }}</td>
                        <td>{{ $libro->stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif(isset($usuarios))
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Registrado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay datos para mostrar.</p>
    @endif
</body>
</html> 