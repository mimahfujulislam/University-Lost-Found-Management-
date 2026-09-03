<?php

require_once __DIR__ . "/Database.php";

class Claim
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function create($data)
    {
        $sql = "INSERT INTO claims
                (item_id, user_id, claim_message, contact_info, status)
                VALUES (?, ?, ?, ?, 'Pending')";

        $stmt = mysqli_prepare($this->conn, $sql);

        $itemId = $data["item_id"];
        $userId = $data["user_id"];
        $claimMessage = $data["claim_message"];
        $contactInfo = $data["contact_info"];

        mysqli_stmt_bind_param(
            $stmt,
            "iiss",
            $itemId,
            $userId,
            $claimMessage,
            $contactInfo
        );

        return mysqli_stmt_execute($stmt);
    }

    public function getByUser($userId)
    {
        $sql = "SELECT claims.*, items.item_name, items.type, items.location
                FROM claims
                INNER JOIN items ON claims.item_id = items.id
                WHERE claims.user_id = ?
                ORDER BY claims.id DESC";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $userId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getAllWithDetails()
    {
        $sql = "SELECT claims.*, items.item_name, items.type,
                       items.location, users.username
                FROM claims
                INNER JOIN items ON claims.item_id = items.id
                INNER JOIN users ON claims.user_id = users.id
                ORDER BY claims.id DESC";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function updateStatus($id, $status)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "UPDATE claims SET status = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $status,
            $id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function countAll()
    {
        $result = mysqli_query(
            $this->conn,
            "SELECT COUNT(*) AS total FROM claims"
        );

        $row = mysqli_fetch_assoc($result);

        return $row["total"];
    }

    public function countByStatus($status)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT COUNT(*) AS total FROM claims WHERE status = ?"
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
            "SELECT COUNT(*) AS total FROM claims WHERE user_id = ?"
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
}

?>
