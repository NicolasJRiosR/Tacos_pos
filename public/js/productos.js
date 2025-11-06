document.addEventListener("DOMContentLoaded", () => {
  const btnNuevo = document.getElementById("nuevoProductoBtn");
  const formNuevo = document.getElementById("formNuevoProducto");
  const formAgregar = document.getElementById("formAgregarProducto");
  const tabla = document.querySelector("#tablaProductos tbody");

  // Mostrar/ocultar formulario de nuevo producto
  btnNuevo.addEventListener("click", () => {
    formNuevo.style.display =
      formNuevo.style.display === "none" ? "block" : "none";
  });

  // Agregar producto
  formAgregar.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    // Validar precio y stock
    const precio = parseFloat(formData.get("precio"));
    const stock = parseInt(formData.get("stock"));

    if (precio < 0) {
      alert("El precio no puede ser menor a 0");
      return;
    }
    if (stock < 0) {
      alert("El stock no puede ser menor a 0");
      return;
    }

    fetch("index.php?controller=Producto&action=guardar", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          const tr = document.createElement("tr");
          tr.dataset.id = data.id;

          tr.innerHTML = `
            <td class="nombre">${data.nombre}</td>
            <td class="precio">$${parseFloat(data.precio).toFixed(2)}</td>
            <td class="codigo">${data.codigo_barra}</td>
            <td class="stock">${data.stock}</td>
            <td>
              <button class="editar" type="button">Editar</button>
              <button class="guardar" type="button" style="display:none;">Guardar</button>
              <button class="cancelar" type="button" style="display:none;">Cancelar</button>
              <button class="eliminar" type="button">Eliminar</button>
            </td>
          `;
          tabla.appendChild(tr);

          this.reset();
          formNuevo.style.display = "none";
        } else {
          alert("Error al agregar producto");
        }
      });
  });

  // Manejo de eventos en la tabla
  tabla.addEventListener("click", function (e) {
    const tr = e.target.closest("tr");
    if (!tr) return;
    const id = tr.dataset.id;

    // Eliminar producto
    if (e.target.classList.contains("eliminar")) {
      fetch("index.php?controller=Producto&action=eliminar", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}`,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) tr.remove();
          else alert("Error al eliminar producto");
        });
    }

    // Editar producto
    if (e.target.classList.contains("editar")) {
      const nombre = tr.querySelector(".nombre");
      const precio = tr.querySelector(".precio");
      const codigo = tr.querySelector(".codigo");
      const stock = tr.querySelector(".stock");

      // Guardar valores originales
      tr.dataset.originalNombre = nombre.textContent.trim();
      tr.dataset.originalPrecio = precio.textContent.replace("$", "").trim();
      tr.dataset.originalCodigo = codigo.textContent.trim();
      tr.dataset.originalStock = stock.textContent.trim();

      // Reemplazar con inputs
      nombre.innerHTML = `<input type="text" value="${nombre.textContent.trim()}">`;
      precio.innerHTML = `<input type="number" step="0.01" min="0" value="${precio.textContent
        .replace("$", "")
        .trim()}">`;
      codigo.innerHTML = `<input type="text" value="${codigo.textContent.trim()}">`;
      stock.innerHTML = `<input type="number" step="1" min="0" value="${stock.textContent.trim()}">`;

      tr.querySelector(".editar").style.display = "none";
      tr.querySelector(".guardar").style.display = "inline";
      tr.querySelector(".cancelar").style.display = "inline";
    }

    // Cancelar edición
    if (e.target.classList.contains("cancelar")) {
      tr.querySelector(".nombre").textContent = tr.dataset.originalNombre;
      tr.querySelector(".precio").textContent = `$${parseFloat(
        tr.dataset.originalPrecio
      ).toFixed(2)}`;
      tr.querySelector(".codigo").textContent = tr.dataset.originalCodigo;
      tr.querySelector(".stock").textContent = tr.dataset.originalStock;

      tr.querySelector(".editar").style.display = "inline";
      tr.querySelector(".guardar").style.display = "none";
      tr.querySelector(".cancelar").style.display = "none";
    }

    // Guardar cambios
    if (e.target.classList.contains("guardar")) {
      const nombre = tr.querySelector(".nombre input").value;
      const precio = parseFloat(tr.querySelector(".precio input").value);
      const codigo = tr.querySelector(".codigo input").value;
      const stock = parseInt(tr.querySelector(".stock input").value);

      // Validar precio y stock
      if (precio < 0) {
        alert("El precio no puede ser menor a 0");
        return;
      }
      if (stock < 0) {
        alert("El stock no puede ser menor a 0");
        return;
      }

      const formData = new URLSearchParams();
      formData.append("id", id);
      formData.append("nombre", nombre);
      formData.append("precio", precio);
      formData.append("codigo_barra", codigo);
      formData.append("stock", stock);

      fetch("index.php?controller=Producto&action=actualizar", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: formData.toString(),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            tr.querySelector(".nombre").textContent = nombre;
            tr.querySelector(".precio").textContent = `$${parseFloat(
              precio
            ).toFixed(2)}`;
            tr.querySelector(".codigo").textContent = codigo;
            tr.querySelector(".stock").textContent = stock;

            tr.querySelector(".editar").style.display = "inline";
            tr.querySelector(".guardar").style.display = "none";
            tr.querySelector(".cancelar").style.display = "none";
          } else {
            alert("Error al actualizar producto");
          }
        });
    }
  });
});
