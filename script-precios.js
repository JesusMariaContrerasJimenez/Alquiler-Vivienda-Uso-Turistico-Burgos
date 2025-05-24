document.getElementById("form-reserva").addEventListener("submit", async function (event) { // ✅ Marcar como async
    event.preventDefault(); // Evita recargar la página
    
    let fechaInicio = document.getElementById("fecha-inicio").value;
    let fechaSalida = document.getElementById("fecha-salida").value;
    let numeroPersonas = parseInt(document.getElementById("personas").value);
    
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

    let fechaInicioObj = new Date(fechaInicio);
    let fechaSalidaObj = new Date(fechaSalida);

    let incrementoOpcional = 20; 

    // **Calcula la cantidad de noches**
    for (let fecha = new Date(fechaInicioObj); fecha < fechaSalidaObj; fecha.setDate(fecha.getDate() + 1)) {
        let diaSemana = fecha.getDay();
        if (diaSemana === 5 || diaSemana === 6) { // Viernes o sábado
            nochesFestivoFinSemana++;
        } else {
            nochesDiarias++;
        }
    }

    // **Calcula el precio base**
    let precioBaseDiario = ((numeroPersonas * precioPersona) + precioDiarioBase) * nochesDiarias;
    let precioBaseFinSemana = ((numeroPersonas * precioPersona) + precioFinSemanaBase) * nochesFestivoFinSemana;
    let precioTotal = precioBaseDiario + precioBaseFinSemana + limpieza;

    // **3️⃣ Definir opciones adicionales por número de personas**
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

    // **4️⃣ Mostrar opciones en recuadros**
    let htmlOpciones = opciones.map(opcion => `
        <div class="opcion-reserva" onclick="mostrarFormulario('${opcion.nombre}', ${opcion.precio}, '${fechaInicio}', '${fechaSalida}', ${numeroPersonas})">
            <h3>${opcion.nombre}</h3>
            <p><strong>Precio total:</strong> ${opcion.precio}€</p>
        </div>
    `).join("");
    htmlOpciones += `<p style="text-align: center; font-weight: bold; margin-top: 20px;">Selecciona la opción que deseas reservar.</p>`;
    document.getElementById("resultado-precio").innerHTML = htmlOpciones;
});

// **2️⃣ Función para mostrar el formulario de reserva**
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

    let paypalContainer = document.createElement("div");
    paypalContainer.id = "paypal-button-container";
    formulario.appendChild(paypalContainer);
    iniciarPaypal(precio);
}

// **5️⃣ Integración con PayPal**
function iniciarPaypal(precio) {
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: { value: precio }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert("✅ Pago realizado con éxito por " + details.payer.name.given_name);
                guardarReserva();
            });
        }
    }).render("#paypal-button-container");
}

// **6️⃣ Guardar la reserva en la base de datos**
function guardarReserva() {
    let reservaData = new FormData();
    reservaData.append("dni", document.getElementById("dni").value);
    reservaData.append("nombre", document.getElementById("nombre").value);
    reservaData.append("apellidos", document.getElementById("apellidos").value);
    reservaData.append("email", document.getElementById("email").value);
    reservaData.append("telefono", document.getElementById("telefono").value);
    reservaData.append("numPersonas", document.getElementById("numPersonas").value);
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

// **7️⃣ Función para actualizar el calendario**
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