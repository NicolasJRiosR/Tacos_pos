<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {

    public function listado() {
        $productos = Producto::obtenerTodos();
        require __DIR__ . '/../views/productos/listado.php';
    }

    public function gestion() {
        $productos = Producto::obtenerTodos();
        require __DIR__ . '/../views/productos/gestionproductos.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $precio = $_POST['precio'] ?? '';
            $codigo_barra = $_POST['codigo_barra'] ?? '';

            $exito = Producto::crear($nombre, $precio, $codigo_barra);

            if ($exito) {
                $id = Producto::ultimoIdInsertado();
                echo json_encode([
                    'success' => true,
                    'id' => $id,
                    'nombre' => $nombre,
                    'precio' => $precio,
                    'codigo_barra' => $codigo_barra
                ]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $precio = $_POST['precio'] ?? '';
            $codigo_barra = $_POST['codigo_barra'] ?? '';

            $exito = Producto::actualizar($id, $nombre, $precio, $codigo_barra);
            echo json_encode(['success' => $exito]);
        }
    }

    public function eliminar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $resultado = Producto::eliminarPorId($id);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
        }
    }
}

    public function buscar() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $producto = Producto::buscarPorId($id);
                echo json_encode($producto ?: []);
            } else {
                echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
            }
        }
    }
}
