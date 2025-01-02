<?php
include '../BACKEND/utility.php';

session_start();
$conn = dbConnect();
if (!isset($_SESSION['cart']) && isset($_SESSION['username'])) {

    loadCart($conn, 'load');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>SLUKE</title>
    <meta charset="utf-8">
    <link rel="icon" type="image" href="../IMG/logo transparent0000.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body class="bg-dark text-light  mt-5 pt-4">
    <!-- Spinner Overlay -->
    <div id="spinner-overlay" class="d-flex d-none justify-content-center align-items-center position-fixed w-100 h-100 bg-dark bg-opacity-75" style="top: 0; left: 0;z-index: 2000;">
        <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-primary bg-light fixed-top">
        <div class="container-fluid justify-content-center">
            <a class="navbar-brand" href="#home">
                <img src="../IMG/LOGO_NEW-crop.png" alt="" height="20">
            </a>
            <button class="navbar-toggler bg-light border-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse flex-grow-0 navbar-collapse col-lg-10" id="navbarSupportedContent">
                <ul class="navbar-nav text-center me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-primary" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="#portfolio">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="./products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="#social">Contacts</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto text-center">
                    <?php
                    switch (true) {
                        case isset($_SESSION['admin']):
                            echo '
                            
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-primary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dashboards
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"> <a class="nav-link text-primary" href="./productdashboard.php"> Product Dashboard
                                </a>
                            </li>
                                <li class="nav-item"> <a class="nav-link text-primary" href="./admindashboard.php"> Admin Dashboard
                                </a>
                            </li>
                            </ul>
                            </li>
                            
                            ';


                        case isset($_SESSION['username']):
                            echo '<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle text-primary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person"></i>
                            ' . $_SESSION['username'] . '
                                        </a>
                                         <ul class="dropdown-menu">
                                    </li>
                                    <li class="nav-item"><a class="nav-link text-primary" href="./fdl.php">Free Downloads!</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link text-primary" href="./login.php">Log out</a>
                                    </li>
                                    </ul>
                                    </li>
                                    <li class="nav-item"> 
                                        <button class="btn btn-outline-primary mx-1 d-none d-md-block" type="button" data-bs-toggle="offcanvas" data-bs-target="#cart" aria-controls="offcanvasScrolling">Cart <i class="bi bi-cart-dash"></i></button>
                                    </li>
                                    </ul>
                                </div>
                                <button class="btn btn-outline-primary mx-3 d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#cart" aria-controls="offcanvasScrolling">Cart <i class="bi bi-cart-dash"></i></button>
                                    
                                    ';
                            break;

                        default:
                            echo '
                            
                                <li class="nav-item"> <a class="nav-link text-primary" href="./login.php">
                                        Log in
                                    </a>
                                </li>
                                <li class="nav-item"><a class="nav-link text-primary" href="./register.php">Register</a>
                                </li>
                                </ul>
                                </div>';
                            break;
                    }

                    ?>

    </nav>
    <div class="offcanvas offcanvas-end " data-bs-scroll="true" tabindex="-1" id="cart" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Shopping Cart <i class="bi bi-cart-dash"></i></h5>
            <button type="button" class="btn-close" style="color: var(--bs-light);" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <?php
            displayCart();
            ?>
        </div>
    </div>


    <section id="home">
        <div class="container-fluid">
            <!-- Carousel -->
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../IMG/pexels-ann-h-45017-2573957.jpg" class="d-block w-100 img-fluid" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="../IMG/pexels-david-bartus-43782-690779.jpg" class="d-block w-100 img-fluid" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="../IMG/pexels-dmitry-demidov-515774-3783471.jpg" class="d-block w-100 img-fluid" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>



        </div>

    </section>

    <svg class="hero-waves " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
        <defs>
            <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
        </defs>
        <g class="wave1">
            <use xlink:href="#wave-path" x="50" y="3"></use>
        </g>
        <g class="wave2">
            <use xlink:href="#wave-path" x="50" y="0"></use>
        </g>
        <g class="wave3">
            <use xlink:href="#wave-path" x="50" y="9"></use>
        </g>
    </svg>

    <section id="aboutus">
        <div class="container mt-5">
            <h1>About us</h1>
            <p>Qualcosa di interessante!</p>
        </div>
    </section>


    <section id="portfolio">
        <div class="container mt-5">
            <h1>Portfolio</h1>
            <div class="row mt-2">
                <h3 class="my-4">Remixes</h3>
                <iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/1937779388&color=%23e9363d&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>
                <div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/slukemusicc" title="Sluke" target="_blank" style="color: #cccccc; text-decoration: none;">Sluke</a> · <a href="https://soundcloud.com/slukemusicc/1momento-sluke-remix" title="1MOMENTO (SLUKE REMIX) [FREE DL]" target="_blank" style="color: #cccccc; text-decoration: none;">1MOMENTO (SLUKE REMIX) [FREE DL]</a></div>
            </div>
            <div class="row my-4">
                <div class="col-lg-6">
                    <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/1922693060&color=%23e9363d&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
                    <div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/slukemusicc" title="Sluke" target="_blank" style="color: #cccccc; text-decoration: none;">Sluke</a> · <a href="https://soundcloud.com/slukemusicc/italian-club-weapons-pack-vol1" title="ITALIAN CLUB WEAPONS REMIX PACK VOL.1 [FREE DL] (alcune tracce modificate per copy)" target="_blank" style="color: #cccccc; text-decoration: none;">ITALIAN CLUB WEAPONS REMIX PACK VOL.1 [FREE DL] (alcune tracce modificate per copy)</a></div>
                </div>
                <div class="col-lg-6">
                    <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/1845590025&color=%23e9363d&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
                    <div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/slukemusicc" title="Sluke" target="_blank" style="color: #cccccc; text-decoration: none;">Sluke</a> · <a href="https://soundcloud.com/slukemusicc/sesso-e-baile" title="SESSO E SAMBA (SLUKE FLIP) [FREE DL] *filtrato per copyright*" target="_blank" style="color: #cccccc; text-decoration: none;">SESSO E SAMBA (SLUKE FLIP) [FREE DL] *filtrato per copyright*</a></div>
                </div>
            </div>


            <div class="row mb-2 ">
                <h3 class="my-4">Songs and productions</h3>
                <iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/7ysK5BELfwpjusuUT1QYpw?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
            </div>
            <div class="row my-4">
                <div class="col-lg-6">
                    <iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/1oSxktMK4ESQMlCm4FazEM?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
                </div>
                <div class="col-lg-6">
                    <iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/7ik8zyFSiEPjdl296iu9yD?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>






    <section id="" class="">

        <!-- Section Title -->
        <div class="container p-3" data-aos="fade-up">
            <h1>qualcosa di interessante</h1>
        </div><!-- End Section Title -->

        <div class="container">
            <p>Aggiungi contenuto qui!</p>
        </div>

    </section><!-- /Pricing Section -->

    <footer id="social" class="footer bg-secondary mt-5 ">
        <div class="container p-3">
            <h3 class="text-primary fw-bold fs-1">Sluke</h3>
            <h5 class="my-3">Follow me on my socials to never miss any content!</h5>
            <p class="my-3 fs-5 "><i class="bi bi-envelope-at-fill text-primary"></i> :musicbysluke@gmail.com</p>
            <div class="social-links d-flex justify-content-around">
                <a href="https://www.youtube.com/@sluke1547" target="_blank" rel="noopener noreferrer">
                    <h1><i class="bi bi-youtube c"></i></h1>
                </a>
                <a href="https://open.spotify.com/intl-it/artist/4zTNDtXBjnewJ2qIWvdwEe?si=2f29d7a2c37d4520" target="_blank" rel="noopener noreferrer">
                    <h1><i class="bi bi-spotify"></i></h1>
                </a>
                <a href="https://www.instagram.com/musicbysluke" target="_blank" rel="noopener noreferrer">
                    <h1><i class="bi bi-instagram"></i></h1>
                </a>
                <a href="https://www.tiktok.com/@musicbysluke" target="_blank" rel="noopener noreferrer">
                    <h1><i class="bi bi-tiktok"></i></h1>
                </a>
                <a href="https://soundcloud.com/slukemusicc" target="_blank" rel="noopener noreferrer">
                    <h1> <img class="text-primary" src="../IMG/419675-sc-logo-cloud-black (1)-853a4f-original-1645807039.png" alt=""> </h1>
                </a>
            </div>

        </div>
    </footer>
    <script>
        // Mostra lo spinner al caricamento e lo nasconde alla fine
        function showSpinner() {
            document.getElementById('spinner-overlay').style.display = 'flex';
        }

        function hideSpinner() {
            document.getElementById('spinner-overlay').style.display = 'none';
        }

        function addTocart(id, action) {
            showSpinner();

            console.log("Sending data:", {

                id,
                action
            }); // Log per debug

            fetch('../BACKEND/cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id,
                        action
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Response:", data); // Log per debug
                    if (data.success) {
                        hideSpinner();
                        alert("Operation completed", "success");
                        location.reload();

                    } else {
                        hideSpinner();
                        alert("Error: " + data.message, "danger");
                    }
                })
                .catch(error => {
                    hideSpinner();
                    console.error('Fetch error:', error);
                    alert("Errore nella risposta del server: " + error.message);
                });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>