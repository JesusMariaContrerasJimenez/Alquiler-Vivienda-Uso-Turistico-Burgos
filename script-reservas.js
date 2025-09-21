// ✅ Variable global para el calendario
let calendario;

document.addEventListener("DOMContentLoaded", function () {
    let hoy = new Date();
    hoy.setHours(0, 0, 0, 0); // ✅ Eliminamos horas para comparación precisa
    
    calendario = new FullCalendar.Calendar(document.getElementById("calendario"), {
        initialView: "multiMonth",
        duration: { months: 2 },
        locale: "es",
        firstDay: 1,
        height: "auto",
        headerToolbar: {
            left: "prev",
            center: "title",
            right: "next"
        },
        validRange: {
            start: hoy.toISOString().split("T")[0] // ✅ Bloquea navegación antes de hoy
        },
        events: []
    });

    // **Cargar reservas desde la base de datos**
    fetch("obtener-reservas.php")
        .then(response => response.json())
        .then(data => {
            let eventos = data.map(reserva => ({
                title: "Reservado",
                start: reserva.FechaEntrada,
                end: ajustarFechaSalida(reserva.FechaSalida),
                color: "red",
            }));

            calendario.addEventSource(eventos);
            calendario.render();
        })
        .catch(error => console.error("❌ Error al cargar reservas:", error));
});

// ✅ Función para ajustar la fecha de salida (marca el día completo)
function ajustarFechaSalida(fechaSalida) {
    let fecha = new Date(fechaSalida);
    fecha.setDate(fecha.getDate() + 1); // ✅ Asegura que se incluya el día de salida
    return fecha.toISOString().split("T")[0]; 
}

// ✅ Evento para calcular precios sin agregar al calendario automáticamente
document.getElementById("form-reserva").addEventListener("submit", async function (event) {
    event.preventDefault(); // ✅ Evita la recarga de la página

    let fechaInicio = document.getElementById("fecha-inicio").value;
    let fechaSalida = document.getElementById("fecha-salida").value;

    let numeroPersonas = parseInt(document.getElementById("personas").value);
    let necesitaCuna = document.getElementById("necesitaCuna").value === "1" ? "Sí" : "No";
    let fechaInicioObj = new Date(fechaInicio);
    let fechaSalidaObj = new Date(fechaSalida);
    let diferenciaDias = Math.ceil((fechaSalidaObj - fechaInicioObj) / (1000 * 60 * 60 * 24)); 

    let hoy = new Date();
    hoy.setHours(0, 0, 0, 0); // ✅ Asegura que la comparación no tenga conflictos con horas

    if (fechaInicioObj < hoy) {
        alert("⚠️ No puedes hacer una reserva con fecha de inicio anterior a hoy.");
        return; // 🚀 Detiene la ejecución si la fecha no es válida
    }

    let mesInicio = fechaInicioObj.getMonth() + 1; // ✅ Los meses van de 0 a 11, sumamos 1 para que vayan de 1 a 12

    if (numeroPersonas === 1 && (mesInicio >= 4 && mesInicio <= 9)) {
        alert("⚠️ De abril a septiembre, la reserva debe ser para al menos 2 personas.");
        return; // 🚀 Detiene la ejecución si no cumple la restricción
    }

    // ⛔ Restricción para 1 persona
    if (numeroPersonas === 1 && diferenciaDias > 4) {
        alert("⚠️ Para una sola persona, la estancia máxima permitida es de 4 noches.");
        return;
    }

    // **1️⃣ Consultar disponibilidad en la base de datos**
    let respuesta = await fetch("https://4bspisoturisticoburgos.free.nf/comprobar-disponibilidad.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `fechaInicio=${fechaInicio}&fechaSalida=${fechaSalida}`
    });

    let resultado = await respuesta.json();

    if (!resultado.disponible) {
        document.getElementById("resultado-precio").innerHTML = `
            <h2 style="color: red;">⚠️ ${resultado.mensaje}</h2>
        `;
        return; // Detiene la ejecución si la fecha está ocupada
    }

    // **2️⃣ Calcular el precio total**
    let precioPersona = 20;
    let limpieza = 125;
    let precioDiarioBase = 60;
    let precioFinSemanaBase = 95;
    let nochesDiarias = 0;
    let nochesFestivoFinSemana = 0;
    let incrementoOpcional = 20; 

    // Obtiene festivos
    let pais = "ES"; // España
    let año = fechaInicioObj.getFullYear(); 
    let respuestaFestivos = await fetch(`https://date.nager.at/api/v3/PublicHolidays/${año}/${pais}`);
    let festivos = await respuestaFestivos.json();

    // **Calcula la cantidad de noches**
    for (let fecha = new Date(fechaInicioObj); fecha < fechaSalidaObj; fecha.setDate(fecha.getDate() + 1)) {
        let diaSemana = fecha.getDay();
        let fechaString = fecha.toISOString().split("T")[0]; // Formato YYYY-MM-DD
        
        // ✅ Si es un festivo, se cuenta como festivo
        let esFestivo = festivos.some(festivo => festivo.date === fechaString);

        if (diaSemana === 5 || diaSemana === 6 || esFestivo) { // Viernes o sábado o festivo
            nochesFestivoFinSemana++;
        } else {
            nochesDiarias++;
        }
    }

    // **Verificar si la estancia cumple con las reglas**
    const totalNoches = nochesDiarias + nochesFestivoFinSemana;
    if (totalNoches < 2) {
        alert("⚠️ La estancia mínima debe ser de 2 noches.");
        return; // 🚀 Detiene la ejecución si no cumple la restricción
    }

    // **Calcula el precio base**
    let precioBaseDiario = ((numeroPersonas * precioPersona) + precioDiarioBase) * nochesDiarias;
    let precioBaseFinSemana = ((numeroPersonas * precioPersona) + precioFinSemanaBase) * nochesFestivoFinSemana;
    let precioTotal = precioBaseDiario + precioBaseFinSemana + limpieza;

    // **Aplica descuentos solo si hay más de una persona**
    if (numeroPersonas > 1) {
        if (diferenciaDias >= 6 && diferenciaDias < 30) { 
            precioTotal *= 0.97; // ✅ Descuento del 3% para una semana
        } else if (diferenciaDias >= 30) {
            precioTotal *= 0.82; // ✅ Descuento del 18% para un mes
        }
    }

    //Redondea a dos decimales
    precioTotal = parseFloat(precioTotal.toFixed(2)); // ✅ Redondea a dos decimales

    // **Definir opciones adicionales por número de personas**
    let opciones = [];

    if (numeroPersonas === 1) {
        opciones.push({ nombre: "Sofá cama", precio: precioTotal });
        opciones.push({ nombre: "Cama individual", precio: precioTotal + (incrementoOpcional * totalNoches) });
    } else if (numeroPersonas === 2 && diferenciaDias <= 4) {
        opciones.push({ nombre: "Sofá cama", precio: precioTotal-60 });
        opciones.push({ nombre: "Cama doble con baño", precio: precioTotal });
        opciones.push({ nombre: "Cama doble con baño + sofá cama", precio: precioTotal + (incrementoOpcional * totalNoches) });
    } else if (numeroPersonas === 2 && diferenciaDias > 4) {
        opciones.push({ nombre: "Cama doble con baño", precio: precioTotal });
        opciones.push({ nombre: "Cama doble con baño + sofá cama", precio: precioTotal + (incrementoOpcional * totalNoches) });
    } else if (numeroPersonas === 3) {
        opciones.push({ nombre: "Cama doble con baño + cama individual", precio: precioTotal });
        opciones.push({ nombre: "Cama doble con baño + cama individual + sofá cama", precio: precioTotal + (incrementoOpcional * totalNoches) });
    } else if (numeroPersonas === 4) {
        opciones.push({ nombre: "Cama doble con baño + sofá cama", precio: precioTotal });
        opciones.push({ nombre: "Cama doble con baño + sofá cama + cama individual", precio: precioTotal + (incrementoOpcional * totalNoches) });
    } else if (numeroPersonas === 5) {
        opciones.push({ nombre: "Cama doble con baño + sofá cama + cama individual", precio: precioTotal });
    }

    // **Mostrar opciones en recuadros**
    let htmlOpciones = opciones.map(opcion => `
        <div class="opcion-reserva" onclick="mostrarFormulario('${opcion.nombre}', ${opcion.precio}, '${fechaInicio}', '${fechaSalida}', ${numeroPersonas})">
            <h3>${opcion.nombre}</h3>
            <p><strong>Precio total:</strong> ${opcion.precio}€</p>
        </div>
    `).join("");
    htmlOpciones += `<p style="text-align: center; font-weight: bold; margin-top: 20px;">Selecciona la opción que deseas reservar.</p>`;
    document.getElementById("resultado-precio").innerHTML = htmlOpciones;
});

// ✅ Función para mostrar el formulario de confirmación
function mostrarFormulario(opcionSeleccionada, precio, fechaInicio, fechaSalida, numeroPersonas) {
    document.getElementById("formulario-reserva").style.display = "block";

    document.getElementById("formulario-reserva").innerHTML = `
        <h3>Completa tu reserva (${opcionSeleccionada})</h3>
        <p><strong>Precio total:</strong> ${precio}€</p>
        <form id="datos-reserva">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" required>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" required>
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" required>
            <label for="email">Email:</label>
            <input type="email" id="email" required>
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" required>
            <label for="numPersonas">Número de personas:</label>
            <input type="number" id="numPersonas" value="${numeroPersonas}" readonly>
            <label for="necesitaCuna">¿Necesita cuna?</label>
            <select id="necesitaCuna">
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>
            <label for="opcionSeleccionada">Opción seleccionada:</label>
            <input type="text" id="opcionSeleccionada" value="${opcionSeleccionada}" readonly>
            <label for="fechaEntrada">Fecha de entrada:</label>
            <input type="date" id="fechaEntrada" value="${fechaInicio}" readonly>
            <label for="fechaSalida">Fecha de salida:</label>
            <input type="date" id="fechaSalida" value="${fechaSalida}" readonly>
            <label for="precioTotal">Precio total:</label>
            <input type="number" id="precioTotal" value="${precio}" readonly>
            <button type="button" id="confirmar-reserva">Confirmar Reserva</button>
        </form>
    `;

    document.addEventListener("click", function (event) {
        if (event.target && event.target.id === "confirmar-reserva") {
            console.log("✅ Botón detectado con `document.addEventListener()`, ejecutando guardarReserva()");
            let nuevaReserva = {
                title: "Reservado",
                start: fechaInicio,
                end: fechaSalida,
                color: "red"
            };

            // 🚀 Solo agregar la reserva al calendario después de confirmar
            if (calendario && typeof calendario.addEvent === "function") {
                calendario.addEvent(nuevaReserva);
            } else {
                console.error("❌ Error: La instancia de `calendario` no está correctamente definida.");
            }
            guardarReserva();
        }
    });
    
}

// ✅ Función para guardar la reserva en la base de datos
function guardarReserva() {
    let reservaData = new FormData();
    reservaData.append("dni", document.getElementById("dni").value);
    reservaData.append("nombre", document.getElementById("nombre").value);
    reservaData.append("apellidos", document.getElementById("apellidos").value);
    reservaData.append("email", document.getElementById("email").value);
    reservaData.append("telefono", document.getElementById("telefono").value);
    reservaData.append("numPersonas", document.getElementById("numPersonas").value);
    reservaData.append("necesitaCuna", document.getElementById("necesitaCuna").value);
    reservaData.append("opcionSeleccionada", document.getElementById("opcionSeleccionada").value);
    reservaData.append("fechaEntrada", document.getElementById("fechaEntrada").value);
    reservaData.append("fechaSalida", document.getElementById("fechaSalida").value);
    reservaData.append("precioTotal", document.getElementById("precioTotal").value);

    console.log("📤 Enviando datos al servidor:", Object.fromEntries(reservaData.entries())); // ✅ Verifica los datos antes de enviarlos

    for (let [key, value] of reservaData.entries()) {
        if (!value) {
            alert(`⚠️ El campo "${key}" está vacío. Completa todos los datos.`);
            return;
        }
    }

    fetch("guardar-reserva.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams(Object.fromEntries(reservaData.entries()))
    })
    .then(response => response.text()) // ✅ Primero obtenemos texto plano
    .then(text => {
        try {
            let data = JSON.parse(text); // ✅ Convertimos a JSON manualmente
            console.log("✅ Respuesta del servidor:", data);
            if (data.success) {
                alert("✅ Reserva guardada correctamente.");
            } else {
                alert("❌ Error al registrar la reserva: " + data.error);
            }
        } catch (error) {
            console.error("❌ Error al procesar JSON:", error);
            console.error("🔍 Respuesta del servidor:", text); // ✅ Mostrar contenido para depuración
        }
    })
    .catch(error => console.error("❌ Error en la petición:", error));
}
