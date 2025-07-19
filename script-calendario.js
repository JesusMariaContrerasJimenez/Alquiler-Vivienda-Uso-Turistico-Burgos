let calendario;
document.addEventListener("DOMContentLoaded", function () {
    let hoy = new Date(); // ✅ Fecha actual
    hoy.setHours(0, 0, 0, 0); // ✅ Eliminamos horas para comparación precisa
    
    calendario = new FullCalendar.Calendar(document.getElementById("calendario"), {
        initialView: "dayGridMonth",
        locale: "es",
        firstDay: 1,
        headerToolbar: {
            right: "prev,next",  
            left: "title",
        },
        validRange: {
            start: hoy.toISOString().split("T")[0] // ✅ Bloquea navegación antes de hoy
        },
        events: []
    });

    // **1️⃣ Cargar reservas desde la base de datos**
    fetch("obtener-reservas.php")
        .then(response => response.json())
        .then(data => {
            let eventos = data.map(reserva => ({
                title: "Reservado",
                start: reserva.FechaEntrada,
                end: ajustarFechaSalida(reserva.FechaSalida), // ✅ Asegura que la salida también quede marcada
                color: "red",
            }));

            // **2️⃣ Agregar eventos al calendario**
            calendario.addEventSource(eventos);
            calendario.render();
        })
        .catch(error => console.error("❌ Error al cargar reservas:", error));
});

// **3️⃣ Función para ajustar la fecha de salida**
function ajustarFechaSalida(fechaSalida) {
    let fecha = new Date(fechaSalida);
    fecha.setDate(fecha.getDate() + 1); // ✅ Añadir un día a la fecha de salida
    return fecha.toISOString().split("T")[0]; // ✅ Convertir a formato YYYY-MM-DD
}