# veterinaria
# veterinaria
# Copia los archivos del proyecto
Ve al directorio donde tienes el respaldo de MascotaShop.
Copia todos los archivos y carpetas del proyecto dentro de:
C:\xampp\htdocs\mascotashop

# Configuración de la base de datos
Abre phpMyAdmin desde el navegador:

http://localhost/phpmyadmin

# Crea una nueva base de datos:
Nombre: mascotashop.
Codificación: utf8_general_ci.

# Importa el respaldo de la base de datos:
Haz clic en la base de datos mascotashop.
Ve a la pestaña Importar.
Selecciona el archivo mascotashop_backup.sql.
Haz clic en Continuar.
# Configurar config.php
Abre el archivo config.php del proyecto MascotaShop en un editor de texto (por ejemplo, Notepad++ o Visual Studio Code).
Asegúrate de que tenga la siguiente configuración para XAMPP:

define('DB_HOST', 'localhost');        // Host del servidor
define('DB_USER', 'root');            // Usuario de la base de datos (predeterminado en XAMPP)
define('DB_PASS', '');                // Contraseña de la base de datos (vacío por defecto en XAMPP)
define('DB_NAME', 'mascotashop');     // Nombre de la base de datos
# Probar el proyecto
Abre tu navegador y accede al proyecto:

http://localhost/mascotashop
# Verifica que:
El proyecto cargue correctamente.
Los datos de la base de datos (productos, usuarios, etc.) se muestren correctamente.
#  Solución de problemas comunes
Error de conexión a la base de datos:

Verifica que el archivo config.php tiene las credenciales correctas (usuario root, contraseña en blanco).
Asegúrate de que el servidor MySQL esté corriendo en XAMPP.
Error 404:

Verifica que la carpeta del proyecto esté dentro de C:\xampp\htdocs\mascotashop.
Archivos PHP no ejecutan:

Asegúrate de que Apache esté corriendo en XAMPP.
Revisa que el archivo principal sea index.php y esté en la raíz del proyecto.
