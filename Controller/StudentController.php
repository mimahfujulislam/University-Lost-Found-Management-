<?php

require_once __DIR__ . "/AuthController.php";
require_once __DIR__ . "/../Model/User.php";
require_once __DIR__ . "/../Model/Item.php";
require_once __DIR__ . "/../Model/Claim.php";

function getStudentDashboardData($userId)
{
    $itemModel = new Item();
    $claimModel = new Claim();

    return [
        "total_reported" => $itemModel->countByUser($userId),
        "lost_items" => $itemModel->countByUserAndType($userId, "Lost"),
        "found_items" => $itemModel->countByUserAndType($userId, "Found"),
        "my_claims" => $claimModel->countByUser($userId),
        "recent_items" => $itemModel->getRecentApproved(5)
    ];
}

function getStudentProfile($userId)
{
    $userModel = new User();

    return $userModel->findById($userId);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {

    $action = $_POST["action"];

    if ($action == "update_profile") {

        requireRole("Student");

        $required = [
            "first_name",
            "last_name",
            "email",
            "phone"
        ];

        foreach ($required as $field) {

            if (cleanInput($_POST[$field] ?? "") == "") {

                setMessage(
                    "error",
                    "Please fill all required fields."
                );

                redirectTo(
                    viewPath("student-profile.php")
                );
            }
        }

        $firstName = cleanInput($_POST["first_name"]);
        $lastName = cleanInput($_POST["last_name"]);
        $email = cleanInput($_POST["email"]);
        $phone = cleanInput($_POST["phone"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            setMessage(
                "error",
                "Please enter a valid email address."
            );

            redirectTo(
                viewPath("student-profile.php")
            );
        }

        $userModel = new User();

        if (
            $userModel->emailExists(
                $email,
                $_SESSION["user_id"]
            )
        ) {

            setMessage(
                "error",
                "Email already exists."
            );

            redirectTo(
                viewPath("student-profile.php")
            );
        }

        $data = [
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email,
            "phone" => $phone
        ];

        if (
            !$userModel->updateProfile(
                $_SESSION["user_id"],
                $data
            )
        ) {

            setMessage(
                "error",
                "Profile update failed."
            );

            redirectTo(
                viewPath("student-profile.php")
            );
        }

        $_SESSION["first_name"] = $firstName;
        $_SESSION["last_name"] = $lastName;

        setMessage(
            "success",
            "Profile updated successfully."
        );

        redirectTo(
            viewPath("student-profile.php")
        );
    }

    if ($action == "change_password") {

        requireRole("Student");

        $currentPassword = $_POST["current_password"] ?? "";
        $newPassword = $_POST["new_password"] ?? "";
        $confirmPassword = $_POST["confirm_password"] ?? "";

        if (
            $currentPassword == "" ||
            $newPassword == "" ||
            $confirmPassword == ""
        ) {

            setMessage(
                "error",
                "All password fields are required."
            );

            redirectTo(
                viewPath("student-change-password.php")
            );
        }

        if (strlen($newPassword) < 8) {

            setMessage(
                "error",
                "New password must be at least 8 characters."
            );

            redirectTo(
                viewPath("student-change-password.php")
            );
        }

        if ($newPassword !== $confirmPassword) {

            setMessage(
                "error",
                "New password and confirm password do not match."
            );

            redirectTo(
                viewPath("student-change-password.php")
            );
        }

        if ($currentPassword === $newPassword) {

            setMessage(
                "error",
                "New password must be different from current password."
            );

            redirectTo(
                viewPath("student-change-password.php")
            );
        }

        $userModel = new User();

        $user = $userModel->findById(
            $_SESSION["user_id"]
        );

        if (
            !$user ||
            !isset($user["password"]) ||
            !password_verify(
                $currentPassword,
                $user["password"]
            )
        ) {

            setMessage(
                "error",
                "Current password is incorrect."
            );

            redirectTo(
                viewPath("student-change-password.php")
            );
        }

        $passwordHash = password_hash(
            $newPassword,
            PASSWORD_DEFAULT
        );

        if (
            !$userModel->updatePassword(
                $_SESSION["user_id"],
                $passwordHash
            )
        ) {

            setMessage(
                "error",
                "Password change failed."
            );

            redirectTo(
                viewPath("student-change-password.php")
            );
        }

        setMessage(
            "success",
            "Password changed successfully."
        );

        redirectTo(
            viewPath("student-change-password.php")
        );
    }
}

?>