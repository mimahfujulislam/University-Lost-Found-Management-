<?php
require_once __DIR__ . "/AuthController.php";
require_once __DIR__ . "/../Model/Claim.php";
require_once __DIR__ . "/../Model/Item.php";

function getStudentClaimsData($userId)
{
    $itemModel = new Item();
    $claimModel = new Claim();

    return [
        "approved_items" => $itemModel->search([]),
        "claims" => $claimModel->getByUser($userId)
    ];
}

function getAllClaims()
{
    $claimModel = new Claim();
    return $claimModel->getAllWithDetails();
}

function validClaimStatus($status)
{
    return in_array($status, ["Pending", "Approved", "Rejected"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    $action = $_POST["action"];
    $claimModel = new Claim();

    if ($action == "submit_claim") {
        requireRole("Student");

        $itemId = (int) ($_POST["item_id"] ?? 0);
        $message = cleanInput($_POST["claim_message"] ?? "");
        $contactInfo = cleanInput($_POST["contact_info"] ?? "");
        $itemModel = new Item();
        $item = $itemModel->findById($itemId);

        if (!$item || $item["status"] != "Approved") {
            setMessage("error", "Please select a valid approved item.");
            redirectTo(viewPath("student-claims.php"));
        }

        if ($item["user_id"] == $_SESSION["user_id"]) {
            setMessage("error", "You cannot claim your own item.");
            redirectTo(viewPath("student-claims.php"));
        }

        if ($message == "" || $contactInfo == "") {
            setMessage("error", "Claim message and contact information are required.");
            redirectTo(viewPath("student-claims.php"));
        }

        $claimModel->create([
            "item_id" => $itemId,
            "user_id" => $_SESSION["user_id"],
            "claim_message" => $message,
            "contact_info" => $contactInfo
        ]);

        setMessage("success", "Claim submitted.");
        redirectTo(viewPath("student-claims.php"));
    }

    if ($action == "update_claim_status") {
        requireRole("Moderator");

        $claimId = (int) ($_POST["claim_id"] ?? 0);
        $status = cleanInput($_POST["status"] ?? "");

        if (!validClaimStatus($status)) {
            setMessage("error", "Invalid claim status.");
            redirectTo(viewPath("moderator-manage-claims.php"));
        }

        $claimModel->updateStatus($claimId, $status);
        setMessage("success", "Claim status updated.");
        redirectTo(viewPath("moderator-manage-claims.php"));
    }
}
?>
