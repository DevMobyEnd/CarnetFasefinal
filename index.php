<?php
require_once './Controller/CarnetController.php';

$controlador = new CarnetController();

// Verifica si se está enviando el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controlador->procesarFormulario();
} else {
    $controlador->mostrarFormulario();
}