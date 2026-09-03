<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../Model/User.php";

function cleanInput($value)
{
    return trim($value ?? "");
}

function e($value)
{
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}

function setMessage($type, $message)
{
    $_SESSION[$type] = $message;
}

function viewPath($file)
{
    $folder = basename(dirname($_SERVER["SCRIPT_NAME"]));

    if ($folder == "View") {
        return $file;
    }

    return "../View/" . $file;
}

function redirectTo($path)
{
    header("Location: " . $path);
    exit();
}

function dashboardFile($role)
{
    if ($role == "Admin") {
        return "admin-dashboard.php";
    }

    if ($role == "Moderator") {
        return "moderator-dashboard.php";
    }

    return "student-dashboard.php";
}

function redirectByRole($role)
{
    redirectTo(viewPath(dashboardFile($role)));
}

function startUserSession($user)
{
    session_regenerate_id(true);

    $_SESSION["user_id"] = $user["id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["role"] = $user["role"];
    $_SESSION["first_name"] = $user["first_name"];
    $_SESSION["last_name"] = $user["last_name"];
}

function checkRememberLogin()
{
    if (
        !isset($_SESSION["user_id"]) &&
        isset($_COOKIE["remember_token"]) &&
        $_COOKIE["remember_token"] != ""
    ) {
        $userModel = new User();

        $user = $userModel->findByRememberToken(
            $_COOKIE["remember_token"]
        );

        if ($user) {
            startUserSession($user);
        }
    }
}

function requireLogin()
{
    checkRememberLogin();

    if (!isset($_SESSION["user_id"])) {
        setMessage(
            "error",
            "Please login first."
        );

        redirectTo(
            viewPath("login.php")
        );
    }
}

function requireRole($roles)
{
    requireLogin();

    $allowedRoles = is_array($roles)
        ? $roles
        : [$roles];

    if (!in_array($_SESSION["role"], $allowedRoles)) {

        setMessage(
            "error",
            "You are not allowed to open that page."
        );

        redirectByRole(
            $_SESSION["role"]
        );
    }
}

function validRole($role)
{
    return in_array(
        $role,
        [
            "Student",
            "Moderator",
            "Admin"
        ]
    );
}

function logoutUser()
{
    if (isset($_COOKIE["remember_token"])) {

        $userModel = new User();

        $userModel->clearRememberToken(
            $_COOKIE["remember_token"]
        );

        setcookie(
            "remember_token",
            "",
            time() - 3600,
            "/"
        );
    }

    $_SESSION = [];

    if (ini_get("session.use_cookies")) {

        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            "",
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();

    redirectTo(
        viewPath("login.php")
    );
}

function validPassword($password)
{
    if (strlen($password) < 8) {
        return false;
    }

    if (!preg_match("/[A-Z]/", $password)) {
        return false;
    }

    if (!preg_match("/[a-z]/", $password)) {
        return false;
    }

    if (!preg_match("/[0-9]/", $password)) {
        return false;
    }

    if (!preg_match("/[^A-Za-z0-9]/", $password)) {
        return false;
    }

    return true;
}

checkRememberLogin();

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["action"])
) {

    $userModel = new User();

    $action = $_POST["action"];

    if ($action == "register") {

        $required = [
            "first_name",
            "last_name",
            "email",
            "phone",
            "username",
            "password",
            "confirm_password"
        ];

        foreach ($required as $field) {

            if (
                !isset($_POST[$field]) ||
                trim($_POST[$field]) == ""
            ) {

                setMessage(
                    "error",
                    "Please fill all required fields."
                );

                redirectTo(
                    viewPath("register.php")
                );
            }
        }

        $firstName = cleanInput(
            $_POST["first_name"]
        );

        $lastName = cleanInput(
            $_POST["last_name"]
        );

        $email = cleanInput(
            $_POST["email"]
        );

        $phone = cleanInput(
            $_POST["phone"]
        );

        $username = cleanInput(
            $_POST["username"]
        );

        $password = $_POST["password"];

        $confirmPassword = $_POST["confirm_password"];

        if (!filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )) {

            setMessage(
                "error",
                "Please enter a valid email address."
            );

            redirectTo(
                viewPath("register.php")
            );
        }

        if ($userModel->emailExists($email)) {

            setMessage(
                "error",
                "Email already exists."
            );

            redirectTo(
                viewPath("register.php")
            );
        }

        if ($userModel->usernameExists($username)) {

            setMessage(
                "error",
                "Username already exists."
            );

            redirectTo(
                viewPath("register.php")
            );
        }

        if (!validPassword($password)) {

            setMessage(
                "error",
                "Password must be at least 8 characters and contain an uppercase letter, lowercase letter, number, and special character."
            );

            redirectTo(
                viewPath("register.php")
            );
        }

        if ($password !== $confirmPassword) {

            setMessage(
                "error",
                "Password and confirm password do not match."
            );

            redirectTo(
                viewPath("register.php")
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
            "role" => "Student"
        ];

        $newUserId = $userModel->create($data);

        if (!$newUserId) {

            setMessage(
                "error",
                "Registration failed. Please try again."
            );

            redirectTo(
                viewPath("register.php")
            );
        }

        setMessage(
            "success",
            "Registration successful. Please login."
        );

        redirectTo(
            viewPath("login.php")
        );
    }

    if ($action == "login") {

        $login = cleanInput(
            $_POST["login"] ?? ""
        );

        $password = $_POST["password"] ?? "";

        if (
            $login == "" ||
            $password == ""
        ) {

            setMessage(
                "error",
                "Username/email and password are required."
            );

            redirectTo(
                viewPath("login.php")
            );
        }

        $user = $userModel->findByUsernameOrEmail(
            $login
        );

        if (
            !$user ||
            !isset($user["password"]) ||
            !password_verify(
                $password,
                $user["password"]
            )
        ) {

            setMessage(
                "error",
                "Invalid login details."
            );

            redirectTo(
                viewPath("login.php")
            );
        }

        if (
            isset($user["role"]) &&
            !validRole($user["role"])
        ) {

            setMessage(
                "error",
                "Invalid user role."
            );

            redirectTo(
                viewPath("login.php")
            );
        }

        startUserSession($user);

        if (isset($_POST["remember"])) {

            $token = bin2hex(
                random_bytes(32)
            );

            $userModel->updateRememberToken(
                $user["id"],
                $token
            );

            setcookie(
                "remember_token",
                $token,
                [
                    "expires" => time() + (7 * 24 * 60 * 60),
                    "path" => "/",
                    "httponly" => true,
                    "samesite" => "Lax"
                ]
            );
        }

        redirectByRole(
            $user["role"]
        );
    }

    if ($action == "reset_password") {

        $login = cleanInput(
            $_POST["login"] ?? ""
        );

        $password = $_POST["password"] ?? "";

        $confirmPassword = $_POST["confirm_password"] ?? "";

        if (
            $login == "" ||
            $password == "" ||
            $confirmPassword == ""
        ) {

            setMessage(
                "error",
                "All fields are required."
            );

            redirectTo(
                viewPath("forgot-password.php")
            );
        }

        if (!validPassword($password)) {

            setMessage(
                "error",
                "Password must be at least 8 characters and contain an uppercase letter, lowercase letter, number, and special character."
            );

            redirectTo(
                viewPath("forgot-password.php")
            );
        }

        if ($password !== $confirmPassword) {

            setMessage(
                "error",
                "Passwords do not match."
            );

            redirectTo(
                viewPath("forgot-password.php")
            );
        }

        $user = $userModel->findByUsernameOrEmail(
            $login
        );

        if (!$user) {

            setMessage(
                "error",
                "No user found with that username or email."
            );

            redirectTo(
                viewPath("forgot-password.php")
            );
        }

        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        if (
            !$userModel->updatePassword(
                $user["id"],
                $passwordHash
            )
        ) {

            setMessage(
                "error",
                "Password update failed."
            );

            redirectTo(
                viewPath("forgot-password.php")
            );
        }

        setMessage(
            "success",
            "Password changed. Please login."
        );

        redirectTo(
            viewPath("login.php")
        );
    }
}

?>
