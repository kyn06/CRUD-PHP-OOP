<?php
session_start();
require_once '../Database/Database.php';
require_once '../Models/User.php';
include '../layout/header.php';

// Initialize database connection
$db = new Database();
User::setConnection($db->getConnection());

// Create UserController instance and authenticate
$userController = new User();
$userController->authenticateUser();

// Get user ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (empty($id)) {
    http_response_code(404);
    echo "<h1 class='text-center text-danger'>Not Found.</h1>";
    echo '<div class="text-center"><a href="../users/index.php" class="btn btn-outline-secondary">Back to Home</a></div>';
    exit;
}

// Fetch user details using the User model
$user = User::find($id);

if (!$user) {
    http_response_code(404);
    echo "<h1 class='text-center text-danger'>404 Not Found</h1>";
    echo '<div class="text-center"><a href="../users/index.php" class="btn btn-outline-secondary">Back to Home</a></div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Details</title>
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
            letter-spacing: 1rem;
            font-weight: 700;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 50px #2d4b48;
            max-height: 700px;
            width: 60%;
            max-width: 600px;
        }

        .center-box p {
            text-align: flex-start;
            margin-left: 10%
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>USER DETAILS</h1>
        <div class="center-box">
            <p><strong>First Name:</strong> <?= htmlspecialchars($user->first_name) ?></p>
            <p><strong>Last Name:</strong> <?= htmlspecialchars($user->last_name) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user->email) ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($user->role) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($user->status) ?></p>
        </div>
        <div class="d-grid col-5 mx-auto">
            <a class="btn btn-outline-secondary" href="../users/index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="14" fill="none" viewBox="0 0 24 24"
                    stroke="#000000" stroke-width="3" stroke="currentColor" class="size-3">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </a>
        </div>
    </div>
</body>

</html>