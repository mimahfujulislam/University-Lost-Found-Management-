<?php
require_once __DIR__ . "/../Controller/StudentController.php";
requireRole("Student");
$data = getStudentDashboardData($_SESSION["user_id"]);
$pageTitle = "Student Dashboard";
include __DIR__ . "/header.php";
?>

<h1>Welcome Student</h1>

<div class="stats">
    <div class="stat-box"><span class="stat-number"><?php echo e($data["total_reported"]); ?></span>Total Reported Items</div>
    <div class="stat-box"><span class="stat-number"><?php echo e($data["lost_items"]); ?></span>My Lost Items</div>
    <div class="stat-box"><span class="stat-number"><?php echo e($data["found_items"]); ?></span>My Found Items</div>
    <div class="stat-box"><span class="stat-number"><?php echo e($data["my_claims"]); ?></span>My Claims</div>
</div>

<h2>Recent Items</h2>
<table>
    <tr>
        <th>Item</th>
        <th>Type</th>
        <th>Category</th>
        <th>Location</th>
        <th>Date</th>
    </tr>
    <?php foreach ($data["recent_items"] as $item) { ?>
        <tr>
            <td><?php echo e($item["item_name"]); ?></td>
            <td><?php echo e($item["type"]); ?></td>
            <td><?php echo e($item["category_name"]); ?></td>
            <td><?php echo e($item["location"]); ?></td>
            <td><?php echo e($item["item_date"]); ?></td>
        </tr>
    <?php } ?>
    <?php if (count($data["recent_items"]) == 0) { ?>
        <tr><td colspan="5">No approved items yet.</td></tr>
    <?php } ?>
</table>

<?php include __DIR__ . "/footer.php"; ?>
