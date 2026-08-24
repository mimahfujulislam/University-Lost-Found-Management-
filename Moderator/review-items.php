<!DOCTYPE html>
<html>
<head>

    <title>Review Items</title>

    <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            color: #202938;
        }


        .sidebar {
            width: 180px;
            height: 100vh;
            background-color: white;
            border-right: 1px solid #ddd;
            position: fixed;
            left: 0;
            top: 0;
        }

        .logo {
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }

        .logo h2 {
            margin: 0;
            color: #0755c9;
            font-size: 18px;
        }

        .logo p {
            margin: 5px 0 0;
            font-size: 11px;
            color: #666;
        }

        .menu {
            padding: 15px 10px;
        }

        .menu a {
            display: block;
            padding: 12px;
            margin-bottom: 5px;
            text-decoration: none;
            color: #444;
            border-radius: 3px;
        }

        .menu a:hover {
            background-color: #e8f0ff;
            color: #0755c9;
        }

        .menu .active {
            background-color: #dbe8ff;
            color: #0755c9;
        }

        .logout {
            margin-top: 30px;
        }


        .topbar {
            height: 30px;
            background-color: white;
            border-bottom: 1px solid #ddd;
            margin-left: 180px;
            padding: 15px 20px;
            color: #0755c9;
            font-weight: bold;
        }

        .search {
            float: right;
            width: 200px;
            padding: 7px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }


        .main {
            margin-left: 180px;
            padding: 25px;
        }

        h1 {
            font-size: 24px;
        }

        .description {
            color: #666;
            margin-bottom: 20px;
        }



        .filter {
            background-color: white;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }

        .filter label {
            margin-right: 10px;
        }

        .filter select {
            padding: 7px;
            margin-right: 10px;
        }

        .filter button {
            padding: 7px 15px;
            background-color: #0755c9;
            color: white;
            border: none;
        }



        .items {
            background-color: white;
            border: 1px solid #ddd;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #eef3fa;
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .approve {
            background-color: green;
            color: white;
            padding: 6px 10px;
            border: none;
        }

        .reject {
            background-color: red;
            color: white;
            padding: 6px 10px;
            border: none;
        }

        footer {
            margin-left: 180px;
            padding: 15px;
            background-color: #eef3fa;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #555;
        }

    </style>

</head>


<body>



    <div class="sidebar">

        <div class="logo">

            <h2>UniLostFound</h2>

            <p>Management Portal</p>

        </div>


        <div class="menu">

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="review-items.php" class="active">
                Lost Items
            </a>

            <a href="review-items.php">
                Found Items
            </a>

            <a href="manage-claims.php">
                Claims
            </a>

           
            <div class="logout">

                <a href="settings.php">
                    Settings
                </a>

                <a href="../login.php">
                    Logout
                </a>

            </div>

        </div>

    </div>




    <div class="topbar">

        Lost & Found Management

        <input
            class="search"
            type="text"
            placeholder="Search items"
        >

    </div>



    <div class="main">

        <h1>Review Items</h1>

        <p class="description">
            Review lost and found items submitted by users.
        </p>



        <div class="filter">

            <form method="GET">

                <label>Item Type:</label>

                <select name="type">

                    <option value="all">
                        All Items
                    </option>

                    <option value="lost">
                        Lost Items
                    </option>

                    <option value="found">
                        Found Items
                    </option>

                </select>


                <label>Status:</label>

                <select name="status">

                    <option value="pending">
                        Pending
                    </option>

                    <option value="approved">
                        Approved
                    </option>

                    <option value="rejected">
                        Rejected
                    </option>

                </select>


                <button type="submit">
                    Filter
                </button>

            </form>

        </div>




        <div class="items">

            <h3>Items Waiting for Review</h3>


            <?php

                $items = [

                    [
                        "id" => 1,
                        "name" => "Black Wallet",
                        "type" => "Lost",
                        "location" => "Library",
                        "status" => "Pending"
                    ],

                    [
                        "id" => 2,
                        "name" => "Mobile Phone",
                        "type" => "Found",
                        "location" => "Cafeteria",
                        "status" => "Pending"
                    ],

                    [
                        "id" => 3,
                        "name" => "Blue Bag",
                        "type" => "Lost",
                        "location" => "Classroom",
                        "status" => "Pending"
                    ]

                ];

            ?>


            <table>

                <tr>

                    <th>ID</th>

                    <th>Item Name</th>

                    <th>Type</th>

                    <th>Location</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>


                <?php

                    foreach ($items as $item) {

                        echo "<tr>";

                        echo "<td>";
                        echo $item["id"];
                        echo "</td>";

                        echo "<td>";
                        echo $item["name"];
                        echo "</td>";

                        echo "<td>";
                        echo $item["type"];
                        echo "</td>";

                        echo "<td>";
                        echo $item["location"];
                        echo "</td>";

                        echo "<td>";
                        echo $item["status"];
                        echo "</td>";

                        echo "<td>";

                        echo "<button class='approve'>";
                        echo "Approve";
                        echo "</button>";

                        echo " ";

                        echo "<button class='reject'>";
                        echo "Reject";
                        echo "</button>";

                        echo "</td>";

                        echo "</tr>";

                    }

                ?>

            </table>

        </div>

    </div>



    <footer>

        Privacy Policy |
        Terms of Service |
        Contact Security

    </footer>


</body>
</html>

