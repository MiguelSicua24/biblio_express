# BiblioExpress

CRUD de libros hecho en PHP puro con PDO (MySQL / PostgreSQL).

## Requisitos
- XAMPP (Apache + MySQL + PHP)

## Instalación
1. Copiar la carpeta `biblio-express` en `C:\xampp\htdocs\`.
2. Iniciar Apache y MySQL desde XAMPP.
3. Importar `database.sql` desde phpMyAdmin (pestaña SQL).
4. Revisar los parámetros de `conexion.php` (puerto, usuario, clave).
5. Abrir `http://localhost/biblio-express/`.

## Funcionalidades
- Listar, crear, editar y eliminar libros.
- Consultas preparadas con PDO (protección contra inyección SQL).
- Validación de campos obligatorios y numéricos.

## Autor
Miguel – SENA, Ficha 3478073