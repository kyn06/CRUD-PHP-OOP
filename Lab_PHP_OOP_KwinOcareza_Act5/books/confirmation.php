<?php
session_start();
require_once '../Database/Database.php';
require_once '../Models/User.php';
require_once '../Models/Book.php';
require_once '../layout/header.php';

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

if (empty($id)) {
    echo '<script>
            Swal.fire({
                title: "Error!",
                text: "Invalid book ID.",
                icon: "error",
                confirmButtonText: "Ok"
            }).then(() => {
                window.location = "../books/index.php";
            });
        </script>';
    exit;
}

echo '<script>
        Swal.fire({
            title: "Warning!",
            text: "Are you sure about that?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Confirm"
        }).then((result) => {
            if(result.isConfirmed) {
                window.location = "../books/destroy.php?id=' . $id . '";
            } else {
                window.location = "../books/index.php";
            }
        });
    </script>';
?>

<?php require_once '../layout/footer.php'; ?>