<?php
require_once __DIR__ . "/../Controller/AuthController.php";
$pageTitle = "Register";
include __DIR__ . "/header.php";
?>

<h1>Student Registration</h1>

<form id="registerForm" method="post" action="../Controller/AuthController.php">
    <input type="hidden" name="action" value="register">

    <fieldset>
        <legend>Basic Information</legend>
        <table>
            <tr><td>First Name</td><td><input type="text" name="first_name" data-required="yes"></td></tr>
            <tr><td>Last Name</td><td><input type="text" name="last_name" data-required="yes"></td></tr>
            <tr><td>Email</td><td><input type="email" name="email" data-required="yes"></td></tr>
            <tr><td>Phone</td><td><input type="text" name="phone" data-required="yes"></td></tr>
            <tr><td>Username</td><td><input type="text" name="username" data-required="yes"></td></tr>
            <tr><td>Password</td><td><input type="password" name="password" data-required="yes"></td></tr>
            <tr><td>Confirm Password</td><td><input type="password" name="confirm_password" data-required="yes"></td></tr>
            <tr><td></td><td><button type="submit">Register</button></td></tr>
        </table>
    </fieldset>
</form>

<?php include __DIR__ . "/footer.php"; ?>
