<?php
require_once __DIR__ . "/../Controller/ClaimController.php";
requireRole("Student");
$data = getStudentClaimsData($_SESSION["user_id"]);
$pageTitle = "Student Claims";
include __DIR__ . "/header.php";
?>

<h1>Claims</h1>

<form id="claimForm" method="post" action="../Controller/ClaimController.php">
    <input type="hidden" name="action" value="submit_claim">

    <fieldset>
        <legend>Submit Claim</legend>
        <table>
            <tr>
                <td>Item</td>
                <td>
                    <select name="item_id" data-required="yes">
                        <option value="">Select Item</option>
                        <?php foreach ($data["approved_items"] as $item) { ?>
                            <option value="<?php echo e($item["id"]); ?>">
                                <?php echo e($item["item_name"] . " - " . $item["location"]); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr><td>Claim Message</td><td><textarea name="claim_message" data-required="yes"></textarea></td></tr>
            <tr><td>Contact Info</td><td><input type="text" name="contact_info" data-required="yes"></td></tr>
            <tr><td></td><td><button type="submit">Submit Claim</button></td></tr>
        </table>
    </fieldset>
</form>

<h2>My Submitted Claims</h2>
<table>
    <tr>
        <th>Item</th>
        <th>Type</th>
        <th>Location</th>
        <th>Message</th>
        <th>Status</th>
        <th>Date</th>
    </tr>
    <?php foreach ($data["claims"] as $claim) { ?>
        <tr>
            <td><?php echo e($claim["item_name"]); ?></td>
            <td><?php echo e($claim["type"]); ?></td>
            <td><?php echo e($claim["location"]); ?></td>
            <td><?php echo e($claim["claim_message"]); ?></td>
            <td><?php echo e($claim["status"]); ?></td>
            <td><?php echo e($claim["created_at"]); ?></td>
        </tr>
    <?php } ?>
    <?php if (count($data["claims"]) == 0) { ?>
        <tr><td colspan="6">No claims submitted.</td></tr>
    <?php } ?>
</table>

<?php include __DIR__ . "/footer.php"; ?>
