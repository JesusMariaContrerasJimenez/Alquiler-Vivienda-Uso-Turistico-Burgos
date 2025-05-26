document.getElementById("valoracion-form").addEventListener("submit", function(event) {
    event.preventDefault(); // ✅ Evita recargar la página

    let formData = new FormData(this);

    fetch("guardar-valoracion.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("✅ ¡Tu valoración se ha guardado correctamente!");
            cargarValoraciones(); // ✅ Refrescar lista de valoraciones
            this.reset(); // ✅ Vaciar el formulario
        } else {
            alert("❌ Error al guardar la valoración.");
        }
    })
    .catch(error => console.error("❌ Error:", error));
});

// **Función para cargar las valoraciones desde PHP**
function cargarValoraciones(mostrarTodas = false) {
    let url = mostrarTodas ? "obtener-valoraciones.php?todas=true" : "obtener-valoraciones.php";
    fetch(url)
        .then(response => response.json())
        .then(data => {
            // ✅ Mostrar la media y el número total de valoraciones
            document.getElementById("valoraciones-lista").innerHTML = `
                <h2>Valoraciones de nuestros huéspedes - ⭐ ${data.media}/5 (${data.total} valoraciones)</h2>
                <div id="valoraciones-container"></div>
            `;

            // ✅ Generar las valoraciones individuales
            let html = data.valoraciones.map(val => `
                <div class="valoracion">
                    <h3>${val.nombre} - ⭐ ${val.general}/5 <small>${val.fecha}</small></h3>
                    <p><strong>Limpieza:</strong> ${val.limpieza}/5 | <strong>Veracidad:</strong> ${val.veracidad}/5</p>
                    <p><strong>Llegada:</strong> ${val.llegada}/5 | <strong>Comunicación:</strong> ${val.comunicacion}/5</p>
                    <p><strong>Ubicación:</strong> ${val.ubicacion}/5 | <strong>Calidad:</strong> ${val.calidad}/5</p>
                    <p>"${val.comentario}"</p>
                </div>
            `).join("");

            document.getElementById("valoraciones-container").innerHTML = html;

            // ✅ Solo mostrar el botón si hay más de 3 valoraciones
            if (data.total > 3 && !mostrarTodas) {
                document.getElementById("valoraciones-lista").innerHTML += `<button id="mostrar-todas">Mostrar todas las valoraciones</button>`;
                
                document.getElementById("mostrar-todas").addEventListener("click", () => cargarValoraciones(true));
            }
        
        })
        .catch(error => console.error("❌ Error al cargar valoraciones:", error));
}

// ✅ Cargar solo 3 valoraciones al iniciar
document.addEventListener("DOMContentLoaded", () => cargarValoraciones(false));

// ✅ Event listener para mostrar todas las valoraciones al hacer clic en el botón
const botonMostrarTodas = document.getElementById("mostrar-todas");
if (botonMostrarTodas) {
    botonMostrarTodas.addEventListener("click", () => cargarValoraciones(true));
}