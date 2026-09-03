<?php

require_once __DIR__ . "/AuthController.php";
require_once __DIR__ . "/../Model/User.php";
require_once __DIR__ . "/../Model/Item.php";
require_once __DIR__ . "/../Model/Claim.php";
require_once __DIR__ . "/../Model/Category.php";

function getAdminDashboardData()
{
    $userModel = new User();
    $itemModel = new Item();
    $claimModel = new Claim();
    $categoryModel = new Category();

    return [
        "total_users" => $userModel->countAll(),
        "students" => $userModel->countByRole("Student"),
        "moderators" => $userModel->countByRole("Moderator"),
        "items" => $itemModel->countAll(),
        "claims" => $claimModel->countAll(),
        "categories" => $categoryModel->countAll()
    ];
}

function getAllUsersForAdmin()
{
    $userModel = new User();

    return $userModel->getAll();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {

    $action = $_POST["action"];

    if ($action == "add_user") {

        requireRole("Admin");

        $required = [
            "first_name",
            "last_name",
            "email",
            "phone",
            "username",
            "password",
            "role"
        ];

        foreach ($required as $field) {

            if (cleanInput($_POST[$field] ?? "") == "") {

                setMessage(
                    "error",
                    "Please fill all required fields."
                );

                redirectTo(
                    viewPath("admin-users.php")
                );
            }
        }

        $firstName = cleanInput($_POST["first_name"]);
        $lastName = cleanInput($_POST["last_name"]);
        $email = cleanInput($_POST["email"]);
        $phone = cleanInput($_POST["phone"]);
        $username = cleanInput($_POST["username"]);
        $password = $_POST["password"];
        $role = cleanInput($_POST["role"]);

        $userModel = new User();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            setMessage(
                "error",
                "Please enter a valid email address."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        if (!validRole($role)) {

            setMessage(
                "error",
                "Please select a valid role."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        if (
            strlen($password) < 8 ||
            !preg_match("/[A-Z]/", $password) ||
            !preg_match("/[a-z]/", $password) ||
            !preg_match("/[0-9]/", $password) ||
            !preg_match("/[\W_]/", $password)
        ) {

            setMessage(
                "error",
                "Password must be at least 8 characters and contain uppercase, lowercase, number, and special character."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        if ($userModel->emailExists($email)) {

            setMessage(
                "error",
                "Email already exists."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        if ($userModel->usernameExists($username)) {

            setMessage(
                "error",
                "Username already exists."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $data = [
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email,
            "phone" => $phone,
            "username" => $username,
            "password" => $passwordHash,
            "role" => $role
        ];

        $newUserId = $userModel->create($data);

        if (!$newUserId) {

            setMessage(
                "error",
                "User creation failed."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        setMessage(
            "success",
            "User added successfully."
        );

        redirectTo(
            viewPath("admin-users.php")
        );
    }

    if ($action == "update_user") {

        requireRole("Admin");

        $id = (int) ($_POST["id"] ?? 0);

        $required = [
            "first_name",
            "last_name",
            "email",
            "phone",
            "username",
            "role"
        ];

        foreach ($required as $field) {

            if (cleanInput($_POST[$field] ?? "") == "") {

                setMessage(
                    "error",
                    "Please fill all required fields."
                );

                redirectTo(
                    viewPath("admin-users.php")
                );
            }
        }

        $firstName = cleanInput($_POST["first_name"]);
        $lastName = cleanInput($_POST["last_name"]);
        $email = cleanInput($_POST["email"]);
        $phone = cleanInput($_POST["phone"]);
        $username = cleanInput($_POST["username"]);
        $role = cleanInput($_POST["role"]);

        $userModel = new User();

        if ($id <= 0) {

            setMessage(
                "error",
                "Invalid user ID."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        if (!$userModel->findById($id)) {

            setMessage(
                "error",
                "User not found."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            setMessage(
                "error",
                "Please enter a valid email address."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        if (!validRole($role)) {

            setMessage(
                "error",
                "Please select a valid role."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        if ($userModel->emailExists($email, $id)) {

            setMessage(
                "error",
                "Email already exists."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        if ($userModel->usernameExists($username, $id)) {

            setMessage(
                "error",
                "Username already exists."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        $data = [
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email,
            "phone" => $phone,
            "username" => $username,
            "role" => $role
        ];

        if (!$userModel->updateByAdmin($id, $data)) {

            setMessage(
                "error",
                "User update failed."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        setMessage(
            "success",
            "User updated successfully."
        );

        redirectTo(
            viewPath("admin-users.php")
        );
    }

    if ($action == "delete_user") {

        requireRole("Admin");

        $id = (int) ($_POST["id"] ?? 0);

        if ($id <= 0) {

            setMessage(
                "error",
                "Invalid user ID."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        if ($id == $_SESSION["user_id"]) {

            setMessage(
                "error",
                "You cannot delete your own account."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        $userModel = new User();

        if (!$userModel->findById($id)) {

            setMessage(
                "error",
                "User not found."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        if (!$userModel->delete($id)) {

            setMessage(
                "error",
                "User deletion failed."
            );

            redirectTo(
                viewPath("admin-users.php")
            );
        }

        setMessage(
            "success",
            "User deleted successfully."
        );

        redirectTo(
            viewPath("admin-users.php")
        );
    }
}

?>
