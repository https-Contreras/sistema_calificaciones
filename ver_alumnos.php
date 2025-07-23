<?php
session_start();
require_once 'logic/db.php';

if (!isset($_SESSION['maestro_id'])) {
    header('Location: index.php');
    exit;
}

$maestro_id = $_SESSION['maestro_id'];
$grupo = $_GET['grupo'] ?? null;
$alumnos = [];

if ($grupo) {
    $stmt = $conn->prepare("SELECT id, nombre, grupo FROM alumnos WHERE grupo = ? AND id_maestro = ?");
    $stmt->bind_param("si", $grupo, $maestro_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    while ($fila = $resultado->fetch_assoc()) {
        $alumnos[] = $fila;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver alumnos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="verAlumnos-container">
        <h1>Seleccione el grupo a consultar</h1>
        <a href="ver_alumnos.php?grupo=A">Grupo A</a> |
        <a href="ver_alumnos.php?grupo=B">Grupo B</a> |
        <a href="ver_alumnos.php?grupo=C">Grupo C</a>
    </div>    

    <?php if ($grupo): ?>
        <div class="resultado-grupo">
            <h2>Alumnos del Grupo <?= htmlspecialchars($grupo) ?></h2>

            <?php if (count($alumnos) > 0): ?>
                <table border="1" cellpadding="8" cellspacing="0">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Grupo</th>
                    </tr>
                    <?php foreach ($alumnos as $alumno): ?>
                    <tr>
                        <td><?=htmlspecialchars($alumno['id'])?></td>
                        <td><?= htmlspecialchars($alumno['nombre']) ?></td>
                        <td><?= htmlspecialchars($alumno['grupo']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No hay alumnos registrados en el grupo <?= htmlspecialchars($grupo) ?>.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <a href="dashboard.php">
         <button>🔙 Volver al panel</button>
    </a>

</body>
</html>
