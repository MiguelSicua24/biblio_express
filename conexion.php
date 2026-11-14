<?php
// ===== PARÁMETROS DE CONEXIÓN =====
$driver  = 'mysql';          // 'mysql' o 'pgsql'
$host    = 'localhost';
$puerto  = '3306';           // Pon '3307' si cambiaste el puerto de XAMPP. PostgreSQL usa '5432'
$bd      = 'biblio_express';
$usuario = 'root';           // En PostgreSQL normalmente 'postgres'
$clave   = '';               // En XAMPP el usuario root no tiene clave

if ($driver === 'mysql') {
    $dsn = "mysql:host=$host;port=$puerto;dbname=$bd;charset=utf8mb4";
} else {
    $dsn = "pgsql:host=$host;port=$puerto;dbname=$bd";
}

try {
    $pdo = new PDO($dsn, $usuario, $clave, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    die('No se pudo conectar a la base de datos.');
}