<?php
session_start();
require_once '../Database/Database.php';
require_once '../Models/User.php';
include '../layout/header.php';

$db = new Database();
User::setConnection($db->getConnection());

$userController = new User();
$userController->authenticateUser();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    $user = User::find($id);
    if ($user) {
        if ($user->delete()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'User has been deleted successfully.',
                        confirmButtonText: 'Ok'
                    }).then(function() {
                        window.location = '../users/index.php';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to delete the user. Please try again.',
                        confirmButtonText: 'Ok'
                    }).then(function() {
                        window.location = '../users/index.php';
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'User not found.',
                    confirmButtonText: 'Ok'
                }).then(function() {
                    window.location = '../users/index.php';
                });
              </script>";
    }
} else {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Invalid user ID. Please try again.',
                confirmButtonText: 'Ok'
            }).then(function() {
                window.location = '../users/index.php';
            });
          </script>";
}
?>