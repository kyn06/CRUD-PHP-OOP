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
    echo '<div class="text-center"><a href=\"index.php\" class="btn btn-outline-secondary">Back to Home</a></div>';
    exit;
}

// Fetch user using the User model
$user = User::find($id);
if (!$user) {
    http_response_code(404);
    echo "<h1 class='text-center text-danger'>404 Not Found</h1>";
    echo '<div class="text-center"><a href=\"../users/index.php\" class="btn btn-outline-secondary">Back to Home</a></div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
            letter-spacing: 0.3rem;
            font-weight: 700;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 70px;
            margin-bottom: 70px;
            box-shadow: 0 4px 8px #2d4b48;
            width: 50%;
            max-width: 600px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .required:after {
            content: " *";
            color: red;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>EDIT USER DETAILS</h1>
        <form action="update.php?id=<?= $user->id ?>" method="POST">
            <label for="first_name" class="required">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control" 
                   value="<?= htmlspecialchars($user->first_name) ?>" required>

            <label for="last_name" class="required">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control" 
                   value="<?= htmlspecialchars($user->last_name) ?>" required>

            <label for="email" class="required">Email</label>
            <input type="email" id="email" name="email" class="form-control" 
                   value="<?= htmlspecialchars($user->email) ?>" required>

            <label for="role" class="required">Role</label>
            <select id="role" name="role" class="form-control" required>
                <option value=" "></option>
                <option value="librarian" <?= ($user->role == 'librarian') ? 'selected' : '' ?>>Librarian</option>
                <option value="admin" <?= ($user->role == 'admin') ? 'selected' : '' ?>>Admin</option>
                <option value="super-admin" <?= ($user->role == 'super-admin') ? 'selected' : '' ?>>Super Admin</option>
            </select>

            <div class="d-flex justify-content-between mt-3">
                <div>
                    <select id="status" name="status" class="form-control" style="font-size: 25px;" required>
                        <option value="active" <?= ($user->status == 'active') ? 'selected' : '' ?>>Activate</option>
                        <option value="inactive" <?= ($user->status == 'inactive') ? 'selected' : '' ?>>Deactivate</option>
                    </select>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-outline-secondary btn-lg" href="../users/index.php">
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
            </div>
        </form>
    </div>
</body>

</html>