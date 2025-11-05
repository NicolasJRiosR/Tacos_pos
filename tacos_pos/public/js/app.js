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

  if (!existente) {
    carrito.push({ id, nombre, precio, cantidad: 1 });
    renderTicket(id);
  } else {
    existente.cantidad++;
    renderTicket();
  }
}

function renderTicket(idFilaAnimada = null) {
  const tbody = document.querySelector("#ticket tbody");
  tbody.innerHTML = "";

  let total = 0;

  carrito.forEach((p, index) => {
    let subtotal = p.cantidad * p.precio;
    total += subtotal;

    let botonMenos =
      p.cantidad === 1
        ? `<button type="button" onclick="eliminarProducto(${index})">❌</button>`
        : `<button type="button" onclick="cambiarCantidad(${index}, -1)">-</button>`;

    let claseAnim = idFilaAnimada && p.id === idFilaAnimada ? "tr-entrada" : "";

    tbody.innerHTML += `
      <tr data-id="${p.id}" class="${claseAnim}">
        <td>${p.nombre}</td>
        <td>${p.precio}</td>
        <td>${subtotal}</td>
        <td>
          ${botonMenos}
          <span style="margin: 0 10px;">${p.cantidad}</span>
          <button type="button" onclick="cambiarCantidad(${index}, 1)">+</button>
        </td>
      </tr>
    `;
  });

  document.querySelector("#total").textContent = total;
  document.querySelector("#productosInput").value = JSON.stringify(carrito);
  calcularCambio();
}

function eliminarProducto(index) {
  const tbody = document.querySelector("#ticket tbody");
  const fila = tbody.children[index];

  // Aplicamos clase de salida
  fila.classList.add("tr-salida");

  // Esperamos a que termine la animación antes de actualizar el carrito
  fila.addEventListener(
    "animationend",
    () => {
      // Eliminamos del carrito
      carrito.splice(index, 1);
      // Renderizamos nuevamente
      renderTicket();
    },
    { once: true }
  );
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
function agregarNumero(n) {
  const pagoInput = document.querySelector("#pago");
  pagoInput.value += n;
  calcularCambio();
}

function borrarNumero() {
  const pagoInput = document.querySelector("#pago");
  pagoInput.value = pagoInput.value.slice(0, -1);
  calcularCambio();
}
function borrartodo() {
  const pagoInput = document.querySelector("#pago");
  pagoInput.value = "";
  calcularCambio();
}
function cambiarCantidad(index, cambio) {
  carrito[index].cantidad += cambio;
  if (carrito[index].cantidad < 1) {
    carrito[index].cantidad = 1;
  }
  renderTicket();
}

function agregarMultiples(id, nombre, precio, cantidad) {
  let existente = carrito.find((p) => p.id === id);

  if (existente) {
    existente.cantidad += cantidad;
    renderTicket(); // sin animación
  } else {
    carrito.push({ id, nombre, precio, cantidad });
    renderTicket(id); // con animación solo si es nuevo
  }
}
function agregarBillete(cantidad) {
  const pagoInput = document.querySelector("#pago");
  let actual = parseFloat(pagoInput.value) || 0;
  pagoInput.value = actual + cantidad;
  calcularCambio();
}
