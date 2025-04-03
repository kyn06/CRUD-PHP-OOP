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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allowed_roles = ['librarian', 'admin', 'super-admin'];
    
    $updateData = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'role' => $_POST['role'],
        'status' => $_POST['status'],
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $existingUser = User::findByEmail($updateData['email']);
    if ($existingUser && $existingUser['id'] != $id) {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Email is already taken by another user.',
                icon: 'error',
                confirmButtonText: 'Ok'
            }).then(function() {
                window.location = '../users/edit.php?id=" . $id . "';
            });
        </script>";
        exit();
    }

    if (!in_array($updateData['role'], $allowed_roles)) {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Invalid role selected.',
                icon: 'error',
                confirmButtonText: 'Ok'
            }).then(function() {
                window.location = '../users/edit.php?id=" . $id . "';
            });
        </script>";
        exit();
    }

    $user = User::find($id);
    if (!$user) {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'User not found.',
                icon: 'error',
                confirmButtonText: 'Ok'
            }).then(function() {
                window.location = '../users/index.php';
            });
        </script>";
        exit();
    }

    $result = $user->update($updateData);

    if ($result) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'User has been updated.',
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
                text: 'Failed to update the user, try again.',
                icon: 'error',
                confirmButtonText: 'Ok'
            }).then(function() {
                window.location = '../users/edit.php?id=" . $id . "';
            });
        </script>";
    }
}
?>