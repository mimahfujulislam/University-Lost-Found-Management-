<?php
require_once __DIR__ . "/../Controller/ItemController.php";
require_once __DIR__ . "/../Controller/CategoryController.php";
requireRole("Admin");
$items = getAllItems();
$categories = getAllCategories();
$pageTitle = "Manage Items";
include __DIR__ . "/header.php";
?>

<h1>Manage Items</h1>

<form method="post" action="../Controller/ItemController.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="admin_add_item">
    <fieldset>
        <legend>Add Item</legend>
        <table>
            <tr>
                <td>Lost / Found</td>
                <td>
                    <select name="type" data-required="yes">
                        <option value="Lost">Lost</option>
                        <option value="Found">Found</option>
                    </select>
                </td>
            </tr>
            <tr><td>Item Name</td><td><input type="text" name="item_name" data-required="yes"></td></tr>
            <tr>
                <td>Category</td>
                <td>
                    <select name="category_id" data-required="yes">
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo e($category["id"]); ?>"><?php echo e($category["name"]); ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr><td>Description</td><td><textarea name="description" data-required="yes"></textarea></td></tr>
            <tr><td>Date</td><td><input type="date" name="item_date" data-required="yes"></td></tr>
            <tr><td>Location</td><td><input type="text" name="location" data-required="yes"></td></tr>
            <tr><td>Upload Image</td><td><input type="file" name="image" accept="image/*"></td></tr>
            <tr>
                <td>Status</td>
                <td>
                    <select name="status">
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Found/Returned">Found/Returned</option>
                    </select>
                </td>
            </tr>
            <tr><td></td><td><button type="submit">Add Item</button></td></tr>
        </table>
    </fieldset>
</form>

<form method="post" action="../Controller/ItemController.php">
    <input type="hidden" name="action" value="admin_update_item">
    <fieldset>
        <legend>Edit Item By ID</legend>
        <table>
            <tr><td>Item ID</td><td><input type="number" name="item_id" data-required="yes"></td></tr>
            <tr>
                <td>Lost / Found</td>
                <td>
                    <select name="type" data-required="yes">
                        <option value="Lost">Lost</option>
                        <option value="Found">Found</option>
                    </select>
                </td>
            </tr>
            <tr><td>Item Name</td><td><input type="text" name="item_name" data-required="yes"></td></tr>
            <tr>
                <td>Category</td>
                <td>
                    <select name="category_id" data-required="yes">
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo e($category["id"]); ?>"><?php echo e($category["name"]); ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr><td>Description</td><td><textarea name="description" data-required="yes"></textarea></td></tr>
            <tr><td>Date</td><td><input type="date" name="item_date" data-required="yes"></td></tr>
            <tr><td>Location</td><td><input type="text" name="location" data-required="yes"></td></tr>
            <tr>
                <td>Status</td>
                <td>
                    <select name="status" data-required="yes">
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Found/Returned">Found/Returned</option>
                    </select>
                </td>
            </tr>
            <tr><td></td><td><button type="submit">Update Item</button></td></tr>
        </table>
    </fieldset>
</form>

<h2>All Items</h2>
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
        <th>Status</th>
        <th>Reported By</th>
        <th>Delete</th>
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
            <td><?php echo e($item["status"]); ?></td>
            <td><?php echo e($item["username"]); ?></td>
            <td>
                <form method="post" action="../Controller/ItemController.php">
                    <input type="hidden" name="action" value="admin_delete_item">
                    <input type="hidden" name="item_id" value="<?php echo e($item["id"]); ?>">
                    <button class="danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    <?php if (count($items) == 0) { ?>
        <tr><td colspan="11">No items found.</td></tr>
    <?php } ?>
</table>

<?php include __DIR__ . "/footer.php"; ?>
