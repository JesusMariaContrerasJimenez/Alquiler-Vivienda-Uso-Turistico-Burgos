const imagenes = [
    "./img/1-Captura portada.png",
    "./img/2-COMEDOR SALON.jpg",
    "./img/3-SALON COMEDOR.jpg",
    "./img/4-DORMITORIO DOBLE VISTA 1.jpg",
    "./img/4-DORMITORIO DOBLE VISTA2.jpg",
    "./img/5-DORMITORIO INDIVIDUAL vista1.jpg",
    "./img/5-DORMITORIO INDIVIDUAL vista 2.jpg",
    "./img/7-COCINA vista1.jpg",
    "./img/7-COCINA vista2.jpg",
    "./img/8-BAÑO vista1.jpg",
    "./img/8-BAÑO vista2.jpg",
    "./img/9-ASEO vista1.jpg",
    "./img/9-ASEO vista2.jpg",
    "./img/10-TERRAZA TENDEDERO.jpg",
    "./img/11-fachada principal.jpg",
    "./img/11-Vista posterior edificio.jpg",
    "./img/12-Garaje.jpg",
];

let indiceActual = 0;

function cambiarImagen(direccion) {
    indiceActual += direccion;
    
    if (indiceActual < 0) {
        indiceActual = imagenes.length - 1;
    } else if (indiceActual >= imagenes.length) {
        indiceActual = 0;
    }

    document.getElementById("imagen-principal").src = imagenes[indiceActual];
}