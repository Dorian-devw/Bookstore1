# 📚 Bookstore - Tienda de Libros Laravel

Proyecto completo de una tienda de libros online desarrollado en Laravel. Incluye gestión de catálogo, carrito, favoritos, pedidos, perfil de usuario, direcciones, reseñas, administración, reportes y suscripción por correo.

---

## 🚀 Funcionalidades principales

- **Catálogo de libros** con búsqueda, filtros y detalle de cada libro.
- **Carrito de compras** moderno, con contador visual y advertencias para usuarios no registrados.
- **Gestión de favoritos** (solo usuarios registrados, con AJAX y notificaciones).
- **Pedidos**: compra, comprobante PDF, historial y detalle completo.
- **Perfil de usuario**: edición de datos, gestión de direcciones, historial de pedidos, favoritos y libros vistos.
- **Reseñas**: creación, moderación y visualización de valoraciones.
- **Panel de administración**: dashboard con KPIs, gestión de libros, usuarios, pedidos, stock bajo, más vendidos y reportes PDF.
- **Suscripción por correo**: alta automática, envío de cupón de bienvenida y gestión de suscriptores.
- **Alertas visuales**: stock bajo, mensajes claros y coherentes en toda la interfaz.
- **Autenticación y roles**: usuarios y administrador.

---

## 🛠️ Tecnologías utilizadas

- **Backend:** Laravel 10+
- **Frontend:** Blade, TailwindCSS, Alpine.js (opcional)
- **Base de datos:** MySQL/MariaDB
- **PDF:** barryvdh/laravel-dompdf
- **Correo:** Mailables de Laravel
- **Otros:** AJAX, SVG personalizados, notificaciones visuales

---

## 📦 Instalación y configuración

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/Dorian-devw/Bookstore1
   cd bookstore
   ```
2. **Instala dependencias:**
   ```bash
   composer install
   npm install && npm run build
   ```
3. **Configura el entorno:**
   - Copia `.env.example` a `.env` y configura tu base de datos y correo.
   - Genera la clave de la app:
     ```bash
     php artisan key:generate
     ```
4. **Ejecuta migraciones y seeders:**
   ```bash
   php artisan migrate --seed
   ```
5. **(Opcional) Crea el enlace simbólico para storage:**
   ```bash
   php artisan storage:link
   ```
   > **Nota:** Las imágenes de libros se almacenan en `public/libros`.
6. **Inicia el servidor:**
   ```bash
   php artisan serve
   ```

---

## 🗂️ Estructura principal del proyecto

- `app/Http/Controllers/` - Lógica de negocio y controladores (usuario, admin, carrito, pedidos, etc.)
- `app/Models/` - Modelos Eloquent (Libro, Pedido, User, etc.)
- `resources/views/` - Vistas Blade (catálogo, carrito, admin, emails, etc.)
- `routes/web.php` - Definición de rutas web
- `database/seeders/` - Seeders para datos de prueba
- `public/libros/` - Imágenes de portadas de libros

---

## 👤 Acceso administrador

- Usuario admin por defecto:
  - **Email:** admin@flying-bookstore.com
  - **Contraseña:** (ver seeder o definir manualmente)
- Acceso a `/admin` protegido por middleware.

---

## 📧 Suscripción y cupones
- Los usuarios pueden suscribirse con su correo y reciben automáticamente un cupón de descuento por email.
- El modelo `Suscriptor` usa la tabla `suscriptores`.

---

## 📝 Notas de desarrollo
- El código está comentado y estructurado para facilitar la colaboración.
- Se eliminaron campos y lógica obsoletos como `estado` en pagos.
- El sistema prioriza la experiencia visual y la claridad de mensajes.
- Las imágenes de libros deben subirse a `public/libros`.
- Para reportes PDF se usa la vista `resources/views/admin/reportes/pdf.blade.php`.

---

## 🧪 Pruebas
- Incluye tests de autenticación, perfil, catálogo y lógica de negocio en `tests/Feature` y `tests/Unit`.

---

## 📄 Licencia
Proyecto académico/desarrollado para fines educativos. Puedes adaptarlo y reutilizarlo citando la fuente.
