<?php
require_once 'config/database.php';

class Venta {
    public static function guardar($productos) {
        $db = Database::getConnection();
        $db->beginTransaction();

        $stmt = $db->prepare("INSERT INTO ventas (fecha) VALUES (NOW())");
        $stmt->execute();
        $ventaId = $db->lastInsertId();

        $stmt = $db->prepare("
            INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio)
            VALUES (?, ?, ?, ?)
        ");
        foreach ($productos as $p) {
            $stmt->execute([$ventaId, $p['id'], $p['cantidad'], $p['precio']]);
        }

        $db->commit();
    }
}
