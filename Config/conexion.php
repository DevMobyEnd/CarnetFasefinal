<?php
require_once "global.php";

$conexion = mysqli_connect("DB_HOST", "DB_NAME", "DB_USERNAME", "DB_PASSWORD");

mysqli_query($conexion, 'SET NAMES"' . DB_ENCODE . '"');

if (mysqli_connect_error()) {
    print "Error al conectar con la base de datos: " . mysqli_connect_error();
    exit();
}
