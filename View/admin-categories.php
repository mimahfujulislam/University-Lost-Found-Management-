<?php
require_once __DIR__ . "/../Controller/CategoryController.php";
requireRole("Admin");
$categories = getAllCategories();
$pageTitle = "Manage Categories";
include __DIR__ . "/header.php";
?>

<h1>Manage Categories</h1>

<form method="post" action="../Controller/CategoryController.php">
    <input type="hidden" name="action" value="add_category">
    <fieldset>
        <legend>Add Category</legend>
        <table>
            <tr><td>Category Name</td><td><input type="text" name="name" data-required="yes"></td></tr>
            <tr><td></td><td><button type="submit">Add Category</button></td></tr>
        </table>
    </fieldset>
</form>

<form method="post" action="../Controller/CategoryController.php">
    <input type="hidden" name="action" value="update_category">
    <fieldset>
        <legend>Edit Category By ID</legend>
        <table>
            <tr><td>Category ID</td><td><input type="number" name="id" data-required="yes"></td></tr>
            <tr><td>Category Name</td><td><input type="text" name="name" data-required="yes"></td></tr>
            <tr><td></td><td><button type="submit">Update Category</button></td></tr>
        </table>
    </fieldset>
</form>

<h2>All Categories</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Delete</th>
    </tr>
    <?php foreach ($categories as $category) { ?>
        <tr>
            <td><?php echo e($category["id"]); ?></td>
            <td><?php echo e($category["name"]); ?></td>
            <td>
                <form method="post" action="../Controller/CategoryController.php">
                    <input type="hidden" name="action" value="delete_category">
                    <input type="hidden" name="id" value="<?php echo e($category["id"]); ?>">
                    <button class="danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    <?php if (count($categories) == 0) { ?>
        <tr><td colspan="3">No categories found.</td></tr>
    <?php } ?>
</table>

<?php include __DIR__ . "/footer.php"; ?>
