<?php
session_start();
require_once 'logic/db.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreAlumno = $_POST['nombre_alumno'];
    $grupoAlumno = $_POST['grupo_alumno'];

    // Obtener el id del maestro usando el usuario guardado en sesión
    $usuario = $_SESSION['usuario_maestro'] ?? '';

    $stmt = $conn->prepare("SELECT id FROM maestros WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();
        $idMaestro = $fila['id'];

        $stmt = $conn->prepare("INSERT INTO alumnos (nombre, grupo, id_maestro) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nombreAlumno, $grupoAlumno, $idMaestro);

        if ($stmt->execute()) {
            header("Location: agregar_alumno.php?registro=exito");
            exit;
        } else {
            $mensaje = "❌ Error al registrar alumno: " . $stmt->error;
        }

    } else {
        $mensaje = "❌ No se pudo identificar al maestro.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar alumno</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
     <header class="header-principal">
        <h1>Instituto Tecnologico Inventado</h1>
        <nav class="main-nav">
        <ul>
            <li ><a href="dashboard.php">Menu</a></li>
            <li >Opcion 2</li>
            <li >Opcion 3</li>
            <li >Opcion 4</li>
        </ul>
        </nav>
        <img src="https://www.designevo.com/res/templates/thumb_small/banner-and-educational-supplies-shield.webp" alt="logo escuela">
    </header>

    <div class="agregarAlumno-container">
        <h1>Datos del alumno</h1>
        <form method="post" action="">
            <ul>
                <li><label>Nombre del alumno 
                    <input type="text" required placeholder="Nombre completo" name="nombre_alumno"> 
                    </label>
                </li>
                <li>
                <label>Grupo del alumno
                    <input type="text" required placeholder="Grupo" name="grupo_alumno">
                    </label>
                </li>
            </ul>
            <button type="submit">Registrar alumno</button>
        </form>
        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exito'): ?>
             <p style="color: green;">✅ Alumno registrado exitosamente.</p>
         <?php endif; ?>
        <?php if ($mensaje): ?>
            <p style="color: red;"><?php echo $mensaje; ?></p>
        <?php endif; ?>
    </div>    

</body>
</html>