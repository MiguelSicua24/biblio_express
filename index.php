<?php
require 'conexion.php';

$libros = $pdo->query('SELECT * FROM libro ORDER BY id_libro DESC')->fetchAll();

$mensajes = [
    'creado'      => 'Libro registrado correctamente.',
    'actualizado' => 'Libro actualizado correctamente.',
    'eliminado'   => 'Libro eliminado correctamente.',
];
$msg = $mensajes[$_GET['msg'] ?? ''] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>BiblioExpress</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">📚 BiblioExpress – Catálogo de libros</h1>
        <a href="crear.php" class="btn btn-primary">+ Nuevo libro</a>
    </div>

    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <table class="table table-striped table-bordered bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Título</th><th>ISBN</th><th>Año</th>
                <th>Idioma</th><th>Páginas</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($libros)): ?>
            <tr><td colspan="7" class="text-center">No hay libros registrados.</td></tr>
        <?php endif; ?>
        <?php foreach ($libros as $l): ?>
            <tr>
                <td><?= $l['id_libro'] ?></td>
                <td><?= htmlspecialchars($l['titulo']) ?></td>
                <td><?= htmlspecialchars($l['isbn']) ?></td>
                <td><?= $l['ano_publicacion'] ?></td>
                <td><?= htmlspecialchars($l['idioma']) ?></td>
                <td><?= $l['numero_paginas'] ?></td>
                <td>
                    <a href="editar.php?id_libro=<?= $l['id_libro'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <form action="eliminar.php" method="POST" class="d-inline"
                          onsubmit="return confirm('¿Eliminar este libro?');">
                        <input type="hidden" name="id_libro" value="<?= $l['id_libro'] ?>">
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>