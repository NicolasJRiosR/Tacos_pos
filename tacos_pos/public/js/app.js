let buffer = "";

document.addEventListener("keydown", (e) => {
  if (e.key === "Enter") {
    if (buffer.length > 0) {
      buscarProductoPorCodigo(buffer);
      buffer = "";
    }
  } else {
    if (e.key.length === 1) buffer += e.key.toUpperCase();
  }
});

function buscarProductoPorCodigo(codigo) {
  fetch(`index.php?controller=Api&action=buscarProducto&codigo=${codigo}`)
    .then((res) => res.json())
    .then((data) => {
      if (data && data.id) {
        agregarProducto(data.id, data.nombre, parseFloat(data.precio));
        reproducirBeep(); // opcional
      } else {
        alert(`Producto no encontrado (${codigo})`);
      }
    })
    .catch((err) => console.error("Error buscando producto:", err));
}

function reproducirBeep() {
  const beep = document.getElementById("beep");
  if (beep) beep.play();
}

let carrito = [];

function agregarProducto(id, nombre, precio) {
  let existente = carrito.find((p) => p.id === id);
  if (existente) {
    existente.cantidad++;
  } else {
    carrito.push({ id, nombre, precio, cantidad: 1 });
  }
  renderTicket();
}

function renderTicket() {
  const tbody = document.querySelector("#ticket tbody");
  tbody.innerHTML = "";

  let total = 0;

  carrito.forEach((p) => {
    let subtotal = p.cantidad * p.precio;
    total += subtotal;
    tbody.innerHTML += `
      <tr>
        <td>${p.nombre}</td>
        <td>${p.cantidad}</td>
        <td>${p.precio}</td>
        <td>${subtotal}</td>
      </tr>
    `;
  });

  document.querySelector("#total").textContent = total;
  document.querySelector("#productosInput").value = JSON.stringify(carrito);

  calcularCambio();
}

document.querySelector("#pago").addEventListener("input", calcularCambio);

function calcularCambio() {
  const total = carrito.reduce((sum, p) => sum + p.cantidad * p.precio, 0);
  const pago = parseFloat(document.querySelector("#pago").value) || 0;
  const cambioElem = document.querySelector("#cambio");

  if (pago >= total && total > 0) {
    const cambio = pago - total;
    cambioElem.textContent = `Cambio: $${cambio}`;
    cambioElem.style.color = "green"; // mensaje en verde
  } else if (pago > 0) {
    cambioElem.textContent = `Falta: $${total - pago}`;
    cambioElem.style.color = "red"; // mensaje en rojo
  } else {
    cambioElem.textContent = "";
  }
}
