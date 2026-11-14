<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4" style="max-width: 600px;">
    <h1 class="h3 mb-3">Registrar nuevo libro</h1>
    <form action="guardar.php" method="POST" class="card card-body">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" maxlength="150" required>
        </div>
        <div class="mb-3">
            <label class="form-label">ISBN</label>
            <input type="text" name="isbn" class="form-control" maxlength="50" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Año de publicación</label>
            <input type="number" name="ano_publicacion" class="form-control" min="1501" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Idioma</label>
            <input type="text" name="idioma" class="form-control" maxlength="50" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Número de páginas</label>
            <input type="number" name="numero_paginas" class="form-control" min="1" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>