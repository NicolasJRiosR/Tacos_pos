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
}   