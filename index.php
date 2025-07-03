<?php
session_start();
require_once 'logic/db.php';
$mensaje="";

if ($_SERVER['REQUEST_METHOD']==='POST'){
    $usuario= $_POST['usuario']??'';
    $contrasena = $_POST['contrasena']??'';
    $stmt =$conn->prepare("SELECT id, usuario, contrasena FROM maestros Where usuario= ? ");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows===1){
        $maestro = $resultado->fetch_assoc();
        if ($contrasena === $maestro['contrasena']){
            $_SESSION['usuario_maestro'] = $maestro['usuario'];
            $_SESSION['maestro_id'] = $maestro['id'];
            header('Location: dashboard.php');
            exit;
        }else{
            $mensaje="Contraseña incorrecta";
        }
    }else{
        $mensaje = "Usuario no encontrado";
    }
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesion</title>
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
            <li >Opcion 4</li>
        </ul>
        </nav>
        <img src="https://www.designevo.com/res/templates/thumb_small/banner-and-educational-supplies-shield.webp" alt="logo escuela">
    </header>

    <div class="login-container">
        <h2>Iniciar sesion</h2>
    <?php if ($mensaje):?>
            <p class="error"><?=htmlspecialchars($mensaje);?></p>
    <?php endif; ?>

        <form method="post" action="">
            <label>Usuario
            <input required for="text" placeholder="Usuario" name="usuario">
             </label>
            <label > Contraseña 
            <input required for="password" placeholder="Contraseña" name="contrasena">
            </label>
            <button type="submit">Iniciar sesion</button>
        </form>

    </div>
</body>
</html>