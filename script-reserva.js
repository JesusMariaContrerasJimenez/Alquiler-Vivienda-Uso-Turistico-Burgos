document.getElementById("form-reserva").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita la recarga de la página

    let fechaInicio = document.getElementById("fecha-inicio").value;
    let fechaSalida = document.getElementById("fecha-salida").value;
    let nombre = document.getElementById("nombre").value;
    let email = document.getElementById("email").value;
    let personas = document.getElementById("personas").value;

    let nuevaReserva = {
        title: "Reservado",
        start: fechaInicio,
        end: fechaSalida,
        color: "red", // Marcar en rojo los días ocupados
    };

    calendario.addEvent(nuevaReserva); // Agrega la reserva al calendario dinámicamente

    alert("¡Reserva realizada con éxito!");
});