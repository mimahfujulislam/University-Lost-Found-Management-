<?php

require_once __DIR__ . "/Database.php";

class Item
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function create($data)
    {
        $sql = "INSERT INTO items
                (user_id, type, item_name, category_id, description, item_date, location, image, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conn, $sql);

        $userId = $data["user_id"];
        $type = $data["type"];
        $itemName = $data["item_name"];
        $categoryId = $data["category_id"];
        $description = $data["description"];
        $itemDate = $data["item_date"];
        $location = $data["location"];
        $image = $data["image"] ?? null;
        $status = $data["status"] ?? "Pending";

        mysqli_stmt_bind_param(
            $stmt,
            "isissssss",
            $userId,
            $type,
            $itemName,
            $categoryId,
            $description,
            $itemDate,
            $location,
            $image,
            $status
        );

        return mysqli_stmt_execute($stmt);
    }

    public function findById($id)
    {
        $sql = "SELECT items.*, categories.name AS category_name, users.username
                FROM items
                LEFT JOIN categories ON items.category_id = categories.id
                LEFT JOIN users ON items.user_id = users.id
                WHERE items.id = ?
                LIMIT 1";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    public function getByUser($userId)
    {
        $sql = "SELECT items.*, categories.name AS category_name
                FROM items
                LEFT JOIN categories ON items.category_id = categories.id
                WHERE items.user_id = ?
                ORDER BY items.id DESC";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $userId);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getRecentApproved($limit = 5)
    {
        $limit = (int) $limit;

        $sql = "SELECT items.*, categories.name AS category_name
                FROM items
                LEFT JOIN categories ON items.category_id = categories.id
                WHERE items.status = 'Approved'
                ORDER BY items.id DESC
                LIMIT $limit";

        $result = mysqli_query($this->conn, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getPending()
    {
        $sql = "SELECT items.*, categories.name AS category_name, users.username
                FROM items
                LEFT JOIN categories ON items.category_id = categories.id
                LEFT JOIN users ON items.user_id = users.id
                WHERE items.status = 'Pending'
                ORDER BY items.id DESC";

        $result = mysqli_query($this->conn, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getRecentlyReviewed($limit = 5)
    {
        $limit = (int) $limit;

        $sql = "SELECT items.*, categories.name AS category_name
                FROM items
                LEFT JOIN categories ON items.category_id = categories.id
                WHERE items.status <> 'Pending'
                ORDER BY items.updated_at DESC
                LIMIT $limit";

        $result = mysqli_query($this->conn, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getAllWithDetails()
    {
        $sql = "SELECT items.*, categories.name AS category_name, users.username
                FROM items
                LEFT JOIN categories ON items.category_id = categories.id
                LEFT JOIN users ON items.user_id = users.id
                ORDER BY items.id DESC";

        $result = mysqli_query($this->conn, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function search($filters)
    {
        $sql = "SELECT items.*, categories.name AS category_name
                FROM items
                LEFT JOIN categories ON items.category_id = categories.id
                WHERE items.status = 'Approved'";

        $params = [];
        $types = "";

        if (!empty($filters["item_name"])) {
            $sql .= " AND items.item_name LIKE ?";
            $params[] = "%" . $filters["item_name"] . "%";
            $types .= "s";
        }

        if (!empty($filters["type"])) {
            $sql .= " AND items.type = ?";
            $params[] = $filters["type"];
            $types .= "s";
        }

        if (!empty($filters["category_id"])) {
            $sql .= " AND items.category_id = ?";
            $params[] = $filters["category_id"];
            $types .= "i";
        }

        if (!empty($filters["location"])) {
            $sql .= " AND items.location LIKE ?";
            $params[] = "%" . $filters["location"] . "%";
            $types .= "s";
        }

        if (!empty($filters["item_date"])) {
            $sql .= " AND items.item_date = ?";
            $params[] = $filters["item_date"];
            $types .= "s";
        }

        $sql .= " ORDER BY items.id DESC";

        $stmt = mysqli_prepare($this->conn, $sql);

        if (!empty($params)) {
            mysqli_stmt_bind_param(
                $stmt,
                $types,
                ...$params
            );
        }

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function updateStatus($id, $status)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "UPDATE items SET status = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $status,
            $id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function updateBasic($id, $data)
    {
        $sql = "UPDATE items SET
                type = ?,
                item_name = ?,
                category_id = ?,
                description = ?,
                item_date = ?,
                location = ?,
                status = ?
                WHERE id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $sql
        );

        $type = $data["type"];
        $itemName = $data["item_name"];
        $categoryId = $data["category_id"];
        $description = $data["description"];
        $itemDate = $data["item_date"];
        $location = $data["location"];
        $status = $data["status"];

        mysqli_stmt_bind_param(
            $stmt,
            "ssissssi",
            $type,
            $itemName,
            $categoryId,
            $description,
            $itemDate,
            $location,
            $status,
            $id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function delete($id)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "DELETE FROM items WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function countAll()
    {
        $result = mysqli_query(
            $this->conn,
            "SELECT COUNT(*) AS total FROM items"
        );

        $row = mysqli_fetch_assoc($result);

        return $row["total"];
    }

    public function countByStatus($status)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT COUNT(*) AS total FROM items WHERE status = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $status
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);

        return $row["total"];
    }

    public function countByUser($userId)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT COUNT(*) AS total FROM items WHERE user_id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $userId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);

        return $row["total"];
    }

    public function countByUserAndType($userId, $type)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT COUNT(*) AS total
             FROM items
             WHERE user_id = ? AND type = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "is",
            $userId,
            $type
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);

        return $row["total"];
    }
}

?>
