<?php
$search = "";

if (isset($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']);
}


$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['action'])) {

        $action = htmlspecialchars($_POST['action']);

        if ($action == "review") {
            $message = "Review Items button was clicked.";
        }

        if ($action == "claims") {
            $message = "Manage Claims button was clicked.";
        }

        if ($action == "status") {
            $message = "Item Status button was clicked.";
        }
    }
}


$pendingItems = 5;
$pendingClaims = 12;
$resolvedItems = 45;

?>

<!DOCTYPE html>
<html>

<head>

    <title>Moderator Dashboard</title>

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
            margin-bottom: 20px;
        }

        .cards {
            display: flex;
            gap: 15px;
        }

        .card {
            background-color: white;
            border: 1px solid #ddd;
            padding: 20px;
            width: 200px;
            border-radius: 4px;
        }

        .card h3 {
            font-size: 14px;
            color: #555;
            margin-top: 0;
        }

        .number {
            font-size: 28px;
            font-weight: bold;
            color: #0755c9;
        }

        .quick {
            background-color: white;
            border: 1px solid #ddd;
            margin-top: 20px;
            padding: 20px;
            border-radius: 4px;
        }

        .quick h3 {
            margin-top: 0;
        }

        .quick form {
            display: inline-block;
        }

        .quick button {
            padding: 10px 15px;
            margin-right: 10px;
            border: 1px solid #0755c9;
            background-color: white;
            color: #0755c9;
            border-radius: 3px;
            cursor: pointer;
        }

        .quick button:hover {
            background-color: #0755c9;
            color: white;
        }

        .message {
            margin-top: 15px;
            padding: 10px;
            background-color: #e8f0ff;
            color: #0755c9;
            border: 1px solid #b8cdf5;
        }

        .activity {
            background-color: white;
            border: 1px solid #ddd;
            margin-top: 20px;
            padding: 20px;
            height: 180px;
            border-radius: 4px;
        }

        .activity h3 {
            margin-top: 0;
        }

        .activity p {
            color: #777;
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

            <a href="dashboard.php" class="active">
                Dashboard
            </a>

            <a href="review-items.php">
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




        <form method="GET" action="dashboard.php" style="display:inline;">

            <input
                class="search"
                type="text"
                name="search"
                placeholder="Search"
                value="<?php echo $search; ?>"
            >

        </form>

    </div>


    

    <div class="main">

        <h1>Moderator Dashboard</h1>


        <?php


        if ($search != "") {

            echo "<p>Searching for: <b>$search</b></p>";

        }

        ?>



        <div class="cards">


            <div class="card">

                <h3>Pending Items</h3>

                <div class="number">

                    <?php
                    echo $pendingItems;
                    ?>

                </div>

            </div>


            <div class="card">

                <h3>Pending Claims</h3>

                <div class="number">

                    <?php
                    echo $pendingClaims;
                    ?>

                </div>

            </div>


            <div class="card">

                <h3>Resolved Items</h3>

                <div class="number">

                    <?php
                    echo $resolvedItems;
                    ?>

                </div>

            </div>


        </div>


    

        <div class="quick">

            <h3>Quick Actions</h3>

            <p>
                Manage outstanding tasks.
            </p>



            <form method="POST" action="dashboard.php">

                <input
                    type="hidden"
                    name="action"
                    value="review"
                >

                <button type="submit">
                    Review Items
                </button>

            </form>


            <form method="POST" action="dashboard.php">

                <input
                    type="hidden"
                    name="action"
                    value="claims"
                >

                <button type="submit">
                    Manage Claims
                </button>

            </form>


            <form method="POST" action="dashboard.php">

                <input
                    type="hidden"
                    name="action"
                    value="status"
                >

                <button type="submit">
                    Item Status
                </button>

            </form>


            <?php

        

            if ($message != "") {

                echo "<div class='message'>";
                echo $message;
                echo "</div>";

            }

            ?>

        </div>



        <div class="activity">

            <h3>Recent Activity</h3>

            <p>
                Activity table will appear here.
            </p>

        </div>


    </div>



    <footer>

        Privacy Policy |
        Terms of Service |
        Contact Security

    </footer>


</body>

</html>