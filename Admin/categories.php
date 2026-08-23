<?php

$categoryErr = "";
$category_name = "";
$description = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["category_name"])) {
        $categoryErr = "Category name is required";
    } else {
        $category_name = trim($_POST["category_name"]);

        if ($category_name == "") {
            $categoryErr = "Category name is required";
        }
    }

    if (!empty($_POST["description"])) {
        $description = $_POST["description"];
    }
}

?>

<html>

<head>

```
<title>UniLostFound - Category Management</title>

<style>

    body {

        font-family: Arial, sans-serif;

        margin: 0;

        padding: 20px;

        background-color: #f3f7f5;

        color: #333333;

    }

    h1 {

        background-color: #245c4a;

        color: white;

        padding: 18px;

        margin: -20px -20px 20px -20px;

        font-size: 28px;

    }

    h2 {

        color: #245c4a;

        margin-bottom: 20px;

    }

    a {

        color: #28745d;

        text-decoration: none;

    }

    a:hover {

        color: #174738;

        text-decoration: underline;

    }

    hr {

        border: 0;

        border-top: 2px solid #cbded6;

        margin: 20px 0;

    }

    fieldset {

        background-color: white;

        border: 1px solid #cbded6;

        border-radius: 6px;

        padding: 18px;

        margin-bottom: 15px;

    }

    legend {

        color: #245c4a;

        background-color: white;

        padding: 5px 10px;

        font-weight: bold;

    }

    table {

        background-color: white;

    }

    input[type="text"],

    textarea {

        padding: 9px;

        border: 1px solid #b8ccc3;

        border-radius: 4px;

        font-family: Arial, sans-serif;

        font-size: 14px;

    }

    input[type="text"]:focus,

    textarea:focus {

        border: 1px solid #28745d;

        outline: none;

        background-color: #f7fbf9;

    }

    input[type="submit"] {

        background-color: #28745d;

        color: white;

        border: none;

        padding: 10px 16px;

        border-radius: 4px;

        cursor: pointer;

        font-weight: bold;

    }

    input[type="submit"]:hover {

        background-color: #245c4a;

    }

    input[type="reset"] {

        background-color: #e5ebe8;

        color: #34443d;

        border: 1px solid #b8ccc3;

        padding: 10px 16px;

        border-radius: 4px;

        cursor: pointer;

        font-weight: bold;

    }

    input[type="reset"]:hover {

        background-color: #d5dfda;

    }

    table[border="1"] {

        width: 100%;

        border-collapse: collapse;

    }

    table[border="1"] th {

        background-color: #245c4a;

        color: white;

        padding: 12px;

        text-align: left;

    }

    table[border="1"] td {

        padding: 12px;

        border: 1px solid #cbded6;

    }

    table[border="1"] tr:nth-child(even) {

        background-color: #f5f9f7;

    }

    table[border="1"] tr:hover {

        background-color: #eaf3ef;

    }

    body > table {

        border: 1px solid #dce6e2;

    }

    body > table td b {

        color: #245c4a;

    }

</style>
```

</head>

<body>

```
<h1>UniLostFound</h1>

<table width="100%" cellpadding="10">

    <tr>

        <td>

            <b>Category Management</b>

        </td>

        <td align="right">

            <a href="admindashboard.php">Dashboard</a> |

            <a href="../profile.php">My Profile</a> |

            <a href="../login.php">Logout</a>

        </td>

    </tr>

</table>

<hr>

<h2>Manage Categories</h2>

<fieldset>

    <legend><b>Add Category:</b></legend>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <table cellpadding="8">

            <tr>

                <td><b>Category Name</b></td>

                <td>:

                    <input

                        type="text"

                        name="category_name"

                        placeholder="Enter category name"

                        value="<?php echo htmlspecialchars($category_name); ?>"

                        required

                    >

                    <span style="color:red;">

                        <?php echo $categoryErr; ?>

                    </span>

                </td>

            </tr>

            <tr>

                <td><b>Description</b></td>

                <td>:

                    <textarea

                        name="description"

                        rows="4"

                        cols="30"

                        placeholder="Enter category description"

                    ><?php echo htmlspecialchars($description); ?></textarea>

                </td>

            </tr>

            <tr>

                <td></td>

                <td>

                    <input type="submit" value="Add Category">

                    <input type="reset" value="Clear">

                </td>

            </tr>

        </table>

    </form>

</fieldset>

<br>

<fieldset>

    <legend><b>Category List:</b></legend>

    <table border="1" cellpadding="10" cellspacing="0">

        <tr>

            <th>Category ID</th>

            <th>Category Name</th>

            <th>Description</th>

            <th>Action</th>

        </tr>

    </table>

</fieldset>

<br>

<a href="admindashboard.php">Back to Dashboard</a>
```

</body>

</html>
