<?php
require_once __DIR__ . "/../Controller/AdminController.php";
requireRole("Admin");
$data = getAdminDashboardData();
$pageTitle = "Admin Dashboard";
include __DIR__ . "/header.php";
?>

<h1>Admin Dashboard</h1>

<div class="stats">
    <div class="stat-box"><span class="stat-number"><?php echo e($data["total_users"]); ?></span>Total Users</div>
    <div class="stat-box"><span class="stat-number"><?php echo e($data["students"]); ?></span>Students</div>
    <div class="stat-box"><span class="stat-number"><?php echo e($data["moderators"]); ?></span>Moderators</div>
    <div class="stat-box"><span class="stat-number"><?php echo e($data["items"]); ?></span>Items</div>
    <div class="stat-box"><span class="stat-number"><?php echo e($data["claims"]); ?></span>Claims</div>
    <div class="stat-box"><span class="stat-number"><?php echo e($data["categories"]); ?></span>Categories</div>
</div>

<?php include __DIR__ . "/footer.php"; ?>
