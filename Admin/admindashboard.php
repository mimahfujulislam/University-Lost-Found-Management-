<?php 
 
$nameErr = ""; 
$emailErr = ""; 
$name = ""; 
$email = ""; 
 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
 
    if (empty($_POST["name"])) { 
        $nameErr = "Name is required"; 
    } else { 
        $name = $_POST["name"]; 
    } 
 
    if (empty($_POST["email"])) { 
        $emailErr = "Email is required"; 
    } else { 
        $email = $_POST["email"]; 
 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $emailErr = "Invalid email format"; 
        } 
    } 
} 
 
?> 
 
<html>   
 
<head>   
 
    <title>UniLostFound - Admin Dashboard</title> 
 
<style> 
 
    body { 
 
        font-family: Arial, sans-serif; 
 
        margin: 0; 
 
        padding: 20px; 
 
        background-color: #f4f8f5; 
 
        color: #333333; 
 
    } 
 
    h1 { 
 
        background-color: #1e3a5f; 
 
        color: white; 
 
        padding: 18px; 
 
        margin: -20px -20px 20px -20px; 
 
        font-size: 28px; 
 
    } 
 
    h2 { 
 
        color: #1e3a5f; 
 
        margin-bottom: 20px; 
 
    } 
 
    a { 
 
        color: #2f5d8a; 
 
        text-decoration: none; 
 
    } 
 
    a:hover { 
 
        color: #1e3a5f; 
 
        text-decoration: underline; 
 
    } 
 
    hr { 
 
        border: 0; 
 
        border-top: 2px solid #d8dee5; 
 
        margin: 20px 0; 
 
    } 
 
    fieldset { 
 
        background-color: #ffffff; 
 
        border: 1px solid #d8dee5; 
 
        border-radius: 6px; 
 
        padding: 15px; 
 
        margin-bottom: 15px; 
 
    } 
 
    legend { 
 
        color: #1e3a5f; 
 
        font-weight: bold; 
 
        padding: 5px 10px; 
 
    } 
 
    fieldset fieldset { 
 
        width: 250px; 
 
        min-height: 150px; 
 
        vertical-align: top; 
 
        display: inline-block; 
 
        margin: 5px; 
 
        border: 1px solid #d8dee5; 
 
        border-top: 4px solid #2f5d8a; 
 
        border-radius: 6px; 
 
        box-sizing: border-box; 
 
    } 
 
    fieldset fieldset legend { 
 
        color: #1e3a5f; 
 
    } 
 
    p { 
 
        color: #5f6872; 
 
        line-height: 1.5; 
 
    } 
 
    input[type="button"] { 
 
        background-color: #2f5d8a; 
 
        color: white; 
 
        border: none; 
 
        padding: 10px 15px; 
 
        border-radius: 4px; 
 
        cursor: pointer; 
 
        font-weight: bold; 
 
    } 
 
    input[type="button"]:hover { 
 
        background-color: #1e3a5f; 
 
    } 
 
    table[border="1"] { 
 
        width: 100%; 
 
        border-collapse: collapse; 
 
        background-color: white; 
 
    } 
 
    table[border="1"] th { 
 
        background-color: #1e3a5f; 
 
        color: white; 
 
        padding: 12px; 
 
    } 
 
    table[border="1"] td { 
 
        padding: 12px; 
 
        text-align: center; 
 
        border: 1px solid #d8dee5; 
 
    } 
 
    table[border="1"] th { 
 
        border: 1px solid #1e3a5f; 
 
    } 
 
    table[border="1"] tr:nth-child(even) { 
 
        background-color: #f7f9fb; 
 
    } 
 
    table[border="1"] tr:hover { 
 
        background-color: #edf2f7; 
 
    } 
 
    body > fieldset:last-child { 
 
        background-color: #1e3a5f; 
 
        border: none; 
 
        color: white; 
 
        padding: 15px; 
 
    } 
 
    body > fieldset:last-child legend { 
 
        color: white; 
 
        background-color: #1e3a5f; 
 
    } 
 
    body > fieldset:last-child a { 
 
        color: white; 
 
    } 
 
    body > fieldset:last-child a:hover { 
 
        color: #c9d8e8; 
 
    } 
 
</style> 
 
</head>   
 
<body>   
 
    <h1>UniLostFound</h1>   
 
    <table width="100%" cellpadding="10">   
 
        <tr>   
 
            <td>   
 
                <b>Admin Dashboard</b>   
 
            </td>   
 
            <td align="right">   
 
                <a href="admindashboard.php">Dashboard</a> |   
 
                <a href="users.php">User</a> | 
 
                <a href="categories.php">Categories</a> | 
 
                 <a href="manage-items.php">Manage Items</a> | 
 
                <a href="../profile.php">My Profile</a> |  
 
                <a href="../login.php">Logout</a>   
 
            </td>   
 
        </tr>   
 
    </table>   
 
    <hr>   
 
    <h2>Welcome, Admin</h2>   
 
    <fieldset>   
 
        <legend><b>Admin Features:</b></legend>   
 
        <table cellpadding="15">   
 
            <tr>   
 
                <td>   
 
                    <fieldset>   
 
                        <legend><b>Manage Users</b></legend>   
 
                        <p>   
 
                            Add, view, edit and delete Student   
 
                            and Moderator accounts.   
 
                        </p>   
 
                        <a href="users.php">   
 
                            <input type="button" value="Manage Users">   
 
                        </a>   
 
                    </fieldset>   
 
                </td>   
 
                <td>   
 
                    <fieldset>   
 
                        <legend><b>Manage Categories</b></legend>   
 
                        <p>   
 
                            Add, edit and delete item categories   
 
                            used in the system.   
 
                        </p>   
 
                        <a href="categories.php">   
 
                            <input type="button" value="Manage Categories">   
 
                        </a>   
 
                    </fieldset>   
 
                </td>   
 
                <td>   
 
                    <fieldset>   
 
                        <legend><b>Manage System</b></legend>   
 
                        <p>   
 
                            View and manage all lost and found   
 
                            items in the system.   
 
                        </p>   
 
                        <a href="manage-items.php">   
 
                            <input type="button" value="Manage Items">   
 
                        </a>   
 
                    </fieldset>   
 
                </td>   
 
            </tr>   
 
        </table>   
 
    </fieldset>   
 
    <br>   
 
    <fieldset>   
 
        <legend><b>System Overview:</b></legend>   
 
        <table border="1" cellpadding="10" cellspacing="0">   
 
            <tr>   
 
                <th>Total Users</th>   
 
                <th>Total Students</th>   
 
                <th>Total Moderators</th>   
 
                <th>Total Items</th>   
 
                <th>Resolved Items</th>   
 
            </tr>   
 
            <tr align="center">   
 
                <td></td>   
 
                <td></td>   
 
                <td></td>   
 
                <td></td>   
 
                <td></td>   
 
            </tr>   
 
        </table>   
 
    </fieldset>   
 
    <br> 
 
    <fieldset> 
 
        <legend><b>Admin Information</b></legend> 
 
        <form name="myForm" 
              method="post" 
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 
 
            Name: 
 
            <input type="text" name="name"> 
 
            <span style="color:red;"> 
                <?php echo $nameErr; ?> 
            </span> 
 
            <br><br> 
 
            Email: 
 
            <input type="text" name="email"> 
 
            <span style="color:red;"> 
                <?php echo $emailErr; ?> 
            </span> 
 
            <br><br> 
 
            <input type="submit" value="Submit"> 
 
        </form> 
 
    </fieldset> 
 
 
</body>   
 
</html>