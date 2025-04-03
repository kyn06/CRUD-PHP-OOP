<?php
session_start();
require_once '../Database/Database.php';
require_once '../Models/User.php';
include '../layout/header.php';

$db = new Database();
User::setConnection($db->getConnection());

$userController = new User();
$userController->authenticateUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allowed_roles = ['librarian', 'admin', 'super-admin'];
    
    $existingUser = User::findByEmail($_POST['email']);
    if ($existingUser) {
        echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'Email is already taken.',
            icon: 'error',
            confirmButtonText: 'Ok'
        }).then(function() {
            window.location = '../users/create.php';
        });
        </script>";
        exit();
    }

    $userData = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'role' => $_POST['role'],
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    if (!in_array($userData['role'], $allowed_roles)) {
        echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'Invalid role selected.',
            icon: 'error',
            confirmButtonText: 'Ok'
        }).then(function() {
            window.location = '../users/create.php';
        });
        </script>";
        exit();
    }

    $newUser = User::create($userData);

    if ($newUser) {
        echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'User has been created.',
            icon: 'success',
            confirmButtonText: 'Ok'
        }).then(function() {
            window.location = '../users/index.php';
        });
        </script>";
    } else {
        echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'Failed to create user, try again.',
            icon: 'error',
            confirmButtonText: 'Ok'
        }).then(function() {
            window.location = '../users/create.php';
        });
        </script>";
    }
}
?>