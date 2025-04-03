<?php

class Model {
    protected static $conn;
    protected static $table;

    public static function setConnection($conn) {
        self::$conn = $conn;
    }

    public static function all() {
        try {
            $sql = "SELECT * FROM " . static::$table;
            $stmt = self::$conn->query($sql);
            $rows = $stmt->fetchAll();
            return count($rows) > 0 ? $rows : null;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public static function find($id) {
        try {
            $sql = "SELECT * FROM " . static::$table . " WHERE id = :id";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();
            return $row ? $row : null;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public static function create(array $data) {
        try {
            $columns = implode(",", array_keys($data));
            $values = implode(",", array_map(fn($key) => ":$key", array_keys($data)));

            $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($values)";
            $stmt = self::$conn->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            $id = self::$conn->lastInsertId();

            return self::find($id);
        } catch (PDOException $e) {
            die("Insert failed: " . $e->getMessage());
        }
    }

    public static function updateById($id, array $data) {
        try {
            $set = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));

            $sql = "UPDATE " . static::$table . " SET $set WHERE id = :id";
            $stmt = self::$conn->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return self::find($id);
        } catch (PDOException $e) {
            die("Update failed: " . $e->getMessage());
        }
    }

    public static function deleteById($id) {
        try {
            $sql = "DELETE FROM " . static::$table . " WHERE id = :id";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Delete failed: " . $e->getMessage());
        }
    }

    public static function countAll() {
        try {
            $query = "SELECT COUNT(*) as total FROM " . static::$table;
            $stmt = self::$conn->query($query);
            $row = $stmt->fetch();
            return $row['total'];
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public static function countNew($startDate, $endDate) {
        try {
            $query = "SELECT COUNT(*) as total FROM " . static::$table . " WHERE created_at BETWEEN :startDate AND :endDate";
            $stmt = self::$conn->prepare($query);
            $stmt->bindValue(':startDate', $startDate);
            $stmt->bindValue(':endDate', $endDate);
            $stmt->execute();
            $row = $stmt->fetch();
            return $row['total'];
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public static function countByStatus($status) {
        try {
            $query = "SELECT COUNT(*) as total FROM " . static::$table . " WHERE status = :status";
            $stmt = self::$conn->prepare($query);
            $stmt->bindValue(':status', $status);
            $stmt->execute();
            $row = $stmt->fetch();
            return $row['total'];
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
}