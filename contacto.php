<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta 
            name="Alquiler Burgos"
            content="Alquiler piso turistico burgos" />
        <meta name="Contacto 4BS" content="Esta es la página principal de contacto de 4BS">
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
                        <li><a href="valoraciones.php">Valoraciones</a></li>
                        <li class="active"><a href="contacto.php">Contacto</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <section id="contacto-directo">
                <h2>Contacto directo</h2>
                
                <div class="contenedor-contacto">
                    <div class="icono-texto-contacto">
                        <a href="tel:+34653116504">
                            <i class="fa-solid fa-phone"></i>
                        </a>
                        <a href="tel:+34653116504">
                            <span>+34 653 11 65 04</span>
                        </a> 
                    </div>
                    <div class="icono-texto-contacto">
                        <a href="https://wa.me/34653116504">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="https://wa.me/34653116504">
                            <span>+34 653 11 65 04</span>
                        </a>  
                    </div>
                    <div class="icono-texto-contacto">
                        <a href="mailto:contacto4bs@gmail.com">
                            <i class="fa-solid fa-at"></i>
                        </a>
                        <a href="mailto:contacto4bs@gmail.com">
                            <span>contacto4bs@gmail.com</span>
                        </a>
                    </div>
                </div>
                
            </section>
            <section id="formulario-contacto">
                <h2>Envíanos un mensaje</h2>
                <form id="contact-form">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" required></textarea>

                    <button type="submit">Enviar Mensaje</button>
                </form>
            </section>
            <div id="mensaje-enviado" style="display: none; padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem; text-align: center;">✅ ¡Mensaje enviado correctamente!</div>
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
        <script src="script-contacto?v=<?php echo time(); ?>.js"></script>
    </body>
</html>