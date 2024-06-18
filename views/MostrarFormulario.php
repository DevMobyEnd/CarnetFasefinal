<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Selección</title>
    <!-- Asegúrate de incluir Bootstrap o tu CSS aquí para estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <form action="index.php" method="post">
        <table class="table table-striped table-hover">
            <thead>
                <tr class="text-center">
                    <th>Documento</th>
                    <th>Aprendiz</th>
                    <th>Celular</th>
                    <th>Correo Electrónico</th>
                    <th>Estado</th>
                    <th>Soy Sena</th>
                    <th>Seleccionar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datosPersonales as $persona): ?>
                <tr class="text-center">
                    <td><?= htmlspecialchars($persona['documento']) ?></td>
                    <td><?= htmlspecialchars($persona['aprendiz']) ?></td>
                    <td><?= htmlspecialchars($persona['celular']) ?></td>
                    <td><?= htmlspecialchars($persona['correo_electronico']) ?></td>
                    <td><?= htmlspecialchars($persona['estado']) ?></td>
                    <td><?= htmlspecialchars($persona['soy_sena']) ?></td>
                    <td><input type="checkbox" name="aprendices[]" value="<?= htmlspecialchars($persona['documento']) ?>"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Generar Carnets">
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>