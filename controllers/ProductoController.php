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
            $stock = $_POST['stock'] ?? 0;

            $exito = Producto::crear($nombre, $precio, $codigo_barra, $stock);

            if ($exito) {
                // 🔹 NUEVO: obtener el último ID insertado
                $id = Producto::ultimoIdInsertado();

                echo json_encode([
                    'success' => true,
                    'id' => $id,
                    'nombre' => $nombre,
                    'precio' => $precio,
                    'codigo_barra' => $codigo_barra,
                    'stock' => $stock
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
            $stock = $_POST['stock'] ?? 0;

            $exito = Producto::actualizar($id, $nombre, $precio, $codigo_barra, $stock);
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
    public function actualizarStock() {
    header('Content-Type: application/json');

    // Obtenemos el carrito enviado desde el frontend
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        echo json_encode(['success' => false, 'error' => 'No se recibió información']);
        return;
    }

    $todosExitos = true;

    // Aquí recorremos cada producto del carrito
    foreach ($data as $item) {
        // Buscamos el producto en la base de datos por ID (recomendado)
        $producto = Producto::buscarPorId($item['id']);  

        if ($producto) {
            // 🔹 Aquí es donde calculamos y actualizamos el stock
            $nuevoStock = max(0, intval($producto['stock']) - intval($item['cantidad']));
            Producto::actualizar(
                $producto['id'],
                $producto['nombre'],
                $producto['precio'],
                $producto['codigo_barra'],
                $nuevoStock
            );
        } else {
            $todosExitos = false;
        }
    }

    echo json_encode(['success' => $todosExitos]);
}
  
}
