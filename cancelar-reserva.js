document.addEventListener("DOMContentLoaded", function () {
  const formCancelar = document.getElementById("form-cancelar");

  formCancelar.addEventListener("submit", async function (event) {
    // ✅ Mostrar confirmación antes de continuar
    const confirmar = confirm("¿Estás seguro/a de que deseas cancelar la reserva?");
    if (!confirmar) return;

    event.preventDefault();

    const id = document.getElementById("idCancelar").value.trim();
    const dni = document.getElementById("dniCancelar").value.trim();

    if (!id || !dni) {
      alert("⚠️ Por favor, completa todos los campos.");
      return;
    }

    try {
      const respuesta = await fetch("cancelar-reserva.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${encodeURIComponent(id)}&dni=${encodeURIComponent(dni)}`
      });

      const resultado = await respuesta.json();
      const divRespuesta = document.getElementById("respuesta-cancelacion");

      if (resultado.exito) {
        divRespuesta.innerHTML = `<p style="color: green;"><strong>✅ Reserva cancelada correctamente.</strong></p>`;

        // Opcional: eliminar visualmente del calendario si tienes la instancia global
        if (typeof calendario !== "undefined") {
          const evento = calendario.getEvents().find(e => e.id === id);
          if (evento) evento.remove();
        }
      } else {
        divRespuesta.innerHTML = `<p style="color: red;"><strong>❌ ${resultado.mensaje}</strong></p>`;
      }
    } catch (error) {
      console.error("❌ Error al cancelar la reserva:", error);
      alert("⚠️ Hubo un problema al procesar la cancelación.");
    }
  });
});
