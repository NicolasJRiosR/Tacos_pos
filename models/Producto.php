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

   // stock agregado, valor por defecto 0
    public static function crear($nombre, $precio, $codigo_barra, $stock = 0) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO productos (nombre, precio, codigo_barra, stock) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre, $precio, $codigo_barra, $stock]);
    }

     public static function actualizar($id, $nombre, $precio, $codigo_barra, $stock) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE productos SET nombre = ?, precio = ?, codigo_barra = ?, stock = ? WHERE id = ?");
        return $stmt->execute([$nombre, $precio, $codigo_barra, $stock, $id]);
    }

   public static function eliminarPorId($id) {
    $db = Database::getConnection();
    $stmt = $db->prepare("DELETE FROM productos WHERE id = ?");
    return $stmt->execute([$id]);
    }
    public static function ultimoIdInsertado() {
    $db = Database::getConnection();
    return $db->lastInsertId();
}
public static function buscarPorId($id) {
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


}
