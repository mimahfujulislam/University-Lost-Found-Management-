<?php
require_once __DIR__ . "/../Controller/CategoryController.php";
requireRole("Student");
$categories = getAllCategories();
$pageTitle = "Search Items";
include __DIR__ . "/header.php";
?>

<h1>Search Items</h1>

<form id="searchForm">
    <input type="hidden" name="action" value="search_items">

    <fieldset>
        <legend>Search Form</legend>
        <table>
            <tr><td>Item Name</td><td><input type="text" name="item_name"></td></tr>
            <tr>
                <td>Type</td>
                <td>
                    <select name="type">
                        <option value="">Any</option>
                        <option value="Lost">Lost</option>
                        <option value="Found">Found</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Category</td>
                <td>
                    <select name="category_id">
                        <option value="">Any</option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo e($category["id"]); ?>"><?php echo e($category["name"]); ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr><td>Location</td><td><input type="text" name="location"></td></tr>
            <tr><td>Date</td><td><input type="date" name="item_date"></td></tr>
            <tr><td></td><td><button type="submit">Search</button></td></tr>
        </table>
    </fieldset>
</form>

<h2>Search Results</h2>
<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Type</th>
            <th>Category</th>
            <th>Location</th>
            <th>Date</th>
            <th>Status</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody id="searchResults">
        <tr><td colspan="7">Use the search form above.</td></tr>
    </tbody>
</table>

<?php include __DIR__ . "/footer.php"; ?>
