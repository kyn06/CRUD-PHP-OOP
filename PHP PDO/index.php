<?php

session_start();
include 'layout/header.php';
require 'database/Database.php';
require 'models/User.php';
require 'models/Book.php';

$database = new Database();
$db = $database->getConnection();
User::setConnection($db);
Book::setConnection($db);

if (!isset($_SESSION['email'])) {
    header('Location: auth/login.php');
    exit;
}

$user = User::findByEmail($_SESSION['email']);
$user_first_name = $user['first_name'];
$date = date('Y-m-d H:i:s', strtotime('-1 day'));
$dateNow = date('Y-m-d H:i:s');

$total_books = Book::countAllBooks();
$total_users = User::countAllUsers();
$new_books = Book::countNewBooks($date, $dateNow);
$new_users = User::countNewUsers($date, $dateNow);
$active_users = User::countUsersByStatus('active');
$inactive_users = User::countUsersByStatus('inactive');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="layout/style.css">
    <title>HOME PAGE</title>
</head>

<body>

    <nav class="navbar">
        <div class="brand bx bx-library icon">LIBRARY</div>
        <div class="nav-links">
            <a class="active"><i class='bx bxs-dashboard icon'></i> Analytics</a>
            <a href="users/index.php"><i class='bx bxs-user icon'></i> Manage Users</a>
            <a href="books/index.php"><i class='bx bxs-book icon'></i> Manage Books</a>
        </div>
        <div class="user-links">
            <a href="#"><i class='bx bxs-user icon'></i><?= htmlspecialchars($user_first_name) ?></a>
        </div>
    </nav>

    <section id="content">
        <main>
            <h1 class="title">Analytics</h1>
            <div class="info-data">
                <div class="card">
                    <div class="head">
                        <div>
                            <h2><?= $total_books ?></h2>
                            <p>Total Books</p>
                        </div>
                        <i class='bx bxs-book icon'></i>
                    </div>
                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2><?= $new_books ?></h2>
                            <p>New Books (24h)</p>
                        </div>
                        <i class='bx bxs-book-add icon'></i>
                    </div>
                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2><?= $active_users ?></h2>
                            <p>Active Users</p>
                        </div>
                        <i class='bx bxs-user-check icon'></i>
                    </div>
                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2><?= $total_users ?></h2>
                            <p>Total Users</p>
                        </div>
                        <i class='bx bxs-user icon'></i>
                    </div>
                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2><?= $new_users ?></h2>
                            <p>New Users (24h)</p>
                        </div>
                        <i class='bx bxs-user-plus icon'></i>
                    </div>
                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2><?= $inactive_users ?></h2>
                            <p>Inactive Users</p>
                        </div>
                        <i class='bx bxs-user-x icon'></i>
                    </div>
                </div>
            </div>
        </main>
    </section>

    <div class="logout-container">
        <a href="auth/logout.php" class="logout-btn">
            <i class='bx bxs-log-out icon'></i> Logout
        </a>
    </div>

</body>

</html>
<?php include 'layout/footer.php'; ?>