<?php
$videoBase64 = null;

$conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el último archivo de la tabla
$resultado = $conexion->query("SELECT nombre, tipo, contenido FROM archivos ORDER BY id DESC LIMIT 1");
if ($resultado->num_rows > 0) {
    $archivo = $resultado->fetch_assoc();
    // Guardar temporalmente el contenido para incrustarlo
    $archivoPDF = "data:" . $archivo['tipo'] . ";base64," . base64_encode($archivo['contenido']);
} else {
    $mensaje = "No hay archivos disponibles.";
}

// Obtener el último video
$resultado = $conexion->query("SELECT tipo, contenido FROM videos ORDER BY id DESC LIMIT 1");
if ($resultado->num_rows > 0) {
    $video = $resultado->fetch_assoc();
    $videoBase64 = "data:" . $video['tipo'] . ";base64," . base64_encode($video['contenido']);
} else {
    $mensaje = "No hay videos disponibles.";
}

// Obtener el último subtítulo
$result = $conexion->query("SELECT * FROM subtitles ORDER BY fecha_subida DESC LIMIT 1");
$subtitulo = $result->fetch_assoc();

// Obtener imágenes
$resultado = $conexion->query("SELECT tipo, contenido FROM imagenes");
$imagenes = $resultado->fetch_all(MYSQLI_ASSOC);

// Obtener audios
$audios = [];
try {
    $conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    $query = "SELECT id, audio_name, audio_data FROM audios ORDER BY id ASC LIMIT 3";
    $resultado = $conexion->query($query);

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $audios[] = $fila;
        }
        $resultado->free();
    }

} catch (Exception $e) {
    echo "<script>alert('Error al cargar los audios: " . $e->getMessage() . "');</script>";
}

$conexion->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars Website :D</title>

    <!-- Swiper JS CDN Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <!--Font Awesome CDN Link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />

    <!--Custom CSS File Link-->
    <link rel="stylesheet" href="style.css">

    <!-- Todo el tema de las figuras -->
    <link rel="stylesheet" href="owl.carousel.min.css">
    <link rel="stylesheet" href="owl.theme.default.min.css">

    <link rel="stylesheet" href="animaciones/anprueba.css">
    <link rel="stylesheet" href="animaciones/ts1.css">
    <link rel="stylesheet" href="animaciones/ts2.css">
    <link rel="stylesheet" href="animaciones/para.css">
    <link rel="stylesheet" href="animaciones/tm.css">
    <link rel="stylesheet" href="animaciones/tb1.css">
    <link rel="stylesheet" href="animaciones/tb2.css">
    <link rel="stylesheet" href="animaciones/cube.css">

    <style>
        .owl-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .item {
            color: aliceblue;
            justify-content: center;
            display: flex;
            height: 600px;
        }
    </style>

</head>

<body>

    <!-- Header Section Starts -->

    <header class="header">

        <div id="menu-btn" class="fas fa-bars"></div>

        <a href="#" class="logo"><span>carbon</span>works</a>

        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#vehicles">vehicles</a>
            <a href="#services">services</a>
            <a href="#featured">featured</a>
            <a href="#reviews">reviews</a>
            <a href="#contact">contact</a>
            <a href="wysiwyg.php">Editor</a>


        </nav>

        <div id="login-btn">
            <a href="login.php">
                <button class="btn">login</button>
            </a>
            <i class="far fa-user"></i>
        </div>

    </header>

    <!-- Header Section Ends -->

    <!-- Login Form Starts -->

    <!-- <div class="login-form-container">

        <span class="fas fa-times" id="close-login-form"></span>

        <form action="">
            <h3>user login</h3>
            <input type="email" placeholder="email" class="box">
            <input type="password" placeholder="password" class="box">
            <p>forgot your password <a href="#">click here</a></p>
            <input type="submit" value="login now" class="btn">
            <p>or login with</p>
            <div class="buttons">
                <a href="#" class="btn">google</a>
                <a href="#" class="btn">facebook</a>
            </div>
            <p>don't have an account <a href="#">create one</a></p>
        </form>

    </div> -->

    <!-- Login Form Ends -->

    <!-- Home Section Starts -->

    <section class="home" id="home">
        <div class="home-content">
            <h1 class="home-parallax" data-speed="-2">find your car</h1>
            <img class="home-parallax" data-speed="5" src="image/home-img(1).png" alt="">
            <a href="#" class="btn home-parallax" data-speed="7"> explore cars </a>
        </div>
    </section>

    <!-- Home Section Ends -->

    <br><br><br><br><br>


    <section class="figures">
        <iframe src="tangram/index.html" style="width: 100%; height: 600px; border: none; overflow: hidden;">
        </iframe>
    </section>


    <!-- Reproductor de Audio -->
    <section class="audio-player" style="padding: 2rem; text-align: center;">
        <h2 class="heading">Reproductor de <span>Audio</span></h2>
        
        <div style="max-width: 600px; margin: 0 auto;">
            <?php foreach ($audios as $index => $audio): ?>
                <audio id="audio<?= $index ?>" style="display: none;">
                    <source src="data:audio/mpeg;base64,<?= base64_encode($audio['audio_data']) ?>" type="audio/mpeg">
                    Tu navegador no soporta el elemento de audio.
                </audio>
            <?php endforeach; ?>
            
            <div style="margin: 20px 0;">
                <button id="playAllBtn" class="btn" onclick="togglePlayback()">
                    <i class="fas fa-play"></i> Reproducir
                </button>
            </div>
            
            <div id="nowPlaying" style="margin-top: 10px; color: var(--secondary);">
                <!-- El nombre del audio actual se mostrará aquí -->
            </div>
        </div>
    </section>

    <script>
    let audioElements = [];
    let currentAudioIndex = 0;
    let isPlaying = false;

    document.addEventListener('DOMContentLoaded', function() {
        // Obtener todos los elementos de audio
        audioElements = [
            document.getElementById('audio0'),
            document.getElementById('audio1'),
            document.getElementById('audio2')
        ];

        // Agregar event listeners para cuando termine cada audio
        audioElements.forEach((audio, index) => {
            audio.addEventListener('ended', () => {
                playNextAudio();
            });
        });
    });

    function togglePlayback() {
        const playBtn = document.getElementById('playAllBtn');
        const nowPlaying = document.getElementById('nowPlaying');
        
        if (!isPlaying) {
            // Comenzar reproducción
            isPlaying = true;
            playBtn.innerHTML = '<i class="fas fa-stop"></i> Detener';
            playAudio(currentAudioIndex);
        } else {
            // Detener reproducción
            isPlaying = false;
            playBtn.innerHTML = '<i class="fas fa-play"></i> Reproducir';
            stopAllAudios();
            nowPlaying.textContent = '';
        }
    }

    function playAudio(index) {
        if (!isPlaying) return;
        
        stopAllAudios();
        
        const audio = audioElements[index];
        const nowPlaying = document.getElementById('nowPlaying');
        
        if (audio) {
            audio.play();
            // Mostrar el nombre del audio actual
            const audioNames = <?= json_encode(array_column($audios, 'audio_name')) ?>;
            nowPlaying.textContent = `Reproduciendo: ${audioNames[index]}`;
        }
    }

    function playNextAudio() {
        if (!isPlaying) return;
        
        currentAudioIndex = (currentAudioIndex + 1) % audioElements.length;
        playAudio(currentAudioIndex);
    }

    function stopAllAudios() {
        audioElements.forEach(audio => {
            audio.pause();
            audio.currentTime = 0;
        });
    }
    </script>

    <!-- Relleno -->

    <br><br><br><br>

    <!-- Visualizador de Video -->
    <section class="videito">
        <?php if ($videoBase64): ?>
            <!-- Contenedor centrado para el video -->
            <div style="display: flex; align-items: center; justify-content: center; height: 100vh;">
                <video controls width="600" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                    <source src="<?= $videoBase64 ?>" type="<?= $video['tipo'] ?>">

                    <?php if ($subtitulo): ?>
                        <!-- Subtítulo dinámico -->
                        <track src="data:<?= $subtitulo['tipo'] ?>;base64,<?= base64_encode($subtitulo['contenido']) ?>"
                            kind="subtitles" srclang="es" label="Español">
                    <?php endif; ?>

                    Tu navegador no soporta la reproducción de videos.
                </video>
            </div>
        <?php else: ?>
            <!-- Mensaje si no hay videos -->
            <div style="display: flex; align-items: center; justify-content: center; height: 50vh;">
                <p><?= htmlspecialchars($mensaje) ?></p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Vehicles Section Starts -->

    <section class="vehicles" id="vehicles">
        <h1 class="heading">popular <span>vehicles</span></h1>
        <div class="swiper vehicles-slider">
            <div class="swiper-wrapper">
                <?php foreach ($imagenes as $imagen): ?>
                    <div class="swiper-slide box">
                        <img src="data:<?= $imagen['tipo'] ?>;base64,<?= base64_encode($imagen['contenido']) ?>"
                            alt="Vehicle Image">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Vehicles Section Ends -->

    <section class="icons-container">

        <div class="icons">
            <i class="fas fa-home"></i>
            <div class="content">
                <h3>150+</h3>
                <p>branches</p>
            </div>
        </div>

        <div class="icons">
            <i class="fas fa-car"></i>
            <div class="content">
                <h3>4770+</h3>
                <p>cars sold</p>
            </div>
        </div>

        <div class="icons">
            <i class="fas fa-users"></i>
            <div class="content">
                <h3>590+</h3>
                <p>happy clients</p>
            </div>
        </div>

        <div class="icons">
            <i class="fas fa-car"></i>
            <div class="content">
                <h3>890+</h3>
                <p>new cars</p>
            </div>
        </div>

    </section>

    <!-- Icon Section Ends -->


    <!-- Services Section Starts -->

    <section class="services" id="services">

        <h1 class="heading"> our <span>services</span> </h1>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-car"></i>
                <h3>car selling</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                <a href="#" class="btn">read more</a>
            </div>

            <div class="box">
                <i class="fas fa-tools"></i>
                <h3>replacement parts</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                <a href="#" class="btn">read more</a>
            </div>

            <div class="box">
                <i class="fas fa-car-crash"></i>
                <h3>car insurance</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                <a href="#" class="btn">read more</a>
            </div>

            <div class="box">
                <i class="fas fa-car-battery"></i>
                <h3>battery replacement</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                <a href="#" class="btn">read more</a>
            </div>

            <div class="box">
                <i class="fas fa-gas-pump"></i>
                <h3>oil change</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                <a href="#" class="btn">read more</a>
            </div>

            <div class="box">
                <i class="fas fa-headset"></i>
                <h3>24/7 support</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                <a href="#" class="btn">read more</a>
            </div>

        </div>

    </section>

    <!-- Services Section Ends -->

    <!-- Featured Section Starts -->

    <section class="featured" id="featured">

        <h1 class="heading"> <span>featured</span> cars </h1>

        <div class="swiper featured-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide box">
                    <img src="image/car-1.png" alt="">
                    <h3>2015 Mercedes-Benz AMG GT</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="price">$92,500/-</div>
                    <a href="#" class="btn">check out</a>
                </div>

                <div class="swiper-slide box">
                    <img src="image/car-2.png" alt="">
                    <h3>2017 Nissan GT-R (R35)</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">$152,000/-</div>
                    <a href="#" class="btn">check out</a>
                </div>

                <div class="swiper-slide box">
                    <img src="image/car-3.png" alt="">
                    <h3>2023 Ford Mustang</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">$27,770/-</div>
                    <a href="#" class="btn">check out</a>
                </div>

                <div class="swiper-slide box">
                    <img src="image/car-4.png" alt="">
                    <h3>2017 Audi R8</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">$165,450/-</div>
                    <a href="#" class="btn">check out</a>
                </div>

                <div class="swiper-slide box">
                    <img src="image/car-5.png" alt="">
                    <h3>2018 Mini Cooper</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">$22,500/-</div>
                    <a href="#" class="btn">check out</a>
                </div>

                <div class="swiper-slide box">
                    <img src="image/car-6.png" alt="">
                    <h3>2022 Honda Civic Type R</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="price">$40,000/-</div>
                    <a href="#" class="btn">check out</a>
                </div>

                <div class="swiper-slide box">
                    <img src="image/car-7.png" alt="">
                    <h3>2020 Alfa Romeo 4C</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="price">$58,859/-</div>
                    <a href="#" class="btn">check out</a>
                </div>

                <div class="swiper-slide box">
                    <img src="image/car-8.png" alt="">
                    <h3>Koenigsegg Agera R</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">$1,500,000/-</div>
                    <a href="#" class="btn">check out</a>
                </div>

            </div>

            <div class="swiper-pagination"></div>

        </div>

    </section>

    <!-- Featured Section Ends -->

    <!-- Newsletter Section Starts -->

    <section class="newsletter">

        <h3>subscribe for latest updates</h3>

        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, impedit.</p>

        <form action="">
            <input type="email" placeholder="enter your email" name="" id="">
            <input type="submit" class="subscribe" name="" id="">
        </form>

    </section>

    <!-- Newsletter Section Ends -->

    <!-- Review Section Starts -->

    <section class="reviews" id="reviews">

        <h1 class="heading"> clients <span>review</span> </h1>

        <div class="swiper reviews-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide box">
                    <img src="image/pic-1.png" alt="">
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem a aut amet placeat
                            dignissimos accusantium sunt, delectus nemo omnis earum.</p>
                        <h3>john doe</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/pic-2.png" alt="">
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem a aut amet placeat
                            dignissimos accusantium sunt, delectus nemo omnis earum.</p>
                        <h3>john doe</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/pic-3.png" alt="">
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem a aut amet placeat
                            dignissimos accusantium sunt, delectus nemo omnis earum.</p>
                        <h3>john doe</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/pic-4.png" alt="">
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem a aut amet placeat
                            dignissimos accusantium sunt, delectus nemo omnis earum.</p>
                        <h3>john doe</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/pic-5.png" alt="">
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem a aut amet placeat
                            dignissimos accusantium sunt, delectus nemo omnis earum.</p>
                        <h3>john doe</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/pic-6.png" alt="">
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem a aut amet placeat
                            dignissimos accusantium sunt, delectus nemo omnis earum.</p>
                        <h3>john doe</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>


            </div>

            <div class="swiper-pagination"></div>

        </div>

    </section>

    <!-- Review Section Ends -->

    <!-- Contact Section Starts -->

    <section class="contact" id="contact">

        <h1 class="heading"> <span>contact</span> us </h1>

        <div class="row">

            <iframe class="map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15693.010868316294!2d-66.87096271574549!3d10.480733330121597!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8c2a58f742aa7689%3A0xf692e56bb1ff6749!2sLas%20Mercedes%2C%20Caracas%2C%20Miranda!5e0!3m2!1sen!2sve!4v1677878787573!5m2!1sen!2sve"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            <form action="">
                <h3>get in touch</h3>
                <input type="text" placeholder="name" class="box">
                <input type="email" placeholder="email" class="box">
                <input type="number" placeholder="number" class="box">
                <textarea placeholder="message" class="box" cols="30" rows="10"></textarea>
                <input type="submit" value="send message" class="btn">
            </form>

        </div>

    </section>

    <!-- Footer Section Starts -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>our branches</h3>
                <a href="#"> <i class="fas fa-map-marker-alt"></i> miami </a>
                <a href="#"> <i class="fas fa-map-marker-alt"></i> doral </a>
                <a href="#"> <i class="fas fa-map-marker-alt"></i> caracas </a>
                <a href="#"> <i class="fas fa-map-marker-alt"></i> valencia </a>
                <a href="#"> <i class="fas fa-map-marker-alt"></i> barquisimeto </a>
            </div>

            <div class="box">
                <h3>quick links</h3>
                <a href="#home"> <i class="fas fa-arrow-right"></i> home </a>
                <a href="#vehicles"> <i class="fas fa-arrow-right"></i> vehicles </a>
                <a href="#services"> <i class="fas fa-arrow-right"></i> services </a>
                <a href="#featured"> <i class="fas fa-arrow-right"></i> featured </a>
                <a href="#review"> <i class="fas fa-arrow-right"></i> review </a>
                <a href="#contact"> <i class="fas fa-arrow-right"></i> contact </a>
            </div>

            <div class="box">
                <h3>quick links</h3>
                <a href="#"> <i class="fas fa-phone"></i> +123-456-7890 </a>
                <a href="#"> <i class="fas fa-phone"></i> +111-222-3333 </a>
                <a href="#"> <i class="fas fa-envelope"></i> contacto.elsirguti@gmail.com </a>
                <a href="#"> <i class="fas fa-map-marker-alt"></i> caracas, venezuela - 1060 </a>
                <a href="mostrar.php"> <i class="fas fa-arrow-right"></i> Terminos de Uso </a>
            </div>

            <div class="box">
                <h3>quick links</h3>
                <a href="https://www.youtube.com/channel/UCRxVmCtUTf4w0wqotGokekQ" target="_blank"> <i
                        class="fab fa-youtube"></i> youtube </a>
                <a href="https://twitter.com/ElSirGuti" target="_blank"> <i class="fab fa-twitter"></i> twitter </a>
                <a href="https://www.instagram.com/elsirguti/?hl=es-la" target="_blank"> <i
                        class="fab fa-instagram"></i> instagram </a>
                <a href="https://www.linkedin.com/in/andres-gutierrez-tovar-2aa665216/" target="_blank"> <i
                        class="fab fa-linkedin"></i> linkedin </a>
                <a href="https://github.com/ElSirGuti/" target="_blank"> <i class="fab fa-github"></i> github </a>
            </div>

        </div>

        <div class="credit"> Creado por Andres Gutierrez y Jose Ramirez | all rights reserved! </div>

    </section>

    <!-- Footer Section Ends -->


    <script src="jquery.min.js"></script>
    <script src="owl.carousel.min.js"></script>
    <script src="main.js"></script>





    <!-- Script to update colors on all pages -->
    <script>
        // Función para actualizar los colores desde localStorage
        function updateColorsOnAllPages() {
            const root = document.documentElement;
            const primaryColor = localStorage.getItem('primaryColor');
            const secondaryColor = localStorage.getItem('secondaryColor');
            const tertiaryColor = localStorage.getItem('tertiaryColor');
            const cuaternaryColor = localStorage.getItem('cuaternaryColor');
            const backgroundColor = localStorage.getItem('backgroundColor');

            if (primaryColor) {
                root.style.setProperty('--primary', primaryColor);
            }

            if (secondaryColor) {
                root.style.setProperty('--secondary', secondaryColor);
            }

            if (tertiaryColor) {
                root.style.setProperty('--tertiary', tertiaryColor);
            }

            if (cuaternaryColor) {
                root.style.setProperty('--cuaternary', cuaternaryColor);
            }

            if (backgroundColor) {
                root.style.setProperty('--background', backgroundColor);
                document.body.style.backgroundColor = backgroundColor;
            }
        }

        // Cargar los colores cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', updateColorsOnAllPages);

        // También actualizar los colores inmediatamente
        updateColorsOnAllPages();
    </script>

    <!-- Script to handle font changes -->
    <script src="font-changer.js"></script>

    <!-- Contact Section Ends -->

    <!-- Swiper JS CDN Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!--Custom JS Script-->
    <script src="script.js"></script>
</body>

</html>