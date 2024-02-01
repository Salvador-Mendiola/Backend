<?php
    require_once realpath('./vendor/autoload.php');
    $dotenv=Dotenv\Dotenv::createImmutable('./');
    $dotenv->load();
    $puerto = $_ENV['PUERTO'];
    $usuario = $_ENV['USUARIO'];
    $bd = $_ENV['BD'];
    $password = $_ENV['PASSWORD'];
    $host = $_ENV['HOST'];
    $conexion = new PDO("mysql:host=$host;port=$puerto;dbname=$bd",$usuario,$password);

    if ($conexion != True) {
        echo "No se pudo conectar :(";
    }else {
        echo "Conectado :3";
    }

?>