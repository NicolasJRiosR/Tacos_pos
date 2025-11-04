<?php
require_once 'models/Venta.php';

class VentaController {
    public function registrar() {
        require 'views/ventas/registrar.php';
    }

    public function guardar() {
        if (!empty($_POST['productos'])) {
            
            $productos = json_decode($_POST['productos'], true);

            if (is_array($productos)) {
                Venta::guardar($productos);
                header('Location: index.php?controller=Venta&action=registrar&success=1');
                exit;
            } else {
                echo "<h3>Error: datos de productos inválidos.</h3>";
            }
        } else {
            echo "<h3'> No se recibieron productos.</h3>";
        }
    }
}
