document.getElementById("contact-form").addEventListener("submit", function(event) {
    event.preventDefault(); // 🚀 Evita recargar la página

    let formData = new FormData(this);

    fetch("enviar-email.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("mensaje-enviado").style.display = "block";
            document.getElementById("contact-form").reset(); // ✅ Vaciar el formulario
        } else {
            alert("❌ Error al enviar el mensaje.");
        }
    })
    .catch(error => console.error("❌ Error:", error));
});