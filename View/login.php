<?php
require_once __DIR__ . "/../Controller/AuthController.php";
if (isset($_SESSION["user_id"])) {
    redirectByRole($_SESSION["role"]);
}
$pageTitle = "Login";
include __DIR__ . "/header.php";
?>

<h1>Login</h1>

<form method="post" action="../Controller/AuthController.php">
    <input type="hidden" name="action" value="login">

    <fieldset>
        <legend>Login Form</legend>
        <table>
            <tr>
                <td>Username or Email</td>
                <td><input type="text" name="login" data-required="yes"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" data-required="yes"></td>
            </tr>
            <tr>
                <td>Remember Me</td>
                <td><input class="check-input" type="checkbox" name="remember" value="1"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit">Login</button>
                    <a href="forgot-password.php">Forgot Password?</a>
                </td>
            </tr>
        </table>
    </fieldset>
</form>

<?php include __DIR__ . "/footer.php"; ?>
