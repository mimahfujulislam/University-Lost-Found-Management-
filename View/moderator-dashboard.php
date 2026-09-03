<?php
require_once __DIR__ . "/../Controller/ModeratorController.php";
requireRole("Moderator");
$data = getModeratorDashboardData();
$pageTitle = "Moderator Dashboard";
include __DIR__ . "/header.php";
?>

<h1>Moderator Dashboard</h1>

<div class="stats">
    <div class="stat-box"><span class="stat-number"><?php echo e($data["pending_items"]); ?></span>Pending Items</div>
    <div class="stat-box"><span class="stat-number"><?php echo e($data["pending_claims"]); ?></span>Pending Claims</div>
    <div class="stat-box"><span class="stat-number"><?php echo e($data["total_items"]); ?></span>Total Items</div>
</div>

<h2>Recently Reviewed Items</h2>
<table>
    <tr>
        <th>Item</th>
        <th>Type</th>
        <th>Category</th>
        <th>Status</th>
        <th>Updated</th>
    </tr>
    <?php foreach ($data["recently_reviewed"] as $item) { ?>
        <tr>
            <td><?php echo e($item["item_name"]); ?></td>
            <td><?php echo e($item["type"]); ?></td>
            <td><?php echo e($item["category_name"]); ?></td>
            <td><?php echo e($item["status"]); ?></td>
            <td><?php echo e($item["updated_at"]); ?></td>
        </tr>
    <?php } ?>
    <?php if (count($data["recently_reviewed"]) == 0) { ?>
        <tr><td colspan="5">No reviewed items yet.</td></tr>
    <?php } ?>
</table>

<?php include __DIR__ . "/footer.php"; ?>
