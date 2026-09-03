<?php
require_once __DIR__ . "/../Controller/StudentController.php";
requireRole("Student");
$student = getStudentProfile($_SESSION["user_id"]);
$pageTitle = "Student Profile";
include __DIR__ . "/header.php";
?>

<h1>Student Profile</h1>

<form method="post" action="../Controller/StudentController.php">
    <input type="hidden" name="action" value="update_profile">

    <fieldset>
        <legend>Profile Information</legend>
        <table>
            <tr><td>Full Name</td><td><?php echo e($student["first_name"] . " " . $student["last_name"]); ?></td></tr>
            <tr><td>Student ID</td><td><input type="text" value="<?php echo e($student["student_id"]); ?>" readonly></td></tr>
            <tr><td>Role</td><td><input type="text" value="<?php echo e($student["role"]); ?>" readonly></td></tr>
            <tr><td>First Name</td><td><input type="text" name="first_name" value="<?php echo e($student["first_name"]); ?>" data-required="yes"></td></tr>
            <tr><td>Last Name</td><td><input type="text" name="last_name" value="<?php echo e($student["last_name"]); ?>" data-required="yes"></td></tr>
            <tr><td>Email</td><td><input type="email" name="email" value="<?php echo e($student["email"]); ?>" data-required="yes"></td></tr>
            <tr><td>Phone</td><td><input type="text" name="phone" value="<?php echo e($student["phone"]); ?>" data-required="yes"></td></tr>
            <tr><td>Country</td><td><input type="text" name="country" value="<?php echo e($student["country"]); ?>" data-required="yes"></td></tr>
            <tr><td>City</td><td><input type="text" name="city" value="<?php echo e($student["city"]); ?>" data-required="yes"></td></tr>
            <tr><td>Address</td><td><textarea name="address" data-required="yes"><?php echo e($student["address"]); ?></textarea></td></tr>
            <tr><td>Post Code</td><td><input type="text" name="post_code" value="<?php echo e($student["post_code"]); ?>" data-required="yes"></td></tr>
            <tr><td></td><td><button type="submit">Update Profile</button></td></tr>
        </table>
    </fieldset>
</form>

<?php include __DIR__ . "/footer.php"; ?>
