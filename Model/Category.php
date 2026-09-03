<?php

require_once __DIR__ . "/Database.php";

class Category
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function getAll()
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT * FROM categories ORDER BY name ASC"
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function findById($id)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT * FROM categories WHERE id = ? LIMIT 1"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $id
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    public function nameExists($name, $ignoreId = null)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT id FROM categories WHERE name = ? LIMIT 1"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $name
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $category = mysqli_fetch_assoc($result);

        return $category && $category["id"] != $ignoreId;
    }

    public function create($name)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "INSERT INTO categories (name) VALUES (?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $name
        );

        return mysqli_stmt_execute($stmt);
    }

    public function update($id, $name)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "UPDATE categories SET name = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $name,
            $id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function delete($id)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "DELETE FROM categories WHERE id = ?"
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
            "SELECT COUNT(*) AS total FROM categories"
        );

        $row = mysqli_fetch_assoc($result);

        return $row["total"];
    }
}

?>
