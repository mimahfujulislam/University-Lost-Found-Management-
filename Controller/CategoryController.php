<?php
require_once __DIR__ . "/AuthController.php";
require_once __DIR__ . "/../Model/Category.php";

function getAllCategories()
{
    $categoryModel = new Category();
    return $categoryModel->getAll();
}

function validCategory($categoryId)
{
    $categoryModel = new Category();
    return $categoryModel->findById($categoryId) ? true : false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    $action = $_POST["action"];

    if ($action == "add_category") {
        requireRole("Admin");

        $name = cleanInput($_POST["name"] ?? "");
        $categoryModel = new Category();

        if ($name == "") {
            setMessage("error", "Category name is required.");
            redirectTo(viewPath("admin-categories.php"));
        }

        if ($categoryModel->nameExists($name)) {
            setMessage("error", "Category already exists.");
            redirectTo(viewPath("admin-categories.php"));
        }

        $categoryModel->create($name);
        setMessage("success", "Category added.");
        redirectTo(viewPath("admin-categories.php"));
    }

    if ($action == "update_category") {
        requireRole("Admin");

        $id = (int) ($_POST["id"] ?? 0);
        $name = cleanInput($_POST["name"] ?? "");
        $categoryModel = new Category();

        if ($name == "") {
            setMessage("error", "Category name is required.");
            redirectTo(viewPath("admin-categories.php"));
        }

        if ($categoryModel->nameExists($name, $id)) {
            setMessage("error", "Category already exists.");
            redirectTo(viewPath("admin-categories.php"));
        }

        $categoryModel->update($id, $name);
        setMessage("success", "Category updated.");
        redirectTo(viewPath("admin-categories.php"));
    }

    if ($action == "delete_category") {
        requireRole("Admin");

        $id = (int) ($_POST["id"] ?? 0);
        $categoryModel = new Category();
        $categoryModel->delete($id);
        setMessage("success", "Category deleted.");
        redirectTo(viewPath("admin-categories.php"));
    }
}
?>
