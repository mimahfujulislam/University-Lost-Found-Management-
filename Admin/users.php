<?php


$search = "";
$searchErr = "";
$fullname = "";
$student_id = "";
$email = "";
$role = "";
$password = "";

$fullnameErr = "";
$student_idErr = "";
$emailErr = "";
$roleErr = "";
$passwordErr = "";

$successMsg = "";




if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search_submit"])) {

    $search = trim($_POST["search"]);

    if ($search == "") {
        $searchErr = "Please enter a name or ID";
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {

   
    if (empty($_POST["fullname"])) {

        $fullnameErr = "Full Name is required";

    } else {

        $fullname = trim($_POST["fullname"]);
    }


    
    if (empty($_POST["student_id"])) {

        $student_idErr = "ID is required";

    } else {

        $student_id = trim($_POST["student_id"]);
    }



    if (empty($_POST["email"])) {

        $emailErr = "Email is required";

    } else {

        $email = trim($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $emailErr = "Invalid email format";
        }
    }


   
    if (empty($_POST["role"])) {

        $roleErr = "Role is required";

    } else {

        $role = $_POST["role"];
    }


    // Password
    if (empty($_POST["password"])) {

        $passwordErr = "Password is required";

    } else {

        $password = $_POST["password"];
    }


   
    if (
        $fullnameErr == "" &&
        $student_idErr == "" &&
        $emailErr == "" &&
        $roleErr == "" &&
        $passwordErr == ""
    ) {

        $successMsg = "User added successfully";

    }
}

?>

<html>

<head>

    <title>UniLostFound - User Management</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f6f5f2;
            color: #333333;
        }

        h1 {
            background-color: #3f3a36;
            color: white;
            padding: 18px;
            margin: -20px -20px 20px -20px;
            font-size: 28px;
        }

        h2 {
            color: #3f3a36;
            margin-bottom: 20px;
        }

        a {
            color: #9a6a24;
            text-decoration: none;
        }

        a:hover {
            color: #6f4b19;
            text-decoration: underline;
        }

        hr {
            border: 0;
            border-top: 2px solid #ded9d0;
            margin: 20px 0;
        }

        fieldset {
            background-color: white;
            border: 1px solid #ded9d0;
            border-radius: 6px;
            padding: 18px;
            margin-bottom: 15px;
        }

        legend {
            color: #3f3a36;
            background-color: white;
            padding: 5px 10px;
            font-weight: bold;
        }

        table {
            background-color: white;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            padding: 9px;
            border: 1px solid #cfc8bd;
            border-radius: 4px;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border: 1px solid #b27a2b;
            outline: none;
            background-color: #fffdf9;
        }

        input[type="submit"] {
            background-color: #9a6a24;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #76501c;
        }

        input[type="reset"] {
            background-color: #ebe8e3;
            color: #4a4641;
            border: 1px solid #cfc8bd;
            padding: 10px 18px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="reset"]:hover {
            background-color: #ddd8d0;
        }

        table[border="1"] {
            width: 100%;
            border-collapse: collapse;
        }

        table[border="1"] th {
            background-color: #3f3a36;
            color: white;
            padding: 12px;
            text-align: center;
        }

        table[border="1"] td {
            padding: 12px;
            border: 1px solid #ded9d0;
            text-align: center;
        }

        table[border="1"] tr:nth-child(even) {
            background-color: #faf9f7;
        }

        table[border="1"] tr:hover {
            background-color: #f5efe5;
        }

        body > table {
            border: 1px solid #e2ded7;
        }

        body > table td b {
            color: #3f3a36;
        }

    </style>

</head>

<body>

    <h1>UniLostFound</h1>

    <table width="100%" cellpadding="10">

        <tr>

            <td>
                <b>User Management</b>
            </td>

            <td align="right">

                <a href="admindashboard.php">Dashboard</a> |

                <a href="../profile.php">My Profile</a> |

                <a href="../login.php">Logout</a>

            </td>

        </tr>

    </table>

    <hr>

    <h2>Manage Users</h2>


  

    <fieldset>

        <legend><b>Search Users:</b></legend>

        <form action="" method="post">

            <table cellpadding="8">

                <tr>

                    <td>
                        <b>Search</b>
                    </td>

                    <td>:

                        <input
                            type="text"
                            name="search"
                            placeholder="Search by name or ID"
                            value="<?php echo htmlspecialchars($search); ?>"
                        >

                        <span style="color:red;">
                            <?php echo $searchErr; ?>
                        </span>

                    </td>

                </tr>

                <tr>

                    <td>
                        <b>Role</b>
                    </td>

                    <td>:

                        <select name="role">

                            <option value="">All</option>

                            <option value="Student">
                                Student
                            </option>

                            <option value="Moderator">
                                Moderator
                            </option>

                        </select>

                    </td>

                </tr>

                <tr>

                    <td></td>

                    <td>

                        <input
                            type="submit"
                            name="search_submit"
                            value="Search"
                        >

                        <input
                            type="reset"
                            value="Clear"
                        >

                    </td>

                </tr>

            </table>

        </form>

    </fieldset>


    <br>


   

    <fieldset>

        <legend><b>Add User:</b></legend>

        <form action="" method="post">

            <table cellpadding="8">

                <tr>

                    <td>
                        <b>Full Name</b>
                    </td>

                    <td>:

                        <input
                            type="text"
                            name="fullname"
                            value="<?php echo htmlspecialchars($fullname); ?>"
                        >

                        <span style="color:red;">
                            <?php echo $fullnameErr; ?>
                        </span>

                    </td>

                </tr>


                <tr>

                    <td>
                        <b>Student/Moderator ID</b>
                    </td>

                    <td>:

                        <input
                            type="text"
                            name="student_id"
                            value="<?php echo htmlspecialchars($student_id); ?>"
                        >

                        <span style="color:red;">
                            <?php echo $student_idErr; ?>
                        </span>

                    </td>

                </tr>


                <tr>

                    <td>
                        <b>Email</b>
                    </td>

                    <td>:

                        <input
                            type="email"
                            name="email"
                            value="<?php echo htmlspecialchars($email); ?>"
                        >

                        <span style="color:red;">
                            <?php echo $emailErr; ?>
                        </span>

                    </td>

                </tr>


                <tr>

                    <td>
                        <b>Role</b>
                    </td>

                    <td>:

                        <select name="role">

                            <option value="">
                                Select Role
                            </option>

                            <option value="Student"
                                <?php
                                if ($role == "Student") {
                                    echo "selected";
                                }
                                ?>>
                                Student
                            </option>

                            <option value="Moderator"
                                <?php
                                if ($role == "Moderator") {
                                    echo "selected";
                                }
                                ?>>
                                Moderator
                            </option>

                        </select>

                        <span style="color:red;">
                            <?php echo $roleErr; ?>
                        </span>

                    </td>

                </tr>


                <tr>

                    <td>
                        <b>Password</b>
                    </td>

                    <td>:

                        <input
                            type="password"
                            name="password"
                        >

                        <span style="color:red;">
                            <?php echo $passwordErr; ?>
                        </span>

                    </td>

                </tr>


                <tr>

                    <td></td>

                    <td>

                        <input
                            type="submit"
                            name="add_user"
                            value="Add User"
                        >

                    </td>

                </tr>

            </table>


            <?php

            if ($successMsg != "") {

                echo "<p style='color:green; font-weight:bold;'>$successMsg</p>";

            }

            ?>

        </form>

    </fieldset>


    <br>


   

    <fieldset>

        <legend><b>User List:</b></legend>

        <table border="1" cellpadding="10" cellspacing="0">

            <tr>

                <th>User ID</th>

                <th>Full Name</th>

                <th>Student/Moderator ID</th>

                <th>Email</th>

                <th>Role</th>

                <th>Action</th>

            </tr>

        </table>

    </fieldset>


    <br>

    <a href="admindashboard.php">
        Back to Dashboard
    </a>

</body>

</html>