<?php
require_once __DIR__ . "/../Controller/AdminController.php";
requireRole("Admin");
$users = getAllUsersForAdmin();
$pageTitle = "Manage Users";
include __DIR__ . "/header.php";
?>

<h1>Manage Users</h1>

<form method="post" action="../Controller/AdminController.php">
    <input type="hidden" name="action" value="add_user">
    <fieldset>
        <legend>Add User</legend>
        <table>
            <tr><td>First Name</td><td><input type="text" name="first_name" data-required="yes"></td></tr>
            <tr><td>Last Name</td><td><input type="text" name="last_name" data-required="yes"></td></tr>
            <tr><td>Email</td><td><input type="email" name="email" data-required="yes"></td></tr>
            <tr><td>Phone</td><td><input type="text" name="phone" data-required="yes"></td></tr>
            <tr><td>Username</td><td><input type="text" name="username" data-required="yes"></td></tr>
            <tr><td>Password</td><td><input type="password" name="password" data-required="yes"></td></tr>
            <tr>
                <td>Role</td>
                <td>
                    <select name="role" data-required="yes">
                        <option value="Student">Student</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Admin">Admin</option>
                    </select>
                </td>
            </tr>
            <tr><td></td><td><button type="submit">Add User</button></td></tr>
        </table>
    </fieldset>
</form>

<form method="post" action="../Controller/AdminController.php">
    <input type="hidden" name="action" value="update_user">
    <fieldset>
        <legend>Edit User By ID</legend>
        <table>
            <tr><td>User ID</td><td><input type="number" name="id" data-required="yes"></td></tr>
            <tr><td>First Name</td><td><input type="text" name="first_name" data-required="yes"></td></tr>
            <tr><td>Last Name</td><td><input type="text" name="last_name" data-required="yes"></td></tr>
            <tr><td>Email</td><td><input type="email" name="email" data-required="yes"></td></tr>
            <tr><td>Phone</td><td><input type="text" name="phone" data-required="yes"></td></tr>
            <tr><td>Username</td><td><input type="text" name="username" data-required="yes"></td></tr>
            <tr>
                <td>Role</td>
                <td>
                    <select name="role" data-required="yes">
                        <option value="Student">Student</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Admin">Admin</option>
                    </select>
                </td>
            </tr>
            <tr><td></td><td><button type="submit">Update User</button></td></tr>
        </table>
    </fieldset>
</form>

<h2>All Users</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Student ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Username</th>
        <th>Role</th>
        <th>Delete</th>
    </tr>
    <?php foreach ($users as $user) { ?>
        <tr>
            <td><?php echo e($user["id"]); ?></td>
            <td><?php echo e($user["student_id"]); ?></td>
            <td><?php echo e($user["first_name"] . " " . $user["last_name"]); ?></td>
            <td><?php echo e($user["email"]); ?></td>
            <td><?php echo e($user["phone"]); ?></td>
            <td><?php echo e($user["username"]); ?></td>
            <td><?php echo e($user["role"]); ?></td>
            <td>
                <form method="post" action="../Controller/AdminController.php">
                    <input type="hidden" name="action" value="delete_user">
                    <input type="hidden" name="id" value="<?php echo e($user["id"]); ?>">
                    <button class="danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include __DIR__ . "/footer.php"; ?>
