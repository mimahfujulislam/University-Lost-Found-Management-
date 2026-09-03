<?php
require_once __DIR__ . "/../Controller/ClaimController.php";
requireRole("Moderator");
$claims = getAllClaims();
$pageTitle = "Manage Claims";
include __DIR__ . "/header.php";
?>

<h1>Manage Claims</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Item</th>
        <th>Type</th>
        <th>Location</th>
        <th>Claimed By</th>
        <th>Message</th>
        <th>Contact</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php foreach ($claims as $claim) { ?>
        <tr>
            <td><?php echo e($claim["id"]); ?></td>
            <td><?php echo e($claim["item_name"]); ?></td>
            <td><?php echo e($claim["type"]); ?></td>
            <td><?php echo e($claim["location"]); ?></td>
            <td><?php echo e($claim["username"]); ?></td>
            <td><?php echo e($claim["claim_message"]); ?></td>
            <td><?php echo e($claim["contact_info"]); ?></td>
            <td><?php echo e($claim["status"]); ?></td>
            <td>
                <form method="post" action="../Controller/ClaimController.php">
                    <input type="hidden" name="action" value="update_claim_status">
                    <input type="hidden" name="claim_id" value="<?php echo e($claim["id"]); ?>">
                    <button type="submit" name="status" value="Approved">Approve</button>
                    <button class="danger" type="submit" name="status" value="Rejected">Reject</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    <?php if (count($claims) == 0) { ?>
        <tr><td colspan="9">No claims found.</td></tr>
    <?php } ?>
</table>

<?php include __DIR__ . "/footer.php"; ?>
