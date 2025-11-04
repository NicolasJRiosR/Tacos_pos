<?php
require_once 'models/Producto.php';

class ApiController {
    public function buscarProducto() {
        header('Content-Type: application/json');

        // Obtener el código desde la URL
        $codigo = $_GET['codigo'] ?? '';

        if (empty($codigo)) {
            echo json_encode(['error' => 'Código vacío']);
            return;
        }

        // Buscar el producto en la base de datos
        $producto = Producto::buscarPorCodigo($codigo);

        // Devolver el resultado como JSON
        echo json_encode($producto ?: []);
    }
}
