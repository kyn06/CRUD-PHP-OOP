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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'sku' => $_POST['sku'],
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'genre' => $_POST['genre'],
        'year_published' => $_POST['year_published'],
        'price' => $_POST['price'],
        'currency' => $_POST['currency'],
        'stock' => $_POST['stock'],
        'created_at' => date('Y-m-d H:i:s')
    ];

    $existingBook = Book::findBySku($data['sku']);
    if ($existingBook) {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'SKU is already taken.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                }).then(function() {
                    window.location = '../books/create.php';
                });
              </script>";
        exit();
    }

    $book = Book::create($data);
    if ($book) {
        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Book has been stored.',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then(function() {
                    window.location = '../books/index.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to enter the book, try again.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                }).then(function() {
                    window.location = '../books/create.php';
                });
              </script>";
    }
}
?>