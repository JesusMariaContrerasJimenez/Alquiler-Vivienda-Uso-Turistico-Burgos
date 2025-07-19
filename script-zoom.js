document.querySelectorAll(".contenedor-galeria img").forEach(img => {
    img.addEventListener("click", () => {
        const modal = document.createElement("div");
        modal.classList.add("modal-imagen");
        modal.innerHTML = `<img src="${img.src}" alt="${img.alt}">`;

        modal.addEventListener("click", () => {
            modal.remove(); // ✅ Cierra el modal al hacer clic en la imagen
        });

        document.body.appendChild(modal);
    });
});