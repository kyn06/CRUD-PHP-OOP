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
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    $data = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'genre' => $_POST['genre'],
        'year_published' => $_POST['year_published'],
        'sku' => $_POST['sku'],
        'price' => $_POST['price'],
        'currency' => $_POST['currency'],
        'stock' => $_POST['stock'],
    ];

    $existingBook = Book::findBySku($data['sku']);
    if ($existingBook && $existingBook->id != $id) {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'SKU is already taken by another book.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                }).then(function() {
                    window.location = '../books/edit.php?id=$id';
                });
              </script>";
        exit();
    }

    $book = Book::find($id);
    if ($book && $book->update($data)) {
        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Book has been updated.',
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
                    text: 'Failed to update the book, try again.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                }).then(function() {
                    window.location = '../books/edit.php?id=$id';
                });
              </script>";
    }
}
?>