document.getElementById("form-reserva").addEventListener("submit", async function (event) { // ✅ Marcar como async
    event.preventDefault(); // Evita recargar la página
    
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
    if (nochesDiarias < 4 && nochesFestivoFinSemana < 2) {
        alert("⚠️ La estancia mínima debe ser de al menos 4 días laborables o 2 días de fin de semana.");
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
        opciones.push({ nombre: "Cama individual", precio: precioTotal });
        opciones.push({ nombre: "Cama doble con baño", precio: precioTotal + (incrementoOpcional * nochesDiarias) + (incrementoOpcional * nochesFestivoFinSemana)});
    } else if (numeroPersonas === 2) {
        opciones.push({ nombre: "Sofá cama", precio: precioTotal-60 });
        opciones.push({ nombre: "Cama doble con baño", precio: precioTotal });
        opciones.push({ nombre: "Cama doble con baño + cama individual", precio: precioTotal + (incrementoOpcional * nochesDiarias) + (incrementoOpcional * nochesFestivoFinSemana)});
    } else if (numeroPersonas === 3) {
        opciones.push({ nombre: "Cama doble con baño + cama individual", precio: precioTotal });
        opciones.push({ nombre: "Cama doble con baño + cama individual + sofá cama", precio: precioTotal + (incrementoOpcional * nochesDiarias) + (incrementoOpcional * nochesFestivoFinSemana)});
    } else if (numeroPersonas === 4) {
        opciones.push({ nombre: "Cama doble con baño + sofá cama", precio: precioTotal });
        opciones.push({ nombre: "Cama doble con baño + sofá cama + cama individual", precio: precioTotal + (incrementoOpcional * nochesDiarias) + (incrementoOpcional * nochesFestivoFinSemana)});
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

// **Función para mostrar el formulario de reserva**
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
            <button type="submit" id="confirmar-reserva">Confirmar Reserva</button>
        </form>
    `;
    document.getElementById("confirmarReserva").addEventListener("click", function () {
        console.log("✅ Confirmación activada, ejecutando guardarReserva()");
        guardarReserva();
    });
}

// **Guardar la reserva en la base de datos**
function guardarReserva() {
    let reservaData = new FormData();
    reservaData.append("dni", document.getElementById("dni").value);
    reservaData.append("nombre", document.getElementById("nombre").value);
    reservaData.append("apellidos", document.getElementById("apellidos").value);
    reservaData.append("email", document.getElementById("email").value);
    reservaData.append("telefono", document.getElementById("telefono").value);
    reservaData.append("numPersonas", document.getElementById("numPersonas").value);
    reservaData.append("necesitaCuna", document.getElementById("necesitaCuna").value);
    reservaData.append("fechaEntrada", document.getElementById("fechaEntrada").value);
    reservaData.append("fechaSalida", document.getElementById("fechaSalida").value);
    reservaData.append("precioTotal", document.getElementById("precioTotal").value);

    fetch("guardar-reserva.php", {
        method: "POST",
        body: reservaData
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              alert("✅ Reserva guardada correctamente.");
              actualizarCalendario();
          } else {
              alert("❌ Error al registrar la reserva.");
          }
      });
}

// **Función para actualizar el calendario**
function actualizarCalendario() {
    fetch("obtener_reservas.php")
        .then(response => response.json())
        .then(data => {
            let eventos = data.map(reserva => ({
                title: "Reservado",
                start: reserva.FechaEntrada,
                end: reserva.FechaSalida,
                color: "red",
            }));
            let calendario = new FullCalendar.Calendar(document.getElementById("calendario"), {
                initialView: "dayGridMonth",
                locale: "es",
                firstDay: 1,
                headerToolbar: { right: "prev,next", left: "title" },
                events: eventos,
            });
            calendario.render();
        })
        .catch(error => console.error("❌ Error al actualizar el calendario:", error));
}
