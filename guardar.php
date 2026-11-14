<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// 1. Recoger y limpiar
$titulo = trim($_POST['titulo'] ?? '');
$isbn   = trim($_POST['isbn'] ?? '');
$idioma = trim($_POST['idioma'] ?? '');
$ano    = filter_var($_POST['ano_publicacion'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1501]]);
$pags   = filter_var($_POST['numero_paginas'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

// 2. Validar
$errores = [];
if ($titulo === '') $errores[] = 'El título es obligatorio.';
if ($isbn === '')   $errores[] = 'El ISBN es obligatorio.';
if ($idioma === '') $errores[] = 'El idioma es obligatorio.';
if ($ano === false)  $errores[] = 'El año debe ser un número entero mayor a 1500.';
if ($pags === false) $errores[] = 'El número de páginas debe ser un entero mayor a 0.';

if (!empty($errores)) {
    echo '<h3>Corrige lo siguiente:</h3><ul>';
    foreach ($errores as $e) echo '<li>' . htmlspecialchars($e) . '</li>';
    echo '</ul><a href="javascript:history.back()">← Volver al formulario</a>';
    exit;
}

// 3. Insertar con sentencia preparada
try {
    $sql = 'INSERT INTO libro (titulo, isbn, ano_publicacion, idioma, numero_paginas)
            VALUES (:titulo, :isbn, :ano, :idioma, :paginas)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titulo'  => $titulo,
        ':isbn'    => $isbn,
        ':ano'     => $ano,
        ':idioma'  => $idioma,
        ':paginas' => $pags,
    ]);
    header('Location: index.php?msg=creado');
    exit;
} catch (PDOException $e) {
    if (in_array($e->getCode(), ['23000', '23505'])) {
        die('Ya existe un libro con ese ISBN. <a href="javascript:history.back()">Volver</a>');
    }
    error_log($e->getMessage());
    die('Ocurrió un error al guardar el libro.');
}