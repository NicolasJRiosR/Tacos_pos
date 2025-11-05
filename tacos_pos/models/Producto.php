<?php
require_once 'config/database.php';

class Producto {

    public static function obtenerTodos() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM productos ORDER BY nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorCodigo($codigo) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM productos WHERE codigo_barra = ?");
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function crear($nombre, $precio, $codigo_barra) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO productos (nombre, precio, codigo_barra) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $precio, $codigo_barra]);
    }

    public static function actualizar($id, $nombre, $precio, $codigo_barra) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE productos SET nombre = ?, precio = ?, codigo_barra = ? WHERE id = ?");
        return $stmt->execute([$nombre, $precio, $codigo_barra, $id]);
    }

   public static function eliminarPorId($id) {
    $db = Database::getConnection();
    $stmt = $db->prepare("DELETE FROM productos WHERE id = ?");
    return $stmt->execute([$id]);
    }

}
