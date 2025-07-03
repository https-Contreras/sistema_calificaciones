<?php
session_start();
if(!isset($_SESSION['usuario_maestro'])){
    header('Location: index.php');
    exit;
}



?>