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
$user = $userController->authenticateUser();

if ($user['role'] !== 'admin' && $user['role'] !== 'super-admin') {
    http_response_code(403);
    echo "<h1 style='font-size: 60px; text-align: center'>
            Access Denied. Only admin and super admin can delete books.
            </h1>";
    echo '<div style="font-size: 30px; text-align: center">
            <a href=\"../books/index.php\" class=\"btn btn-outline-secondary\">
            Back to Home    
            </a>
        </div>';
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    $book = Book::find($id);
    if ($book) {
        if ($book->delete()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Book has been deleted successfully.',
                        confirmButtonText: 'Ok'
                    }).then(function() {
                        window.location = '../books/index.php';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to delete the book. Please try again.',
                        confirmButtonText: 'Ok'
                    }).then(function() {
                        window.location = '../books/index.php';
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Book not found.',
                    confirmButtonText: 'Ok'
                }).then(function() {
                    window.location = '../books/index.php';
                });
              </script>";
    }
} else {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Invalid book ID. Please try again.',
                confirmButtonText: 'Ok'
            }).then(function() {
                window.location = '../books/index.php';
            });
          </script>";
}
?>