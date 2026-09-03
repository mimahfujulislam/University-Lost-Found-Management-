<?php
require_once __DIR__ . "/../Controller/ItemController.php";
requireRole("Moderator");
$items = getPendingItems();
$pageTitle = "Review Items";
include __DIR__ . "/header.php";
?>

<h1>Review Items</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Item</th>
        <th>Type</th>
        <th>Category</th>
        <th>Description</th>
        <th>Date</th>
        <th>Location</th>
        <th>Reported By</th>
        <th>Action</th>
    </tr>
    <?php foreach ($items as $item) { ?>
        <tr>
            <td><?php echo e($item["id"]); ?></td>
            <td>
                <?php if ($item["image"] != "") { ?>
                    <img class="item-image" src="../images/uploads/<?php echo e($item["image"]); ?>" alt="Item image">
                <?php } else { ?>
                    No image
                <?php } ?>
            </td>
            <td><?php echo e($item["item_name"]); ?></td>
            <td><?php echo e($item["type"]); ?></td>
            <td><?php echo e($item["category_name"]); ?></td>
            <td><?php echo e($item["description"]); ?></td>
            <td><?php echo e($item["item_date"]); ?></td>
            <td><?php echo e($item["location"]); ?></td>
            <td><?php echo e($item["username"]); ?></td>
            <td>
                <form method="post" action="../Controller/ItemController.php">
                    <input type="hidden" name="action" value="review_item">
                    <input type="hidden" name="item_id" value="<?php echo e($item["id"]); ?>">
                    <button type="submit" name="status" value="Approved">Approve</button>
                    <button class="danger" type="submit" name="status" value="Rejected">Reject</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    <?php if (count($items) == 0) { ?>
        <tr><td colspan="10">No pending items.</td></tr>
    <?php } ?>
</table>

<?php include __DIR__ . "/footer.php"; ?>
