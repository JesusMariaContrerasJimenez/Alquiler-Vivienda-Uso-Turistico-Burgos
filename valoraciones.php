<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta 
            name="Alquiler Burgos"
            content="Alquiler piso turistico burgos" />
        <meta name="Valoraciones 4BS" content="Esta es la página principal de valoraciones de 4BS">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>4B'S piso turístico Burgos</title>
        <link rel="icon" href="./img/favicon.jpg" type="image/x-icon"/>
        <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <div id="google_translate_element"></div>
        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                pageLanguage: 'es', // Idioma original de la web
                includedLanguages: 'en,fr,de,it,pt', // Idiomas para traducir
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                }, 'google_translate_element');
            }
        </script>
        <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    </head>
    
    <body>
        <!--Header -->
        <header>
            <div class="header">
                <a href="index.php">
                    <img src="./img/logo blanco.jpg" alt="4BS logotipo" class="logo">
                </a>
                <nav>
                    <ul class="ul-nav">
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="gal.php">Galeria</a></li>
                        <li><a href="reservas.php">Reservas</a></li>
                        <li class="active"><a href="valoraciones.php">Valoraciones</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <section id="formulario-valoraciones">
                <h2>Deja tu valoración</h2>
                <form id="valoracion-form">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="general">Valoración general:</label>
                    <input type="number" id="general" name="general" min="1" max="5" required>

                    <label for="limpieza">Limpieza:</label>
                    <input type="number" id="limpieza" name="limpieza" min="1" max="5" required>

                    <label for="veracidad">Veracidad:</label>
                    <input type="number" id="veracidad" name="veracidad" min="1" max="5" required>

                    <label for="llegada">Llegada:</label>
                    <input type="number" id="llegada" name="llegada" min="1" max="5" required>

                    <label for="comunicacion">Comunicación:</label>
                    <input type="number" id="comunicacion" name="comunicacion" min="1" max="5" required>

                    <label for="ubicacion">Ubicación:</label>
                    <input type="number" id="ubicacion" name="ubicacion" min="1" max="5" required>

                    <label for="calidad">Calidad:</label>
                    <input type="number" id="calidad" name="calidad" min="1" max="5" required>

                    <label for="comentario">Comentario:</label>
                    <textarea id="comentario" name="comentario" required></textarea>

                    <button type="submit">Enviar Valoración</button>
                </form>
            </section>

            <section id="valoraciones-lista">
                <h2>Valoraciones de nuestros huéspedes</h2>
                <div id="valoraciones-container"></div>
                <button id="mostrar-todas">Mostrar todas las valoraciones</button>
            </section>
        </main>

        <!-- Footer -->
        <footer>
            <div class="tres-columnas">
                <div>
                    <a href="index.php">
                        <img src="./img/logo negro.jpg" alt="4BS logotipo negro" class="logo">
                    </a>
                </div>
                <div>
                    <h2>Dirección:</h2>
                    <p>C/ Rivalamora Nº 12</p>
                    <p>09002, Burgos</p>
                </div>
                <div>
                    <h2>Contacto:</h2> 
                    <p>Email: contacto4bs@gmail.com</p>
                    <p>Tel: +34 653 11 65 04</p>
                </div>
            </div>
            <div>
                <p class="copy">Copyright &copy; 2025 Piso Turístico en Burgos</p>
            </div>
        </footer>
        <script src="script-fotos.js?v=<?php echo time(); ?>"></script>
        <script src="script-valoraciones.js?v=<?php echo time(); ?>"></script>
    </body>
</html>