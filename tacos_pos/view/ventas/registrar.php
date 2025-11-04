<?php require 'views/layout/header.php'; ?>

<h2>Registrar venta</h2>

<div id="menu-rapido">
    <button onclick="agregarProducto(1, 'Taco', 15)">Taco</button>
    <button onclick="agregarProducto(2, 'Refresco', 12)">Refresco</button>
    <button onclick="agregarProducto(3, 'Café', 10)">Café</button>
</div>

<h3>Ticket</h3>
<table id="ticket">
    <thead>
        <tr><th>Producto</th><th>Cant.</th><th>Precio</th><th>Total</th></tr>
    </thead>
    <tbody></tbody>
</table>

<form method="POST" action="index.php?controller=Venta&action=guardar" id="formVenta">
    <input type="hidden" name="productos" id="productosInput">
    <button type="submit">Cobrar</button>
</form>

<script src="public/js/app.js"></script>

<?php require 'views/layout/footer.php'; ?>