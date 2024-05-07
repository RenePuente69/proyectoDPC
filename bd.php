<?php

    $servidor = "localhost";
    $dataBase = "proyectopractica";
    $usuario = "root";
    $contrasena = "";

    try {
        $conexion = new PDO("mysql:host=$servidor; dbname=$dataBase", $usuario, $contrasena);
    }catch(Exception $ex){
        echo $ex->getMessage();
    }
?>