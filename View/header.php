<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($pageTitle)) {
    $pageTitle = "University Lost & Found";
}

if (!function_exists("e")) {
    function e($value)
    {
        return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="styles.css">
    <script src="../Controller/script.js" defer></script>
</head>
<body>
<div class="page">
    <?php include __DIR__ . "/navbar.php"; ?>

    <main class="content">
        <?php if (isset($_SESSION["success"])) { ?>
            <p class="message success"><?php echo e($_SESSION["success"]); unset($_SESSION["success"]); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION["error"])) { ?>
            <p class="message error"><?php echo e($_SESSION["error"]); unset($_SESSION["error"]); ?></p>
        <?php } ?>
