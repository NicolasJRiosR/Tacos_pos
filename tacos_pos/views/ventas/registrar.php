<?php require 'views/layout/header.php'; ?>
<link rel="stylesheet" href="public/css/style.css">

<h2>Productos</h2>

<div id="menu-rapido">
    <button onclick="agregarProducto(1, 'Taco', 15)">Taco</button>
    <button onclick="agregarProducto(2, 'Refresco', 12)">Refresco</button>
    <button onclick="agregarProducto(3, 'Café', 10)">Café</button>
    <button onclick="agregarMultiples(1, 'Taco', 15, 5)">Orden de tacos</button>
</div>

<!-- Contenedor principal: Venta izquierda, columna derecha -->
<div style="display: flex; gap: 50px; margin-top: 20px; align-items: flex-start;">

    <!-- Venta a la izquierda -->
    <div style="flex: 1;">
        <h3>Venta</h3>
        <table id="ticket">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th>Cant.</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Columna derecha -->
<div style="display: flex; flex-direction: column; gap: 10px; min-width: 250px;">

    <!-- Teclado numérico -->
    <div id="teclado">
        <div>
            <button type="button" onclick="agregarNumero(1)">1</button>
            <button type="button" onclick="agregarNumero(2)">2</button>
            <button type="button" onclick="agregarNumero(3)">3</button>
        </div>
        <div>
            <button type="button" onclick="agregarNumero(4)">4</button>
            <button type="button" onclick="agregarNumero(5)">5</button>
            <button type="button" onclick="agregarNumero(6)">6</button>
        </div>
        <div>
            <button type="button" onclick="agregarNumero(7)">7</button>
            <button type="button" onclick="agregarNumero(8)">8</button>
            <button type="button" onclick="agregarNumero(9)">9</button>
        </div>
        <div>
            <button type="button" onclick="borrartodo()">❌</button>
            <button type="button" onclick="agregarNumero(0)">0</button>
            <button type="button" onclick="borrarNumero()">←</button>
        </div>
    </div>

    <!-- Billetes -->
    <div id="billetes">
        <button type="button" onclick="agregarBillete(20)">$20</button>
        <button type="button" onclick="agregarBillete(50)">$50</button>
        <button type="button" onclick="agregarBillete(100)">$100</button>
        <button type="button" onclick="agregarBillete(200)">$200</button>
        <button type="button" onclick="agregarBillete(500)">$500</button>
    </div>

    <!-- Pago y Total juntos -->
    <div style="display: flex; flex-direction: column; gap: 5px;">
        <div style="display: flex; flex-direction: column; gap: 2px;">
            <label for="pago">Pago:</label>
            <input type="number" id="pago" placeholder="Ingrese el pago">
            <div id="cambio"></div>
        </div>
        <p>Total: $<span id="total">0</span></p>
    </div>

    <!-- Botón Cobrar -->
    <button type="submit" form="formVenta" style="background-color:#27ae60;">Cobrar</button>

    <!-- Formulario oculto para Cobrar -->
    <form method="POST" action="index.php?controller=Venta&action=guardar" id="formVenta" style="display:none;">
        <input type="hidden" name="productos" id="productosInput">
    </form>

</div>

</div>

<script src="public/js/app.js"></script>
<?php require 'views/layout/footer.php'; ?>
