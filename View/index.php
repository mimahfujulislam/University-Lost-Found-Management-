<?php
require_once __DIR__ . "/../Controller/AuthController.php";
$pageTitle = "Home";
include __DIR__ . "/header.php";
?>

<h1>University Lost & Found Management System</h1>

<fieldset>
    <legend>Welcome</legend>
    <p>This system helps students report lost or found items, search approved items, and submit claims.</p>

    <?php if (isset($_SESSION["user_id"])) { ?>
        <p>You are logged in as <strong><?php echo e($_SESSION["username"]); ?></strong>.</p>
        <a class="button" href="<?php echo e(dashboardFile($_SESSION["role"])); ?>">Go to Dashboard</a>
    <?php } else { ?>
        <a class="button" href="login.php">Login</a>
        <a class="button" href="register.php">Register</a>
    <?php } ?>
</fieldset>

<?php include __DIR__ . "/footer.php"; ?>
