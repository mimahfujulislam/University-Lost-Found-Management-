<?php
require_once __DIR__ . "/AuthController.php";
require_once __DIR__ . "/../Model/Item.php";
require_once __DIR__ . "/../Model/Claim.php";

function getModeratorDashboardData()
{
    $itemModel = new Item();
    $claimModel = new Claim();

    return [
        "pending_items" => $itemModel->countByStatus("Pending"),
        "pending_claims" => $claimModel->countByStatus("Pending"),
        "total_items" => $itemModel->countAll(),
        "recently_reviewed" => $itemModel->getRecentlyReviewed(5)
    ];
}
?>
