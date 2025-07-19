document.getElementById("form-reserva").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita la recarga de la página

    let fechaInicio = document.getElementById("fecha-inicio").value;
    let fechaSalida = document.getElementById("fecha-salida").value;
    
    let nuevaReserva = {
        title: "Reservado",
        start: fechaInicio,
        end: fechaSalida,
        color: "red", // Marcar en rojo los días ocupados
    };

    // 🚀 Verifica que `calendario` está definido antes de agregar eventos
    if (typeof calendario !== "undefined" && typeof calendario.addEvent === "function") {
        calendario.addEvent(nuevaReserva); // ✅ Usar `addEvent()` en lugar de `addEventSource()`
    } else {
        console.error("❌ Error: La instancia de `calendario` no está correctamente definida.");
    }

    alert("¡Reserva realizada con éxito!");
});