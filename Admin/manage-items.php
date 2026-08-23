<?php

$search = "";
$searchErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["search"])) {
        $searchErr = "Please enter an item name";
    } else {
        $search = trim($_POST["search"]);

        if ($search == "") {
            $searchErr = "Please enter an item name";
        }
    }
}

?>

<html> 

<head> 

<title>UniLostFound - Manage Items</title> 

<style>

    body {

        font-family: Arial, sans-serif;

        margin: 0;

        padding: 20px;

        background-color: #f7f5f3;

        color: #333333;

    }

    h1 {

        background-color: #5a3038;

        color: white;

        padding: 18px;

        margin: -20px -20px 20px -20px;

        font-size: 28px;

    }

    h2 {

        color: #5a3038;

        margin-bottom: 20px;

    }

    a {

        color: #7a4650;

        text-decoration: none;

    }

    a:hover {

        color: #4a252d;

        text-decoration: underline;

    }

    hr {

        border: 0;

        border-top: 2px solid #ddd3d5;

        margin: 20px 0;

    }

    fieldset {

        background-color: white;

        border: 1px solid #ddd3d5;

        border-radius: 6px;

        padding: 18px;

        margin-bottom: 15px;

    }

    legend {

        color: #5a3038;

        background-color: white;

        padding: 5px 10px;

        font-weight: bold;

    }

    table {

        background-color: white;

    }

    input[type="text"],

    select {

        padding: 9px;

        border: 1px solid #cbbfc2;

        border-radius: 4px;

        font-family: Arial, sans-serif;

        font-size: 14px;

    }

    input[type="text"]:focus,

    select:focus {

        border: 1px solid #7a4650;

        outline: none;

        background-color: #fcf9fa;

    }

    input[type="submit"] {

        background-color: #7a4650;

        color: white;

        border: none;

        padding: 10px 18px;

        border-radius: 4px;

        cursor: pointer;

        font-weight: bold;

    }

    input[type="submit"]:hover {

        background-color: #5a3038;

    }

    input[type="reset"] {

        background-color: #ebe7e8;

        color: #4b4244;

        border: 1px solid #cbbfc2;

        padding: 10px 18px;

        border-radius: 4px;

        cursor: pointer;

        font-weight: bold;

    }

    input[type="reset"]:hover {

        background-color: #ddd6d8;

    }

    table[border="1"] {

        width: 100%;

        border-collapse: collapse;

    }

    table[border="1"] th {

        background-color: #5a3038;

        color: white;

        padding: 12px;

        text-align: center;

    }

    table[border="1"] td {

        padding: 12px;

        border: 1px solid #ddd3d5;

        text-align: center;

    }

    table[border="1"] tr:nth-child(even) {

        background-color: #faf8f8;

    }

    table[border="1"] tr:hover {

        background-color: #f1e9eb;

    }

    body > table {

        border: 1px solid #e1dadd;

    }

    body > table td b {

        color: #5a3038;

    }

</style>

</head> 

<body> 

<h1>UniLostFound</h1> 

<table width="100%" cellpadding="10"> 

    <tr> 

        <td> 

            <b>System Item Management</b> 

        </td> 

        <td align="right"> 

            <a href="admindashboard.php">Dashboard</a> | 

            <a href="../profile.php">My Profile</a> | 

            <a href="../login.php">Logout</a> 

        </td> 

    </tr> 

</table> 

<hr> 

<h2>Manage Lost & Found Items</h2> 

<fieldset> 

    <legend><b>Search & Filter Items:</b></legend> 

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 

        <table cellpadding="8"> 

            <tr> 

                <td><b>Search Item</b></td> 

                <td>: 

                    <input type="text" 
                           name="search" 
                           placeholder="Enter item name"
                           value="<?php echo htmlspecialchars($search); ?>">

                    <span style="color:red;">
                        <?php echo $searchErr; ?>
                    </span>

                </td> 

            </tr> 

            <tr> 

                <td><b>Type</b></td> 

                <td>: 

                    <select name="type"> 

                        <option value="">All</option> 

                        <option value="Lost">Lost</option> 

                        <option value="Found">Found</option> 

                    </select> 

                </td> 

            </tr> 

            <tr> 

                <td><b>Status</b></td> 

                <td>: 

                    <select name="status"> 

                        <option value="">All</option> 

                        <option value="Pending">Pending</option> 

                        <option value="Approved">Approved</option> 

                        <option value="Rejected">Rejected</option> 

                        <option value="Resolved">Resolved</option> 

                        <option value="Returned">Returned</option> 

                    </select> 

                </td> 

            </tr> 

            <tr> 

                <td></td> 

                <td> 

                    <input type="submit" value="Search"> 

                    <input type="reset" value="Clear"> 

                </td> 

            </tr> 

        </table> 

    </form> 

</fieldset> 

<br> 

<fieldset> 

    <legend><b>All Items:</b></legend> 

    <table border="1" cellpadding="10" cellspacing="0"> 

        <tr> 

            <th>Item ID</th> 

            <th>Item Name</th> 

            <th>Type</th> 

            <th>Category</th> 

            <th>Reported By</th> 

            <th>Date</th> 

            <th>Status</th> 

            <th>Action</th> 

        </tr> 

    </table> 

</fieldset> 

<br> 

<a href="admindashboard.html">Back to Dashboard</a> 

</body> 

</html>