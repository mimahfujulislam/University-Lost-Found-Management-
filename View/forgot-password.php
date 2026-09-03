<?php
require_once __DIR__ . "/../Controller/AuthController.php";
$pageTitle = "Forgot Password";
include __DIR__ . "/header.php";
?>

<h1>Forgot Password</h1>

<form id="forgotForm" method="post" action="../Controller/AuthController.php">
    <input type="hidden" name="action" value="reset_password">

    <fieldset>
        <legend>Reset Password</legend>
        <table>
            <tr>
                <td>Username or Email</td>
                <td><input type="text" name="login" data-required="yes"></td>
            </tr>
            <tr>
                <td>New Password</td>
                <td><input type="password" name="password" data-required="yes"></td>
            </tr>
            <tr>
                <td>Confirm Password</td>
                <td><input type="password" name="confirm_password" data-required="yes"></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Change Password</button></td>
            </tr>
        </table>
    </fieldset>
</form>

<?php include __DIR__ . "/footer.php"; ?>
