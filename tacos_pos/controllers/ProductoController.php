<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    public function listado() {
        $productos = Producto::obtenerTodos();
        require __DIR__ . '/../views/productos/listado.php';
    }
}