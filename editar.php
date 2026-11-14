<?php
require 'conexion.php';

$origen = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST : $_GET;
$id = filter_var($origen['id_libro'] ?? '', FILTER_VALIDATE_INT);
if ($id === false) {
    die('ID de libro inválido.');
}

$stmt = $pdo->prepare('SELECT * FROM libro WHERE id_libro = :id');
$stmt->execute([':id' => $id]);
$libro = $stmt->fetch();
if (!$libro) {
    die('El libro no existe.');
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $isbn   = trim($_POST['isbn'] ?? '');
    $idioma = trim($_POST['idioma'] ?? '');
    $ano    = filter_var($_POST['ano_publicacion'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1501]]);
    $pags   = filter_var($_POST['numero_paginas'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

    if ($titulo === '') $errores[] = 'El título es obligatorio.';
    if ($isbn === '')   $errores[] = 'El ISBN es obligatorio.';
    if ($idioma === '') $errores[] = 'El idioma es obligatorio.';
    if ($ano === false)  $errores[] = 'El año debe ser un entero mayor a 1500.';
    if ($pags === false) $errores[] = 'Las páginas deben ser un entero mayor a 0.';

    if (empty($errores)) {
        try {
            $sql = 'UPDATE libro
                    SET titulo = :titulo, isbn = :isbn, ano_publicacion = :ano,
                        idioma = :idioma, numero_paginas = :paginas
                    WHERE id_libro = :id';
            $upd = $pdo->prepare($sql);
            $upd->execute([
                ':titulo'  => $titulo,
                ':isbn'    => $isbn,
                ':ano'     => $ano,
                ':idioma'  => $idioma,
                ':paginas' => $pags,
                ':id'      => $id,
            ]);
            header('Location: index.php?msg=actualizado');
            exit;
        } catch (PDOException $e) {
            if (in_array($e->getCode(), ['23000', '23505'])) {
                $errores[] = 'Ya existe otro libro con ese ISBN.';
            } else {
                error_log($e->getMessage());
                $errores[] = 'Ocurrió un error al actualizar.';
            }
        }
    }

    // Si hubo errores, conservar lo que el usuario escribió
    $libro['titulo']          = $_POST['titulo'] ?? '';
    $libro['isbn']            = $_POST['isbn'] ?? '';
    $libro['ano_publicacion'] = $_POST['ano_publicacion'] ?? '';
    $libro['idioma']          = $_POST['idioma'] ?? '';
    $libro['numero_paginas']  = $_POST['numero_paginas'] ?? '';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4" style="max-width: 600px;">
    <h1 class="h3 mb-3">Editar libro #<?= $id ?></h1>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger"><ul class="mb-0">
            <?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
        </ul></div>
    <?php endif; ?>

    <form action="editar.php" method="POST" class="card card-body">
        <input type="hidden" name="id_libro" value="<?= $id ?>">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" maxlength="150" required
                   value="<?= htmlspecialchars($libro['titulo']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">ISBN</label>
            <input type="text" name="isbn" class="form-control" maxlength="50" required
                   value="<?= htmlspecialchars($libro['isbn']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Año de publicación</label>
            <input type="number" name="ano_publicacion" class="form-control" min="1501" required
                   value="<?= htmlspecialchars($libro['ano_publicacion']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Idioma</label>
            <input type="text" name="idioma" class="form-control" maxlength="50" required
                   value="<?= htmlspecialchars($libro['idioma']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Número de páginas</label>
            <input type="number" name="numero_paginas" class="form-control" min="1" required
                   value="<?= htmlspecialchars($libro['numero_paginas']) ?>">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning">Actualizar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>