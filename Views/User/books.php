<?php
require_once '../../vendor/autoload.php';

// use App\Config\DbConnection;
use App\Controllers\BookControllers\BookController;
use App\Models\Entity\Book;

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Member') {
    header("Location: ../auth/login.php");
    exit;
}

$bookController = new BookController();
$books = $bookController->findAll();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartLibra - Books</title>
    <link rel="icon" type="image/x-icon" href="../../Public/img/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .book-card:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#">SmartLibra</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill" id="cartCount">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Library Book Catalog</h1>
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 book-card">
                        <img class="card-img-top" src="<?php echo htmlspecialchars($book['image_link']); ?>"
                            alt="<?php echo htmlspecialchars($book['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($book['title']); ?>
                            </h5>
                            <p class="card-text">
                                <?php echo htmlspecialchars($book['description']); ?>
                            </p>
                            <p>Author:
                                <?php echo htmlspecialchars($book['author']); ?>
                            </p>
                            <p>Genre:
                                <?php echo htmlspecialchars($book['genre']); ?>
                            </p>
                            <p>Publication Year:
                                <?php echo htmlspecialchars($book['publicationYear']); ?>
                            </p> <!-- Add this line -->
                        </div>
                        <div class="card-footer">
                            <?php if ($book['availiable_copies'] < 1) { ?>

                                <button type="hidden" class="btn btn-primary disabled">Reserve it</button>
                            <?php } else { ?>

                                <button onclick="reserveBook(<?php echo htmlspecialchars($book['id']); ?>)" class="btn btn-primary">Reserve it</button>
                            <?php } ?>
                         
                           
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Footer -->
    <footer class="footer mt-5 bg-light">
        <div class="container text-center py-3">
            <span>&copy; SmartLibra 2023</span>
        </div>
    </footer>

    <script src="../../Public/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>