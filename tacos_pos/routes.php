<?php
$controller = $_GET['controller'] ?? 'Producto';
$action = $_GET['action'] ?? 'listado';

$controllerFile = "controllers/{$controller}Controller.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $className = "{$controller}Controller";
    $ctrl = new $className();

    if (method_exists($ctrl, $action)) {
        $ctrl->$action();
    } else {
        echo "Acción no encontrada.";
    }
} else {
    echo "Controlador no encontrado.";
}