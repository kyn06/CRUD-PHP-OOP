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
    <title>Edit Book</title>
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
            padding-bottom: 2%;
            letter-spacing: 0.3rem;
            font-weight: 700;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 70px;
            margin-bottom: 70px;
            box-shadow: 0 4px 8px #2d4b48;
            width: 50%;
            max-width: 600px;
        }

        label {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>EDIT BOOK DETAILS</h1>
        <form action="update.php?id=<?= $book->id ?>" method="POST">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($book->title) ?>" required>

            <label for="author">Author</label>
            <input type="text" id="author" name="author" class="form-control" value="<?= htmlspecialchars($book->author) ?>" required>

            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre" class="form-control" value="<?= htmlspecialchars($book->genre) ?>" required>

            <label for="year_published">Year Published</label>
            <select id="year_published" name="year_published" class="form-control" required>
                <option value=" "></option>
                <?php
                $currentYear = date("Y");
                for ($i = $currentYear; $i >= $currentYear - 100; $i--) {
                    $selected = ($i == $book->year_published) ? 'selected' : '';
                    echo "<option value='$i' $selected>$i</option>";
                }
                ?>
            </select>

            <label for="sku">SKU</label>
            <input type="text" id="sku" name="sku" class="form-control" value="<?= htmlspecialchars($book->sku) ?>" required>

            <label for="price">Price</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" value="<?= htmlspecialchars($book->price) ?>" required>

            <label for="currency">Currency</label>
            <select id="currency" name="currency" class="form-control" required>
                <option value=" "></option>
                <option value="PHP" <?= ($book->currency == 'PHP') ? 'selected' : '' ?>>PHP</option>
                <option value="USD" <?= ($book->currency == 'USD') ? 'selected' : '' ?>>USD</option>
                <option value="EUR" <?= ($book->currency == 'EUR') ? 'selected' : '' ?>>EUR</option>
            </select>

            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" class="form-control" value="<?= htmlspecialchars($book->stock) ?>" required>

            <div class="d-grid gap-2 mt-3 d-md-flex justify-content-md-end">
                <a class="btn btn-outline-secondary btn-lg" href="../books/index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                    </svg>
                </a>
                <button type="submit" class="btn btn-outline-primary btn-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</body>

</html>