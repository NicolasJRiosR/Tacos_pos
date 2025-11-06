<?php require 'views/layout/header.php'; ?>

<h2>Gestión de Productos</h2>

<button id="nuevoProductoBtn" type="button">Nuevo Producto</button>

<div id="formNuevoProducto" style="display:none; margin-top:10px;">
    <form id="formAgregarProducto">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required>
        <input type="text" name="codigo_barra" placeholder="Código / Scaner" required>
        <input type="number" name="stock" step="1" placeholder="Stock inicial" value="0" required>
        <button type="submit">Agregar Producto</button>
    </form>
</div>

<h3>Productos Registrados</h3>
<table id="tablaProductos">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Código</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once 'models/Producto.php';
        $productos = Producto::obtenerTodos();
        foreach ($productos as $p): ?>
            <tr data-id="<?= $p['id'] ?>">
                <td class="nombre"><?= htmlspecialchars($p['nombre']) ?></td>
                <td class="precio">$<?= number_format($p['precio'], 2) ?></td>
                <td class="codigo"><?= htmlspecialchars($p['codigo_barra']) ?></td>
                <td class="stock"><?= htmlspecialchars($p['stock']) ?></td>
                <td>
                    <button class="editar" type="button">Editar</button>
                    <button class="guardar" type="button" style="display:none;">Guardar</button>
                    <button class="cancelar" type="button" style="display:none;">Cancelar</button>
                    <button class="eliminar" type="button">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="public/js/productos.js"></script>
<?php require 'views/layout/footer.php'; ?>
