<?php
require_once __DIR__ . "/../Controller/CategoryController.php";
requireRole("Student");
$categories = getAllCategories();
$pageTitle = "Report Item";
include __DIR__ . "/header.php";
?>

<h1>Report Lost or Found Item</h1>

<form id="reportItemForm" method="post" action="../Controller/ItemController.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="report_item">

    <fieldset>
        <legend>Item Information</legend>
        <table>
            <tr>
                <td>Lost / Found</td>
                <td>
                    <select name="type" data-required="yes">
                        <option value="">Select</option>
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
                        <option value="">Select</option>
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
            <tr><td></td><td><button type="submit">Submit Item</button></td></tr>
        </table>
    </fieldset>
</form>

<?php include __DIR__ . "/footer.php"; ?>
