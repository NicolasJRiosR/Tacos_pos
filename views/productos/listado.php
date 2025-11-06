<?php require 'views/layout/header.php'; ?>

<h2>Listado de productos</h2>

<?php if (!empty($productos)): ?>
  <table border="1" cellpadding="5">
    <tr><th>ID</th><th>Nombre</th><th>Precio</th></tr>
    <?php foreach ($productos as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['id']) ?></td>
        <td><?= htmlspecialchars($p['nombre']) ?></td>
        <td>$<?= htmlspecialchars($p['precio']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php else: ?>
  <p>No hay productos registrados.</p>
<?php endif; ?>

<?php require 'views/layout/footer.php'; ?>
