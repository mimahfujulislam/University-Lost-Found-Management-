<?php
$items = [
    [
        "id" => "101",
        "name" => "Black Wallet",
        "type" => "Lost",
        "posted_by" => "John Smith",
        "location" => "AIUB Campus",
        "status" => "APPROVED"
    ],
    [
        "id" => "102",
        "name" => "Student ID Card",
        "type" => "Found",
        "posted_by" => "Alice Lee",
        "location" => "Library",
        "status" => "RETURNED"
    ],
    [
        "id" => "103",
        "name" => "AirPods Pro",
        "type" => "Found",
        "posted_by" => "David Wu",
        "location" => "Cafeteria",
        "status" => "APPROVED"
    ],
    [
        "id" => "104",
        "name" => "Calculus Textbook",
        "type" => "Lost",
        "posted_by" => "SpamBot",
        "location" => "Library",
        "status" => "RESOLVED"
    ]
];


$search = "";

if (isset($_GET["search"])) {
    $search = htmlspecialchars($_GET["search"]);
}




function searchItems($items, $search)
{
    if ($search == "") {
        return $items;
    }

    $result = [];

    foreach ($items as $item) {

        if (
            stripos($item["name"], $search) !== false ||
            stripos($item["type"], $search) !== false ||
            stripos($item["posted_by"], $search) !== false ||
            stripos($item["location"], $search) !== false ||
            stripos($item["status"], $search) !== false
        ) {
            $result[] = $item;
        }
    }

    return $result;
}



$filteredItems = searchItems($items, $search);




$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        isset($_POST["item_id"]) &&
        isset($_POST["new_status"])
    ) {

        $itemId = htmlspecialchars($_POST["item_id"]);
        $newStatus = htmlspecialchars($_POST["new_status"]);

        
        $newStatus = strtoupper($newStatus);

        $message = "Item #$itemId status changed to $newStatus.";
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Item Status</title>

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

        .approved {
            background: #dce9ff;
            color: #0755c9;
        }

        .returned {
            background: #dff4e5;
            color: #19733a;
        }

        .resolved {
            background: #e4e7ec;
            color: #555;
        }

        select {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .btn-update {
            background: #0755c9;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-update:hover {
            background: #0645a5;
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

        <a href="manage-claims.php">
            Claims
        </a>

        <a href="item-status.php" class="active">
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

        <h1>Manage Item Status</h1>


        

        <?php

        if ($message != "") {

            echo "<div class='message'>";
            echo $message;
            echo "</div>";

        }

        ?>


        <div class="card">


            

            <div class="tools">

                <form method="GET" action="item-status.php">

                    <input
                        type="text"
                        name="search"
                        placeholder="Search items..."
                        value="<?php echo $search; ?>"
                    >

                    <button type="submit" class="btn-update">
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

                        <th>Item</th>

                        <th>Type</th>

                        <th>Posted By</th>

                        <th>Location</th>

                        <th>Current Status</th>

                        <th>New Status</th>

                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>


                    <?php

                    if (count($filteredItems) > 0) {

                        foreach ($filteredItems as $item) {

                    ?>


                    <tr>

                        <td>

                            <b>
                                <?php echo htmlspecialchars($item["name"]); ?>
                            </b>

                            <div style="color:#777; font-size:12px;">

                                Item #
                                <?php echo htmlspecialchars($item["id"]); ?>

                            </div>

                        </td>


                        <td>

                            <?php echo htmlspecialchars($item["type"]); ?>

                        </td>


                        <td>

                            <?php echo htmlspecialchars($item["posted_by"]); ?>

                        </td>


                        <td>

                            <?php echo htmlspecialchars($item["location"]); ?>

                        </td>


                        <td>

                            <span class="status <?php echo strtolower($item["status"]); ?>">

                                <?php echo htmlspecialchars($item["status"]); ?>

                            </span>

                        </td>



                        <td>

                            <form
                                method="POST"
                                action="item-status.php"
                            >

                                <input
                                    type="hidden"
                                    name="item_id"
                                    value="<?php echo htmlspecialchars($item["id"]); ?>"
                                >


                                <select name="new_status">

                                    <option
                                        value="approved"
                                        <?php
                                        if ($item["status"] == "APPROVED") {
                                            echo "selected";
                                        }
                                        ?>
                                    >
                                        Approved
                                    </option>


                                    <option
                                        value="returned"
                                        <?php
                                        if ($item["status"] == "RETURNED") {
                                            echo "selected";
                                        }
                                        ?>
                                    >
                                        Returned
                                    </option>


                                    <option
                                        value="resolved"
                                        <?php
                                        if ($item["status"] == "RESOLVED") {
                                            echo "selected";
                                        }
                                        ?>
                                    >
                                        Resolved
                                    </option>

                                </select>

                        </td>


                        <td>

                                <button
                                    type="submit"
                                    class="btn-update"
                                >
                                    Update
                                </button>

                            </form>

                        </td>

                    </tr>


                    <?php

                        }

                    } else {

                    ?>

                    <tr>

                        <td colspan="7" class="no-result">

                            No items found.

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