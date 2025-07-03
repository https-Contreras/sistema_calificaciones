<?php
$host = "localhost";
$usuario="root";
$contrasena="Jadac03s!";
$bd="escuela";

$conn=new mysqli($host, $usuario, $contrasena, $bd);

if ($conn->connect_error){
    echo "Conexion fallida: " . $conn->connect_error;
}

?>