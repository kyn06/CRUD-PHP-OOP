<?php

session_start();
require '../Database/Database.php';
require '../Models/User.php';
include '../layout/header.php';


$database = new Database();
$db = $database->getConnection();

User::setConnection($db);

$userController = new User();
$userController->authenticateUser();

$users = $userController->getUsers();

$user_first_name = $userController->getUserName();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../layout/style.css">
    <title>USERS</title>
</head>

<body>
    <nav class="navbar">
        <div class="brand bx bx-library icon">LIBRARY</div>
        <div class="nav-links">
            <a href="../index.php"><i class='bx bxs-dashboard icon'></i> Analytics</a>
            <a href="#" class="active"><i class='bx bxs-user icon'></i> Manage Users</a>
            <a href="../books/index.php"><i class='bx bxs-book icon'></i> Manage Books</a>
        </div>
        <div class="user-links">
            <a href="#"><i class='bx bxs-user icon'></i><?= $user_first_name ?></a>
        </div>
    </nav>
    <div class="container-xxl">
        <h1>Users List</h1>
        <table id="usersTable" class="table table-sm table-hover text-center"
            style="margin-top: 10px; margin-bottom: 10px; border: solid; border-radius: 10px;">
            <div class="d-grid d-md-flex justify-content-md-end">
                <a href="../users/create.php" class="btn btn-outline-primary btn-lg" style="margin-bottom: 5px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="14" viewBox="4 3 19 19" fill="none"
                        stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 21H4a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h5l2 3h9a2 2 0 0 1 2 2v2M19 15v6M16 18h6"></path>
                    </svg>
                </a>
            </div>
            <thead class="table-dark">
                <tr>
                    <th style="text-align: center">Email</th>
                    <th style="text-align: center">First Name</th>
                    <th style="text-align: center">Last Name</th>
                    <th style="text-align: center">Role</th>
                    <th style="text-align: center">Status</th>
                    <th style="text-align: center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->email ?></td>
                        <td><?= $user->first_name ?></td>
                        <td><?= $user->last_name ?></td>
                        <td><?= $user->role ?></td>
                        <td><?= $user->status == 'active' ? 'Active' : 'Deactivated' ?></td>
                        <td>
                            <a href="show.php?id=<?= $user->id ?>" class="btn btn-outline-info me-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="14" viewBox="4 3 19 19"
                                    fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <a href="edit.php?id=<?= $user->id ?>" class="btn btn-outline-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="14" viewBox="0 0 23 23"
                                        fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                                        <line x1="3" y1="22" x2="21" y2="22"></line>
                                    </svg>
                                </a>
                                <a href="confirmation.php?id=<?= $user->id ?>" class="btn btn-outline-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="14" viewBox="0 1 22 22"
                                        fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../layout/footer.php'; ?>
</body>
</html>
