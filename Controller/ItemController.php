<?php

require_once __DIR__ . "/AuthController.php";
require_once __DIR__ . "/../Model/Item.php";
require_once __DIR__ . "/../Model/Category.php";

function validItemType($type)
{
    return in_array($type, ["Lost", "Found"]);
}

function validItemStatus($status)
{
    return in_array(
        $status,
        ["Pending", "Approved", "Rejected", "Found/Returned"]
    );
}

function getAllItems()
{
    $itemModel = new Item();
    return $itemModel->getAllWithDetails();
}

function getPendingItems()
{
    $itemModel = new Item();
    return $itemModel->getPending();
}

function getApprovedItems()
{
    $itemModel = new Item();
    return $itemModel->search([]);
}

function saveUploadedImage()
{
    if (
        !isset($_FILES["image"]) ||
        $_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE
    ) {
        return "";
    }

    if ($_FILES["image"]["error"] != UPLOAD_ERR_OK) {
        return false;
    }

    if ($_FILES["image"]["size"] > 5 * 1024 * 1024) {
        return false;
    }

    $allowedTypes = [
        "image/jpeg",
        "image/png",
        "image/gif"
    ];

    $fileType = mime_content_type(
        $_FILES["image"]["tmp_name"]
    );

    if (!in_array($fileType, $allowedTypes)) {
        return false;
    }

    $imageInfo = getimagesize(
        $_FILES["image"]["tmp_name"]
    );

    if ($imageInfo === false) {
        return false;
    }

    $width = $imageInfo[0];
    $height = $imageInfo[1];

    $maxWidth = 600;
    $maxHeight = 600;

    $ratio = min(
        $maxWidth / $width,
        $maxHeight / $height,
        1
    );

    $newWidth = (int) ($width * $ratio);
    $newHeight = (int) ($height * $ratio);

    if ($fileType == "image/jpeg") {
        $source = imagecreatefromjpeg(
            $_FILES["image"]["tmp_name"]
        );
    } elseif ($fileType == "image/png") {
        $source = imagecreatefrompng(
            $_FILES["image"]["tmp_name"]
        );
    } elseif ($fileType == "image/gif") {
        $source = imagecreatefromgif(
            $_FILES["image"]["tmp_name"]
        );
    } else {
        return false;
    }

    if (!$source) {
        return false;
    }

    $newImage = imagecreatetruecolor(
        $newWidth,
        $newHeight
    );

    imagecopyresampled(
        $newImage,
        $source,
        0,
        0,
        0,
        0,
        $newWidth,
        $newHeight,
        $width,
        $height
    );

    $uploadDirectory = __DIR__ . "/../images/uploads/";

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $newName = time() . "_" . rand(1000, 9999) . ".jpg";

    $uploadPath = $uploadDirectory . $newName;

    $saved = imagejpeg(
        $newImage,
        $uploadPath,
        65
    );

    imagedestroy($source);
    imagedestroy($newImage);

    if ($saved) {
        return $newName;
    }

    return false;
}

function basicItemValidation($redirectPage)
{
    $required = [
        "type",
        "item_name",
        "category_id",
        "description",
        "item_date",
        "location"
    ];

    foreach ($required as $field) {
        if (cleanInput($_POST[$field] ?? "") == "") {
            setMessage(
                "error",
                "Please fill all required item fields."
            );

            redirectTo(viewPath($redirectPage));
        }
    }

    $type = cleanInput($_POST["type"]);
    $categoryId = (int) $_POST["category_id"];

    if (!validItemType($type)) {
        setMessage(
            "error",
            "Please select a valid item type."
        );

        redirectTo(viewPath($redirectPage));
    }

    $categoryModel = new Category();

    if (!$categoryModel->findById($categoryId)) {
        setMessage(
            "error",
            "Please select a valid category."
        );

        redirectTo(viewPath($redirectPage));
    }
}

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["action"])
) {
    $action = $_POST["action"];
    $itemModel = new Item();

    if ($action == "search_items") {
        header("Content-Type: application/json");

        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] != "Student"
        ) {
            echo json_encode([
                "success" => false,
                "message" => "Please login as a student."
            ]);

            exit();
        }

        $type = cleanInput($_POST["type"] ?? "");

        if ($type != "" && !validItemType($type)) {
            echo json_encode([
                "success" => false,
                "message" => "Invalid item type."
            ]);

            exit();
        }

        $categoryId = cleanInput(
            $_POST["category_id"] ?? ""
        );

        if ($categoryId != "") {
            $categoryModel = new Category();

            if (
                !$categoryModel->findById(
                    (int) $categoryId
                )
            ) {
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid category."
                ]);

                exit();
            }
        }

        $results = $itemModel->search([
            "item_name" => cleanInput(
                $_POST["item_name"] ?? ""
            ),
            "type" => $type,
            "category_id" => $categoryId,
            "location" => cleanInput(
                $_POST["location"] ?? ""
            ),
            "item_date" => cleanInput(
                $_POST["item_date"] ?? ""
            )
        ]);

        echo json_encode([
            "success" => true,
            "items" => $results
        ]);

        exit();
    }

    if ($action == "report_item") {
        requireRole("Student");

        basicItemValidation(
            "student-report-item.php"
        );

        $imageName = saveUploadedImage();

        if ($imageName === false) {
            setMessage(
                "error",
                "Image must be JPG, PNG, or GIF and less than 5MB."
            );

            redirectTo(
                viewPath("student-report-item.php")
            );
        }

        $data = [
            "user_id" => $_SESSION["user_id"],
            "type" => cleanInput($_POST["type"]),
            "item_name" => cleanInput($_POST["item_name"]),
            "category_id" => (int) $_POST["category_id"],
            "description" => cleanInput($_POST["description"]),
            "item_date" => cleanInput($_POST["item_date"]),
            "location" => cleanInput($_POST["location"]),
            "image" => $imageName,
            "status" => "Pending"
        ];

        $itemModel->create($data);

        setMessage(
            "success",
            "Item reported. A moderator will review it."
        );

        redirectTo(
            viewPath("student-report-item.php")
        );
    }

    if ($action == "review_item") {
        requireRole("Moderator");

        $itemId = (int) ($_POST["item_id"] ?? 0);
        $status = cleanInput($_POST["status"] ?? "");

        if (!in_array($status, ["Approved", "Rejected"])) {
            setMessage(
                "error",
                "Invalid review status."
            );

            redirectTo(
                viewPath("moderator-review-items.php")
            );
        }

        if (!$itemModel->findById($itemId)) {
            setMessage(
                "error",
                "Item not found."
            );

            redirectTo(
                viewPath("moderator-review-items.php")
            );
        }

        $itemModel->updateStatus(
            $itemId,
            $status
        );

        setMessage(
            "success",
            "Item reviewed."
        );

        redirectTo(
            viewPath("moderator-review-items.php")
        );
    }

    if ($action == "update_item_status") {
        requireRole("Moderator");

        $itemId = (int) ($_POST["item_id"] ?? 0);
        $status = cleanInput($_POST["status"] ?? "");

        if (!validItemStatus($status)) {
            setMessage(
                "error",
                "Invalid item status."
            );

            redirectTo(
                viewPath("moderator-item-status.php")
            );
        }

        if (!$itemModel->findById($itemId)) {
            setMessage(
                "error",
                "Item not found."
            );

            redirectTo(
                viewPath("moderator-item-status.php")
            );
        }

        $itemModel->updateStatus(
            $itemId,
            $status
        );

        setMessage(
            "success",
            "Item status updated."
        );

        redirectTo(
            viewPath("moderator-item-status.php")
        );
    }

    if ($action == "admin_add_item") {
        requireRole("Admin");

        basicItemValidation(
            "admin-manage-items.php"
        );

        $status = cleanInput(
            $_POST["status"] ?? "Pending"
        );

        if (!validItemStatus($status)) {
            setMessage(
                "error",
                "Invalid item status."
            );

            redirectTo(
                viewPath("admin-manage-items.php")
            );
        }

        $imageName = saveUploadedImage();

        if ($imageName === false) {
            setMessage(
                "error",
                "Image must be JPG, PNG, or GIF and less than 5MB."
            );

            redirectTo(
                viewPath("admin-manage-items.php")
            );
        }

        $data = [
            "user_id" => $_SESSION["user_id"],
            "type" => cleanInput($_POST["type"]),
            "item_name" => cleanInput($_POST["item_name"]),
            "category_id" => (int) $_POST["category_id"],
            "description" => cleanInput($_POST["description"]),
            "item_date" => cleanInput($_POST["item_date"]),
            "location" => cleanInput($_POST["location"]),
            "image" => $imageName,
            "status" => $status
        ];

        $itemModel->create($data);

        setMessage(
            "success",
            "Item added."
        );

        redirectTo(
            viewPath("admin-manage-items.php")
        );
    }

    if ($action == "admin_update_item") {
        requireRole("Admin");

        basicItemValidation(
            "admin-manage-items.php"
        );

        $itemId = (int) (
            $_POST["item_id"] ?? 0
        );

        $status = cleanInput(
            $_POST["status"] ?? ""
        );

        if (!$itemModel->findById($itemId)) {
            setMessage(
                "error",
                "Item not found."
            );

            redirectTo(
                viewPath("admin-manage-items.php")
            );
        }

        if (!validItemStatus($status)) {
            setMessage(
                "error",
                "Invalid item status."
            );

            redirectTo(
                viewPath("admin-manage-items.php")
            );
        }

        $data = [
            "type" => cleanInput($_POST["type"]),
            "item_name" => cleanInput($_POST["item_name"]),
            "category_id" => (int) $_POST["category_id"],
            "description" => cleanInput($_POST["description"]),
            "item_date" => cleanInput($_POST["item_date"]),
            "location" => cleanInput($_POST["location"]),
            "status" => $status
        ];

        $itemModel->updateBasic(
            $itemId,
            $data
        );

        setMessage(
            "success",
            "Item updated."
        );

        redirectTo(
            viewPath("admin-manage-items.php")
        );
    }

    if ($action == "admin_delete_item") {
        requireRole("Admin");

        $itemId = (int) (
            $_POST["item_id"] ?? 0
        );

        if (!$itemModel->findById($itemId)) {
            setMessage(
                "error",
                "Item not found."
            );

            redirectTo(
                viewPath("admin-manage-items.php")
            );
        }

        $itemModel->delete($itemId);

        setMessage(
            "success",
            "Item deleted."
        );

        redirectTo(
            viewPath("admin-manage-items.php")
        );
    }
}

?>