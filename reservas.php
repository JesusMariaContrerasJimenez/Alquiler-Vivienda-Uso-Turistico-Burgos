<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta 
            name="Alquiler Burgos"
            content="Alquiler piso turistico burgos" />
        <meta name="Reservas 4BS" content="Esta es la página principal de reservas de 4BS">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>4B'S piso turístico Burgos</title>
        <link rel="icon" href="./img/favicon.jpg" type="image/x-icon"/>
        <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/fullcalendar.min.css" rel="stylesheet">
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
                        <li class="active"><a href="reservas.php">Reservas</a></li>
                        <li><a href="valoraciones.php">Valoraciones</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <section>
                <div id="calendario" style="margin-bottom: 30px;"></div>
            </section>

            <section class="contenedor-columnas">
                <!-- Columna 1: Hacer reserva -->
                <div class="columna">
                    <h2>Hacer una reserva</h2>
                    <form id="form-reserva">
                        <label for="fecha-inicio">Fecha de entrada:</label>
                        <input type="date" id="fecha-inicio" name="fecha-inicio" required>

                        <label for="fecha-salida">Fecha de salida:</label>
                        <input type="date" id="fecha-salida" name="fecha-salida" required>

                        <label for="personas">Número de huéspedes:</label>
                        <select id="personas" name="personas">
                            <option value="1">1 persona</option>
                            <option value="2">2 personas</option>
                            <option value="3">3 personas</option>
                            <option value="4">4 personas</option>
                            <option value="5">5 personas</option>
                        </select>

                        <button class="boton-consultar" type="submit">Consultar precios</button>
                    </form>
                    <!-- Donde se muestra el resultado -->
                    <div id="resultado-precio"></div>
                    
                    <div id="formulario-reserva" style="display: none;">
                        <h3>Complete su reserva</h3>
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
                            <input type="number" id="numPersonas" readonly>

                            <label for="necesitaCuna">¿Necesita cuna?</label>
                            <select id="necesitaCuna">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>

                            <label for="opcionSeleccionada">Opción seleccionada:</label>
                            <input type="text" id="opcionSeleccionada" readonly>

                            <label for="fechaEntrada">Fecha de entrada:</label>
                            <input type="date" id="fechaEntrada" readonly>

                            <label for="fechaSalida">Fecha de salida:</label>
                            <input type="date" id="fechaSalida" readonly>

                            <label for="precioTotal">Precio total:</label>
                            <input type="number" id="precioTotal" readonly>

                            <button type="submit" id="confirmar-reserva">Confirmar Reserva</button>
                        </form>
                    </div>
                    <p>La reserva se formalizará mediante transferencia bancaria o bizum. </p>
                    <p>En el email de confirmación recibirás los datos para el pago de la estancia.</p>
                </div>

                <!-- Columna 2: Cancelar reserva -->
                <div class="columna">
                    <h2>Cancelar reserva</h2>
                    <form id="form-cancelar">
                        <label for="idCancelar">ID de reserva:</label>
                        <input type="text" id="idCancelar" name="idCancelar" required>

                        <label for="dniCancelar">DNI:</label>
                        <input type="text" id="dniCancelar" name="dniCancelar" required>

                        <button type="submit" id="cancelar-reserva">Cancelar reserva</button>
                    </form>
                    <p>Se abonará el 100% si cancelas antes de 7 días y el 40% si cancelas después.</p>
                    <div id="respuesta-cancelacion"></div>
                </div>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        
        <script src="script-reservas.js?v=<?php echo time(); ?>"></script>
        <script src="cancelar-reserva.js?v=<?php echo time(); ?>"></script>
    </body>
</html>