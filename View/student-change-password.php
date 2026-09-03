<?php
require_once __DIR__ . "/../Controller/StudentController.php";
requireRole("Student");
$pageTitle = "Change Password";
include __DIR__ . "/header.php";
?>

<h1>Change Password</h1>

<form id="changePasswordForm" method="post" action="../Controller/StudentController.php">
    <input type="hidden" name="action" value="change_password">

    <fieldset>
        <legend>Password Form</legend>
        <table>
            <tr><td>Current Password</td><td><input type="password" name="current_password" data-required="yes"></td></tr>
            <tr><td>New Password</td><td><input type="password" name="new_password" data-required="yes"></td></tr>
            <tr><td>Confirm Password</td><td><input type="password" name="confirm_password" data-required="yes"></td></tr>
            <tr><td></td><td><button type="submit">Change Password</button></td></tr>
        </table>
    </fieldset>
</form>

<?php include __DIR__ . "/footer.php"; ?>
