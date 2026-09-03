<?php

require_once __DIR__ . "/Database.php";

class User
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function create($data)
    {
        $sql = "INSERT INTO users
                (student_id, first_name, last_name, email, phone, username, password, role)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conn, $sql);

        $studentId = $data["student_id"] ?? null;
        $firstName = $data["first_name"];
        $lastName = $data["last_name"];
        $email = $data["email"];
        $phone = $data["phone"];
        $username = $data["username"];
        $password = $data["password"];
        $role = $data["role"] ?? "Student";

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssss",
            $studentId,
            $firstName,
            $lastName,
            $email,
            $phone,
            $username,
            $password,
            $role
        );

        mysqli_stmt_execute($stmt);

        $newId = mysqli_insert_id($this->conn);

        if ($role == "Student" && empty($studentId)) {

            $studentId = "STU" . str_pad(
                $newId,
                5,
                "0",
                STR_PAD_LEFT
            );

            $update = mysqli_prepare(
                $this->conn,
                "UPDATE users SET student_id = ? WHERE id = ?"
            );

            mysqli_stmt_bind_param(
                $update,
                "si",
                $studentId,
                $newId
            );

            mysqli_stmt_execute($update);
        }

        return $newId;
    }

    public function findByUsernameOrEmail($login)
    {
        $sql = "SELECT * FROM users
                WHERE username = ? OR email = ?
                LIMIT 1";

        $stmt = mysqli_prepare(
            $this->conn,
            $sql
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ss",
            $login,
            $login
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    public function findById($id)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT * FROM users WHERE id = ? LIMIT 1"
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

    public function findByRememberToken($token)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT * FROM users WHERE remember_token = ? LIMIT 1"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $token
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    public function updateRememberToken($id, $token)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "UPDATE users SET remember_token = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $token,
            $id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function clearRememberToken($token)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "UPDATE users SET remember_token = NULL WHERE remember_token = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $token
        );

        return mysqli_stmt_execute($stmt);
    }

    public function emailExists($email, $ignoreId = null)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT id FROM users WHERE email = ? LIMIT 1"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $user = mysqli_fetch_assoc($result);

        return $user && $user["id"] != $ignoreId;
    }

    public function usernameExists($username, $ignoreId = null)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT id FROM users WHERE username = ? LIMIT 1"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $username
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $user = mysqli_fetch_assoc($result);

        return $user && $user["id"] != $ignoreId;
    }

    public function updateProfile($id, $data)
    {
        $sql = "UPDATE users SET
                first_name = ?,
                last_name = ?,
                gender = ?,
                email = ?,
                phone = ?,
                address = ?
                WHERE id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $sql
        );

        $firstName = $data["first_name"];
        $lastName = $data["last_name"];
        $gender = $data["gender"] ?? "";
        $email = $data["email"];
        $phone = $data["phone"];
        $address = $data["address"] ?? "";

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssi",
            $firstName,
            $lastName,
            $gender,
            $email,
            $phone,
            $address,
            $id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function updatePassword($id, $passwordHash)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "UPDATE users SET password = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $passwordHash,
            $id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function getAll()
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT * FROM users ORDER BY id DESC"
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all(
            $result,
            MYSQLI_ASSOC
        );
    }

    public function updateByAdmin($id, $data)
    {
        $sql = "UPDATE users SET
                first_name = ?,
                last_name = ?,
                email = ?,
                phone = ?,
                username = ?,
                role = ?
                WHERE id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $sql
        );

        $firstName = $data["first_name"];
        $lastName = $data["last_name"];
        $email = $data["email"];
        $phone = $data["phone"];
        $username = $data["username"];
        $role = $data["role"];

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssi",
            $firstName,
            $lastName,
            $email,
            $phone,
            $username,
            $role,
            $id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function delete($id)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "DELETE FROM users WHERE id = ?"
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
            "SELECT COUNT(*) AS total FROM users"
        );

        $row = mysqli_fetch_assoc($result);

        return $row["total"];
    }

    public function countByRole($role)
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT COUNT(*) AS total FROM users WHERE role = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $role
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);

        return $row["total"];
    }
}

?>

