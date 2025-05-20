document.addEventListener("DOMContentLoaded", function () {
    let imagenes = document.querySelectorAll(".img-ancho");

    function mostrarImagenes() {
        imagenes.forEach((img) => {
            let posicion = img.getBoundingClientRect().top;
            let alturaVentana = window.innerHeight;
            
            if (posicion < alturaVentana - 50) {
                img.classList.add("visible");
            }
        });
    }

    window.addEventListener("scroll", mostrarImagenes);
    mostrarImagenes(); // Llamada inicial por si hay imágenes visibles al cargar
});