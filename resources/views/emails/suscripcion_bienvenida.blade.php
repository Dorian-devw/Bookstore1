<html>
<body style="font-family: Arial, sans-serif; background: #f9f9f9; color: #222;">
    <div style="max-width: 500px; margin: 40px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px #eee; padding: 32px;">
        <h2 style="color: #00254F;">¡Bienvenido a The Flying Bookstore!</h2>
        <p>Gracias por suscribirte a nuestra comunidad de lectores.</p>
        <p>Como regalo de bienvenida, aquí tienes un cupón de descuento para tu próxima compra:</p>
        <div style="background: #EAA451; color: #fff; font-size: 1.5em; font-weight: bold; padding: 16px; border-radius: 8px; text-align: center; margin: 24px 0;">
            Código: {{ $cupon->codigo }}<br>
            Descuento: 10%
        </div>
        <p>¡Aprovecha y disfruta de tus libros favoritos!</p>
        <hr style="margin: 32px 0;">
        <p style="font-size: 0.9em; color: #888;">Si tienes dudas, contáctanos en soporte@flying.bookstore</p>
        <p style="font-size: 0.9em; color: #888;">The Flying Bookstore · {{ date('Y') }}</p>
    </div>
</body>
</html> 