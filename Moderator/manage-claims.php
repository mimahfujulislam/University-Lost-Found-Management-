<?php
$claims = [
    [
        "id" => "C001",
        "item" => "Black Wallet",
        "code" => "Item #101",
        "student" => "John Smith",
        "message" => "This wallet belongs to me.",
        "date" => "Feb 24, 2026",
        "status" => "PENDING"
    ],
    [
        "id" => "C002",
        "item" => "Student ID Card",
        "code" => "Item #102",
        "student" => "Alice Lee",
        "message" => "This is my ID card.",
        "date" => "Oct 23, 2025",
        "status" => "ACCEPTED"
    ],
    [
        "id" => "C003",
        "item" => "AirPods Pro",
        "code" => "Item #103",
        "student" => "David Wu",
        "message" => "I can provide proof of ownership.",
        "date" => "May 23, 2026",
        "status" => "PENDING"
    ],
    [
        "id" => "C004",
        "item" => "Calculus Textbook",
        "code" => "Item #104",
        "student" => "SpamBot",
        "message" => "Claim rejected by moderator.",
        "date" => "Oct 22, 2025",
        "status" => "REJECTED"
    ]
];




$search = "";

if (isset($_GET["search"])) {

    $search = htmlspecialchars($_GET["search"]);

}




function searchClaims($claims, $search)
{

    if ($search == "") {
        return $claims;
    }

    $result = [];

    foreach ($claims as $claim) {

        if (
            stripos($claim["id"], $search) !== false ||
            stripos($claim["item"], $search) !== false ||
            stripos($claim["student"], $search) !== false ||
            stripos($claim["message"], $search) !== false ||
            stripos($claim["status"], $search) !== false
        ) {

            $result[] = $claim;

        }

    }

    return $result;
}

$filteredClaims = searchClaims($claims, $search);




$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        isset($_POST["claim_id"]) &&
        isset($_POST["action"])
    ) {

        $claimId = htmlspecialchars($_POST["claim_id"]);
        $action = htmlspecialchars($_POST["action"]);


        if ($action == "accept") {

            $message = "Claim $claimId has been accepted.";

        }

        elseif ($action == "reject") {

            $message = "Claim $claimId has been rejected.";

        }

    }

}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Manage Claims</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            background: #f7f9fc;
            color: #202938;
        }

        .sidebar {
            width: 200px;
            background: #fff;
            height: 100vh;
            border-right: 1px solid #ddd;
            padding: 15px;
        }

        .sidebar h2 {
            color: #0755c9;
            margin: 0 0 15px 0;
            font-size: 18px;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            color: #444;
            text-decoration: none;
            margin-bottom: 5px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #e8f0ff;
            color: #0755c9;
            border-radius: 4px;
        }

        .btn-report {
            background: #0755c9;
            color: white !important;
            text-align: center;
            border-radius: 4px;
        }

        .main {
            flex: 1;
            padding: 20px;
        }

        .card {
            background: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .tools {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .tools input {
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #eef3fa;
        }

        .status {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            background: #ffe3d3;
            color: #c65c00;
        }

        .accepted {
            background: #dce9ff;
            color: #0755c9;
        }

        .rejected {
            background: #ffdede;
            color: #c62828;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-accept {
            background: #0755c9;
        }

        .btn-reject {
            background: white;
            color: #0755c9;
            border: 1px solid #0755c9;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .message {
            background: #e8f0ff;
            color: #0755c9;
            border: 1px solid #b8cdf5;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .no-result {
            text-align: center;
            padding: 20px;
            color: #777;
        }

    </style>

</head>


<body>




    <div class="sidebar">

        <h2>UniLostFound</h2>


        <a href="#" class="btn-report">
            + Report New Item
        </a>


        <a href="dashboard.php">
            Dashboard
        </a>


        <a href="review-items.php?type=lost">
            Lost Items
        </a>


        <a href="review-items.php?type=found">
            Found Items
        </a>


        <a href="manage-claims.php" class="active">
            Claims
        </a>


        <a href="item-status.php">
            Item Status
        </a>


        <a href="settings.php">
            Settings
        </a>


        <a href="../login.php">
            Logout
        </a>

    </div>



    <div class="main">

        <h1>Manage Claims</h1>


        

        <?php

        if ($message != "") {

            echo "<div class='message'>";
            echo $message;
            echo "</div>";

        }

        ?>


        <div class="card">




            <div class="tools">

                <form method="GET" action="manage-claims.php">

                    <input
                        type="text"
                        name="search"
                        placeholder="Search claims..."
                        value="<?php echo $search; ?>"
                    >


                    <button
                        type="submit"
                        class="btn btn-accept"
                    >
                        Search
                    </button>

                </form>

            </div>


            <?php

            if ($search != "") {

                echo "<p>Search result for: <b>$search</b></p>";

            }

            ?>



            <table>

                <thead>

                    <tr>

                        <th>Claim ID</th>

                        <th>Item</th>

                        <th>Student</th>

                        <th>Claim Message</th>

                        <th>Date</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>


                    <?php

                    if (count($filteredClaims) > 0) {

                        foreach ($filteredClaims as $claim) {

                    ?>


                    <tr>


                        <td>

                            <?php
                            echo htmlspecialchars($claim["id"]);
                            ?>

                        </td>


                        <td>

                            <b>
                                <?php
                                echo htmlspecialchars($claim["item"]);
                                ?>
                            </b>

                            <div style="color:#777; font-size:12px;">

                                <?php
                                echo htmlspecialchars($claim["code"]);
                                ?>

                            </div>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars($claim["student"]);
                            ?>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars($claim["message"]);
                            ?>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars($claim["date"]);
                            ?>

                        </td>


                        <td>

                            <span
                                class="status <?php echo strtolower($claim["status"]); ?>"
                            >

                                <?php
                                echo htmlspecialchars($claim["status"]);
                                ?>

                            </span>

                        </td>


                        <td>


                            <?php

                            if ($claim["status"] == "PENDING") {

                            ?>


                    

                                <form
                                    method="POST"
                                    action="manage-claims.php"
                                    style="display:inline;"
                                >

                                    <input
                                        type="hidden"
                                        name="claim_id"
                                        value="<?php echo htmlspecialchars($claim["id"]); ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="action"
                                        value="accept"
                                    >

                                    <button
                                        type="submit"
                                        class="btn btn-accept"
                                    >
                                        Accept
                                    </button>

                                </form>


                    

                                <form
                                    method="POST"
                                    action="manage-claims.php"
                                    style="display:inline;"
                                >

                                    <input
                                        type="hidden"
                                        name="claim_id"
                                        value="<?php echo htmlspecialchars($claim["id"]); ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="action"
                                        value="reject"
                                    >

                                    <button
                                        type="submit"
                                        class="btn btn-reject"
                                    >
                                        Reject
                                    </button>

                                </form>


                            <?php

                            } else {

                                echo "<span style='color:#777;'>Closed</span>";

                            }

                            ?>


                        </td>


                    </tr>


                    <?php

                        }

                    } else {

                    ?>


                    <tr>

                        <td
                            colspan="7"
                            class="no-result"
                        >

                            No claims found.

                        </td>

                    </tr>


                    <?php

                    }

                    ?>


                </tbody>

            </table>


        </div>


    </div>


</body>

</html>