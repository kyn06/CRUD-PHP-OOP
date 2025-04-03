<?php
session_start();
require_once '../Database/Database.php';
require_once '../Models/User.php';
require_once '../layout/header.php';

$db = new Database();
User::setConnection($db->getConnection());

$userController = new User();
$userController->authenticateUser();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

echo '<script>
        Swal.fire({
            title: "Warning!",
            text: "Are you sure you want to remove this user?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Confirm"
        }).then((result) => {
            if(result.isConfirmed) {
                window.location = "../users/destroy.php?id=' . $id . '";
            }else {
                window.location = "../users/index.php";
            }
        });
    </script>';
?>

<?php require_once '../layout/footer.php'; ?>