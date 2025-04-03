<?php
session_start();
require_once '../Database/Database.php';
require_once '../Models/User.php';
require_once '../Models/Book.php';
include '../layout/header.php';

$db = new Database();
User::setConnection($db->getConnection());
Book::setConnection($db->getConnection());

$userController = new User();
$userController->authenticateUser();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (empty($id)) {
    http_response_code(404);
    echo "<h1 class='text-center text-danger'>Not Found.</h1>";
    echo '<div class=\"text-center\"><a href=\"../books/index.php\" class=\"btn btn-outline-secondary\">Back to Home</a></div>';
    exit;
}

$book = Book::find($id);
if (!$book) {
    http_response_code(404);
    echo "<h1 class='text-center text-danger'>404 Not Found</h1>";
    echo '<div class=\"text-center\"><a href=\"../books/index.php\" class=\"btn btn-outline-secondary\">Back to Home</a></div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <style>
        body {
            font-family: "Verdana", serif;
            background-color: #7bb497;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            text-align: center;
            letter-spacing: 1rem;
            font-weight: 700;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 50px #2d4b48;
            max-height: 700px;
            width: 60%;
            max-width: 600px;
        }

        .center-box p {
            text-align: flex-start;
            margin-left: 30%;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>BOOK DETAILS</h1>
        <div class="center-box">
            <p><strong>Title:</strong> <?= htmlspecialchars($book->title) ?></p>
            <p><strong>Author:</strong> <?= htmlspecialchars($book->author) ?></p>
            <p><strong>Genre:</strong> <?= htmlspecialchars($book->genre) ?></p>
            <p><strong>Year Published:</strong> <?= htmlspecialchars($book->year_published) ?></p>
            <p><strong>SKU:</strong> <?= htmlspecialchars($book->sku) ?></p>
            <p><strong>Price:</strong> <?= htmlspecialchars($book->currency) ?> <?= number_format((float)$book->price, 2) ?></p>
            <p><strong>Stock:</strong> <?= htmlspecialchars($book->stock) ?></p>
        </div>
        <div class="d-grid col-5 mx-auto">
            <a class="btn btn-outline-secondary" href="../books/index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="14" fill="none" viewBox="0 0 24 24"
                    stroke="#000000" stroke-width="3" stroke="currentColor" class="size-3">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </a>
        </div>
    </div>
</body>

</html>