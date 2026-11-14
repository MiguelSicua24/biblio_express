<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = filter_var($_POST['id_libro'] ?? '', FILTER_VALIDATE_INT);
if ($id === false) {
    die('ID de libro inválido.');
}

try {
    $stmt = $pdo->prepare('DELETE FROM libro WHERE id_libro = :id');
    $stmt->execute([':id' => $id]);
    header('Location: index.php?msg=eliminado');
    exit;
} catch (PDOException $e) {
    error_log($e->getMessage());
    die('No se pudo eliminar el libro.');
}