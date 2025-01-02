<?php
include '../BACKEND/utility.php';
session_start();

session_destroy();

?>
<!DOCTYPE html>
<html>

<head>
    <title>SLUKE login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image" href="../IMG/logo transparent0000.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body class="bg-dark text-light mt-5 pt-5">
    <nav class="navbar navbar-expand-lg navbar-primary bg-light fixed-top">
        <div class="container-fluid justify-content-center">
            <a class="navbar-brand" href="index.php#home">
                <img src="../IMG/LOGO_NEW-crop.png" alt="" height="20">
            </a>
            <button class="navbar-toggler bg-light border-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse flex-grow-0 navbar-collapse col-lg-10" id="navbarSupportedContent">
                <ul class="navbar-nav text-center me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-primary" aria-current="page" href="index.php#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="index.php#portfolio">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="index.php#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="./products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="index.php#social">Contacts</a>
                    </li>

                </ul>
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item"><a class="nav-link text-primary" href="./register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>





    <div class="container">

        <form class="form col-sm-8 col-md-6 col-lg-4 m-auto d-grid" action="" method="post">
            <h1 class="text-center text-light">Log in</h1>
            <div class="mb-3  ">
                <label class="form-label" for="specificSizeInputGroupUsername">Username</label>
                <div class="input-group">
                    <div class="input-group-text">@</div>
                    <input type="text" class="form-control" name="user" id="user" placeholder="Username" required>
                </div>
            </div>
            <div class="mb-3 py-3 ">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="********" required>
            </div>
            <div class="my-2 d-grid">
                <button type="submit" class="btn btn-primary">Log in</button>
            </div>
            <div class=" mt-3 d-grid gap-2">
                <a href="./register.php" type="button" class="btn btn-outline-primary">Register</a>
                <a href="" class="text-primary">Forgot password?</a>

            </div>
            <?php


            // Controllare se il form è stato inviato
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Usare la funzione test_input per pulire i dati
                $username = test_input($_POST['user']);
                $password = trim($_POST['password']);
                // Creare una connessione al database 
                $conn = dbConnect();
                switch (login($conn, $username, $password)) {
                    case 'user':
                        echo '<script>
                        document.getElementById("password").classList.add("is-invalid");
                        </script>';
                        break;

                    case 'pwd':
                        echo '<script>
                        document.getElementById("user").classList.add("is-invalid");
                        </script>';
                        break;
                    case 'unauth':
                        echo '<script>
                        document.getElementById("user").classList.add("is-invalid");
                        console.log("User not authorized by the admin");
                        </script>';
                        break;
                    case 'blk':
                        echo '<script>
                        document.getElementById("user").classList.add("is-invalid");
                        console.log("User blocked");
                        </script>';
                        break;

                    case 'ok':
                        if (isAdmin($username)) {
                            $_SESSION['admin'] = 1;
                            $_SESSION['pwd'] = $password;
                        }

                        header("Location:./index.php");
                        break;

                    default:
                        echo '<script>
                        document.getElementById("user").classList.add("is-invalid");
                        document.getElementById("password").classList.add("is-invalid");
                        </script>';
                        break;
                }
                // Controlla se esiste un URL di reindirizzamento
                if (!empty($_SESSION['redirect_to'])) {
                    $redirect_to = $_SESSION['redirect_to'];
                    unset($_SESSION['redirect_to']); // Pulisce la variabile di sessione

                    header("Location: $redirect_to");
                } else {

                    header("Location: index.php"); // Reindirizza alla home o a una pagina predefinita
                }
            }
            ?>
        </form>

    </div>

    <div class="d-flex" style="height: 200px;">
        <div class="vr"></div>
    </div>



    <footer id="social" class="footer bg-secondary mt-5 positionc-bottom">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>