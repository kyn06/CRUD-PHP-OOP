<?php
session_start();
require_once '../Database/Database.php';
require_once '../Models/User.php';
include '../layout/header.php';

$db = new Database();
User::setConnection($db->getConnection());

$userController = new User();

$user = $userController->authenticateUser();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
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
            letter-spacing: 0.5rem;
            font-weight: 600;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 50px #2d4b48;
            max-height: 800px;
            width: 60%;
            max-width: 600px;
        }

        .required:after {
            content: " *";
            color: red;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid;
            border-radius: 10px;
        }

        label {
            font-weight: 600;
            margin: 1px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>CREATING NEW USER</h1>
        <form action="store.php" method="POST">
            <label for="first_name" class="required">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control" required>

            <label for="last_name" class="required">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control" required>

            <label for="email" class="required">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>

            <label for="password" class="required">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>

            <label for="role" class="required">Role</label>
            <select id="role" name="role" class="form-control" required>
                <option value=" "></option>
                <option value="librarian">Librarian</option>
                <option value="admin">Admin</option>
                <option value="super-admin">Super Admin</option>
            </select>

            <div class="d-grid gap-2 d-md-flex mt-3 justify-content-md-end">
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
        </form>
    </div>
</body>

</html>