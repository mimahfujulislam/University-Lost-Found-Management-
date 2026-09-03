<?php
require_once __DIR__ . "/../Controller/ItemController.php";
requireRole("Moderator");
$items = getAllItems();
$pageTitle = "Item Status";
include __DIR__ . "/header.php";
?>

<h1>Update Item Status</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Item</th>
        <th>Type</th>
        <th>Category</th>
        <th>Location</th>
        <th>Status</th>
        <th>Update</th>
    </tr>
    <?php foreach ($items as $item) { ?>
        <tr>
            <td><?php echo e($item["id"]); ?></td>
            <td><?php echo e($item["item_name"]); ?></td>
            <td><?php echo e($item["type"]); ?></td>
            <td><?php echo e($item["category_name"]); ?></td>
            <td><?php echo e($item["location"]); ?></td>
            <td><?php echo e($item["status"]); ?></td>
            <td>
                <form class="small-form" method="post" action="../Controller/ItemController.php">
                    <input type="hidden" name="action" value="update_item_status">
                    <input type="hidden" name="item_id" value="<?php echo e($item["id"]); ?>">
                    <select name="status">
                        <option value="Pending" <?php if ($item["status"] == "Pending") echo "selected"; ?>>Pending</option>
                        <option value="Approved" <?php if ($item["status"] == "Approved") echo "selected"; ?>>Approved</option>
                        <option value="Rejected" <?php if ($item["status"] == "Rejected") echo "selected"; ?>>Rejected</option>
                        <option value="Found/Returned" <?php if ($item["status"] == "Found/Returned") echo "selected"; ?>>Found/Returned</option>
                    </select>
                    <button type="submit">Save</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    <?php if (count($items) == 0) { ?>
        <tr><td colspan="7">No items found.</td></tr>
    <?php } ?>
</table>

<?php include __DIR__ . "/footer.php"; ?>
