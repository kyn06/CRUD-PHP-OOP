<?php

require_once 'Model.php';

class User extends Model {
    protected static $table = 'users';

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $role;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all() {
        $results = parent::all();
        return $results ? array_map(fn($user) => new self($user), $results) : null;
    }

    public static function find($id) {
        $result = parent::find($id);
        return $result ? new self($result) : null;
    }

    public static function findByEmail($email) {
        try {
            $sql = "SELECT * FROM " . static::$table . " WHERE email = :email";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            return $stmt->fetch(); // Fetch as associative array by default
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public static function login($email, $password) {
        $userData = self::findByEmail($email);

        if ($userData) {
            if (password_verify($password, $userData['password'])) {
                if ($userData['status'] == 'inactive') {
                    $_SESSION['error'] = "Your account is deactivated. Please contact the super-admin.";
                    return false;
                }
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $userData['role'];
                return true;
            }
        }
        $_SESSION['error'] = "Invalid email or password.";
        return false;
    }

    public static function create(array $data) {
        $result = parent::create($data);
        return $result ? new self($result) : null;
    }

    public function update(array $data) {
        $result = parent::updateById($this->id, $data);

        if ($result) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function save() {
        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => password_hash($this->password, PASSWORD_DEFAULT),
            'status' => $this->status,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

        $this->update($data);
    }

    public function delete() {
        $result = parent::deleteById($this->id);

        if ($result) {
            foreach ($this as $key => $value) {
                if (property_exists($this, $key)) {
                    unset($this->$key);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function getUsers() {
        $users = self::all();

        if (empty($users)) {
            http_response_code(404);
            echo "<h1 style='text-align: center; 
                font-size: 70px; font-family: Verdana, sans-serif; 
                margin-top: 250px; 
                background: -webkit-linear-gradient(rgb(88, 10, 10),rgb(182, 98, 98)); 
                -webkit-background-clip: text;  
                -webkit-text-fill-color: transparent;'>
                    No Users Found!
                    <br>  ｡°(°.◜ᯅ◝°)°｡  
                  </h1>";
            exit();
        }

        return $users;
    }

    public static function countAllUsers() {
        return self::countAll();
    }

    public static function countNewUsers($startDate, $endDate) {
        return self::countNew($startDate, $endDate);
    }

    public static function countUsersByStatus($status) {
        return self::countByStatus($status);
    }

    private $user;

    public function authenticateUser () {
        if (!isset($_SESSION['email'])) {
            header("Location: ../auth/login.php");
            exit();
        }

        $user = self::findByEmail($_SESSION['email']);

        if (!$user) {
            session_destroy();
            header("Location: ../auth/login.php");
            exit();
        }

        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $pathSegments = explode('/', $currentPath);
        $isBooks = in_array('books', $pathSegments);

        $this->user = $user;

        $role = $_SESSION['role'];

        switch ($role) {
            case 'super-admin':
                return $user;

            case 'librarian':
            case 'admin':
                if ($isBooks) {
                    return $user; 
                } else {
                    http_response_code(403);
                    echo "<h1 style='font-size: 60px; text-align: center'>
                            Access Denied. You can only access books.
                        </h1>";
                    echo '<div style="font-size: 30px; text-align: center">
                            <a href="../index.php" class="btn btn-outline-secondary">Go Back</a>
                        </div>';
                    exit();
                }

            default:
                http_response_code(403);
                echo "<h1 style='font-size: 60px; text-align: center'>
                        Access Denied. Contact your super-admin to access this page.
                    </h1>";
                echo '<div style="font-size: 30px; text-align: center">
                        <a href="../index.php" class="btn btn-outline-secondary">Back to Home</a>
                    </div>';
                exit();
        }
    }

    public function getUserName() {
        return $this->user['first_name'];
    }
}