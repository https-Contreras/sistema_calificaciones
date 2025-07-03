<?php

session_start();
if(!isset($_SESSION['usuario_maestro'])){
    header('Location: index.php');
    exit;
}

$maestro_id = $_SESSION['usuario_maestro'];

?>





<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maestro</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>


    <header class="header-principal">
        <h1>Instituto Tecnologico Inventado</h1>
        <nav class="main-nav">
        <ul>
            <li >Opcion 1</li>
            <li >Opcion 2</li>
            <li >Opcion 3</li>
            <li ><a href="logout.php">Logout</a></li>
        </ul>
        </nav>
        <img src="https://www.designevo.com/res/templates/thumb_small/banner-and-educational-supplies-shield.webp" alt="logo escuela">
    </header>

    
    <div class="dashboard-container">
    <h1>Bienvenido <?=$maestro_id?></h1>
    <p>¿Que desea hacer?</p>

    <ul>
        <li><a href="agregar_alumno.php"> Registrar alumno</a></li>
        <li><a href="ver_alumnos.php">Ver alumnos</a></li>
        <li><a href="agregar_calificacion.php">Agregar calificaciones</a></li>
        <li><a href="logout.php">Cerrar sesion</a></li>
    </ul>
    </div>
</body>
</html>