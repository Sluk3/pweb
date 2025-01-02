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
    <title>SLUKE My orders</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image" href="../IMG/logo transparent0000.png">
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
    <div class="container">
        <h1 class="">Orders</h1>


        <?php




        $orderQuery = 'SELECT oh.id ,oh.date,oh.confirmed,p.title,od.cur_price,od.quantity FROM order_head oh JOIN order_detail od ON oh.id = od.order_id JOIN product p ON od.prod_id = p.id WHERE oh.username = ? ORDER BY oh.date DESC;';
        $stmt1 = $conn->prepare($orderQuery);
        $stmt1->bind_param('s', $_SESSION['username']);
        $empty = true;

        if ($stmt1->execute()) {
            $result1 = $stmt1->get_result(); // Ottieni il risultato della query

            if ($result1->num_rows > 0) {
                while ($row1 = $result1->fetch_array(MYSQLI_ASSOC)) {
                    $stmt2 = $conn->prepare('SELECT * FROM order_detail WHERE order_id = ?');
                    $stmt2->bind_param('i', $row1['id']);
                    if ($stmt2->execute()) {
                        $result2 = $stmt2->get_result(); // Ottieni il risultato della query

                        if ($result2->num_rows > 0) {
                            echo ' <h2 class="my-4">Order #' . $row1['id'] . '</h2>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5  g-4">';

                            while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
                                echo '<h4 class="text-primary">' . $row1['title'] . '</h4>';
                                $empty = false;
                            }
                            echo ' </div>';
                        }
                    }
                }
            }
        }
        ?>

    </div>
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







    <footer id="social" class="footer bg-secondary mt-5">
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