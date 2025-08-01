<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta 
            name="4BS Alquiler Burgos"
            content="$BS Alquiler piso turistico burgos" />
        <meta name="4BS Alquiler piso turistico burgos" content="Esta es la página principal de inicio de 4BS">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="google-site-verification" content="bXKL4uJV6lwqFk8omVe1CM6fNKQPt67tCyK6qFiSMn4" />
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
        <div id="google_translate_element" style="display: none;"></div>
        <!--Header -->
        <header>
            <div class="header">
                <a href="index.php">
                    <img src="./img/logo blanco.jpg" alt="4BS logotipo" class="logo">
                </a>
                <nav>
                    <ul class="ul-nav">
                        <li class="active"><a href="index.php">Inicio</a></li>
                        <li><a href="gal.php">Galeria</a></li>
                        <li><a href="reservas.php">Reservas</a></li>
                        <li><a href="valoraciones.php">Valoraciones</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                    </ul>
                </nav>
        </header>

        <!-- Cabecera catedral -->
        <section class="catedral">
            <div class="overlay">
                <p class="conoce">Conoce Burgos</p>
                <p class="titulo-4BS">4B'S: B&B Burgos Bulevar</p>
            </div>
            <img src="./img/catedral.jpg" alt="Catedral de Burgos" class="imagen-fondo">
        </section>
        
        <!-- Descripción del piso -->
         <section id="descripcion">
            <div class="slider-container">
                <button class="boton-slider boton-izquierda" onclick="cambiarImagen(-1)">❮</button>
                <img class="slider-img" id="imagen-principal" src="./img/1-Captura portada.png" alt="Portada">
                <button class="boton-slider boton-derecha" onclick="cambiarImagen(1)">❯</button>
            </div>
            <div class="imagenes">
                <img src="./img/1-Captura portada.png" alt="Portada">
                <div>
                    <img class="img-ancho" src="./img/2-COMEDOR SALON.jpg" alt="Comedor">
                    <img class="img-ancho" src="./img/3-SALON COMEDOR.jpg" alt="Salón">
                </div>
                <div>
                    <img class="img-ancho" src="./img/4-DORMITORIO DOBLE VISTA 1.jpg" alt="Dormitorio doble vista 1">
                    <img class="img-ancho" src="./img/4-DORMITORIO DOBLE VISTA2.jpg" alt="Dormitorio doble vista 2">
                </div>
                <div>
                    <img class="img-ancho" src="./img/5-DORMITORIO INDIVIDUAL vista1.jpg" alt="Dormitorio individual vista 1">
                    <img class="img-ancho" src="./img/5-DORMITORIO INDIVIDUAL vista 2.jpg" alt="Dormitorio individual vista 2">
                </div>
                <div>
                    <img class="img-ancho" src="./img/7-COCINA vista1.jpg" alt="Cocina vista 1">
                    <img class="img-ancho" src="./img/7-COCINA vista2.jpg" alt="Cocina vista 2">
                </div>
                <div>
                    <img class="img-ancho" src="./img/8-BAÑO vista1.jpg" alt="Baño vista 1">
                    <img class="img-ancho" src="./img/8-BAÑO vista2.jpg" alt="Baño vista 2">
                </div>
                <div>
                    <img class="img-ancho" src="./img/9-ASEO vista1.jpg" alt="Aseo vista 1">
                    <img class="img-ancho" src="./img/9-ASEO vista2.jpg" alt="Aseo vista 2">
                </div>
                <div>
                    <img class="img-ancho" src="./img/11-fachada principal.jpg" alt="Fachada">
                    <img class="img-ancho" src="./img/11-Vista posterior edificio.jpg" alt="Parque">
                </div>
                <div>
                    <img class="img-ancho" src="./img/10-TERRAZA TENDEDERO.jpg" alt="Terraza">
                    <img class="img-ancho" src="./img/12-Garaje.jpg" alt="Garaje">
                </div>
            </div>

            <div class="texto">
                <h1>Piso de uso turístico 4B'S</h1>
                <p>Desde 80€ / noche</p>
                <img src="./img/5-estrellas.jpg" alt="Reseña de cinco estrellas" style="width: 80px;">
                <hr class="linea">
                    
                <h2>Información general</h2>
                <p>Vivienda de Uso Turístico con licencia nº 09-217. Se encuentra en pleno Bulevar, una zona muy tranquila, de fácil acceso, llana, sin desniveles y cercana al Centro (18 minutos andando).</p>
                <p>Está totalmente equipada y sus orientaciones Noreste y Sur, proporcionan gran luminosidad y confort a sus 62 m2 útiles.</p>
                <p>Dispone de todos los servicios: wifi 500Mb, smart TV, ascensor, cocina completa, salón con sofá cama, 2 habitaciones, 2 baños y garaje (2 metros de altura máxima de vehículo).</p>     
                <p>Lugares de interés:</p>
                <ul class="ul-list">
                    <li>Catedral de Burgos (1'6 Km)</li>
                    <li>Arco de Santa María (1'5 km)</li>
                    <li>Museo de la Evolución Humana (1'1 km)</li>
                    <li>Paseo del Espolón (1'1 km)</li>
                    <li>Plaza Mayor de Burgos (1 km)</li>
                    <li>Castillo de Burgos (1'8 km)</li>
                </ul>
                <p>Cuenta con otros servicios cercanos, como tiendas, restaurantes y supermercados (el más cercano abre de 9:00 a 21:30 horas incluídos domingos y festivos).</p>
                <hr class="linea">

                <h2>¿Qué incluye?</h2>
                <div class="contenedor-iconos">
                    <div class="icono-texto">
                        <i class="fa-solid fa-house-user"></i>
                        <span>Pisio de 62 m<sup>2</sup></span>
                    </div>
                    <div class="icono-texto">
                        <i class="fa-solid fa-users"></i>
                        <span>1-5 personas</span>
                    </div>
                    <div class="icono-texto">
                        <i class="fa-solid fa-bed"></i>
                        <span>2 habitaciones (una doble y una individual)</span>
                    </div>
                    <div class="icono-texto">
                        <i class="fa-solid fa-bath"></i>
                        <span>2 baños completos</span>
                    </div>
                    <div class="icono-texto">
                        <i class="fa-solid fa-couch"></i>
                        <span>Sofá cama</span>
                    </div>
                    <div class="icono-texto">
                        <i class="fa-solid fa-wifi"></i>
                        <span>Wi-Fi gratuito</span>
                    </div>
                    <div class="icono-texto">
                        <i class="fa-solid fa-tv"></i>
                        <span>Smart TV</span>
                    </div>
                    <div class="icono-texto">
                        <i class="fa-solid fa-square-parking"></i>
                        <span>Garaje</span>
                    </div>
                    <div class="icono-texto">
                        <i class="fa-solid fa-baby"></i>
                        <span>Bebés 0-2 años gratis, disponen de cuna</span>
                    </div>
                    <div class="icono-texto">
                        <i class="fa-solid fa-volume-xmark"></i>
                        <span>Zona tranquila</span>
                    </div>
                    <div class="icono-texto">
                        <i class="fa-solid fa-question"></i>
                        <span>Totalmente equipado</span>
                    </div>
                    <div class="icono-texto">
                        <i class="fa-solid fa-temperature-high"></i>
                        <span>Calefacción</span>
                    </div>
                    </div>
                    <p>Otros aspectos destacables: lo damos todo por su confort, indíquenos su situación particular antes de realizar la reserva, y le enviaremos una oferta personalizada, que se adapte a sus necesidades y preferencias.</p>
                    <hr class="linea">
                        
                    <h2>Políticas de reserva</h2>
                    <div class="contenedor-iconos">
                        <div class="icono-texto">
                            <i class="fa-regular fa-clock"></i>
                            <span>Entrada a partir de las 17:00 horas</span>
                        </div>
                        <div class="icono-texto">
                            <i class="fa-regular fa-clock"></i>
                            <span>Salida hasta las 12:00 horas</span>
                        </div>
                    </div>
                    <p>* Los cambios de entrada y salida están sujetos a disponibilidad.</p>
                    <p>Por nuestra seguridad, habrá un intervalo mínimo de 24 horas, entre reservas.</p>
                    <p>El alquiler será completo con acceso a las habitaciones/camas en función del número de personas.
                        <ul class="ul-list">
                            <li>1 persona (disponible solo de octubre a marzo): sofá cama doble en el salón.
                                    Opcional: añadir habitación con cama individual.</li>
                            <li>2 personas: habitación con cama doble y baño.
                                    Opcional: usar solo sofá cama doble en el salón (incluye descuento) o añadir a la habitación el sofá cama doble en el salón.</li>
                            <li>3 personas: habitación con cama doble y baño junto con habitación cama individual.
                                    Opcional: añadir sofá cama doble en salón.</li>
                            <li>4 personas: habitación con cama doble y baño junto con sofá cama doble en salón.
                                    Opcional: añadir habitación con cama individual.</li>
                            <li>5 personas: todas las camas disponibles.</p></li>
                        </ul>
                    <p>Las reservas se formalizarán mediante transferencia bancaria, la cual se debe emitir en un plazo máximo de 24 horas después de la reserva.</p>
                    <p>No están permitidos huéspedes adicionales sin registrar. Para su registro, se necesita el DNI / PASAPORTE de todos el día anterior a su entrada, para poder firmarlo el día de entrada.</p>
                    <p>Número de registro: VUT-19/217.</p>
                    <p>Política de cancelación: recibe el 100% si cancelas antes de 7 días y un 40% si cancelas después.</p>
                    <div style="text-align: center; margin: 20px;">
                        <a href="reservas.php" class="boton-reserva">Reservar</a>
                    </div>
                    <hr class="linea">
                        
                    <h2>Ubicación</h2>
                        <iframe class="mapa-google" 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2949.197132956632!2d-3.689641224030949!3d42.338320271194895!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd45fccb928c1b6b%3A0x4792c0f007913cef!2sC.%20de%20Rivalamora%2C%2012%2C%2009002%20Burgos!5e0!3m2!1ses!2ses!4v1747730966350!5m2!1ses!2ses" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                </div>
        </section>

        <main>    
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
        <script src="script-slider.js?v=<?php echo time(); ?>"></script>
    </body>
</html>