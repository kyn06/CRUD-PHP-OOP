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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
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
            letter-spacing: 0.5rem;
            font-weight: 600;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 50px #2d4b48;
            max-height: 850px;
            width: 60%;
            max-width: 600px;
        }

        .required:after {
            content: " *";
            color: red;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid;
            border-radius: 10px;
        }

        label {
            font-weight: 600;
            margin: 1px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>NEW BOOK ENTRY</h1>
        <form action="store.php" method="POST">
            <label for="title" class="required">Title</label>
            <input type="text" id="title" name="title" class="form-control" required>

            <label for="author" class="required">Author</label>
            <input type="text" id="author" name="author" class="form-control" required>

            <label for="genre" class="required">Genre</label>
            <input type="text" id="genre" name="genre" class="form-control" required>

            <label for="year_published" class="required">Year Published</label>
            <select id="year_published" name="year_published" class="form-control" required>
                <option value=" "></option>
                <?php
                $currentYear = date("Y");
                for ($i = $currentYear; $i >= $currentYear - 100; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>

            <label for="sku" class="required">SKU</label>
            <input type="text" id="sku" name="sku" class="form-control" required>

            <label for="price" class="required">Price</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" required>

            <label for="currency" class="required">Currency</label>
            <select id="currency" name="currency" class="form-control" required>
                <option value=" "></option>
                <option value="PHP">PHP</option>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
            </select>

            <label for="stock" class="required">Stock</label>
            <input type="number" id="stock" name="stock" class="form-control" value="0" required>

            <div class="d-grid gap-2 d-md-flex mt-3 justify-content-md-end">
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