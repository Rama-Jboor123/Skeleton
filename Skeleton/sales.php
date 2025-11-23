<?php
include 'header.php';
include 'minue.php';
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="content">
    <h2>Sales</h2>

    <?php

    $sql = "SELECT sale_id, first_name, last_name, title, sale_price, sale_date
            FROM sale 
            NATURAL JOIN borrower 
            NATURAL JOIN book 
            WHERE 1";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $sql .= " AND sale_id = '$id'";
        }

        if (!empty($_POST['first_name'])) {
            $fn = $_POST['first_name'];
            $sql .= " AND first_name LIKE '%$fn%'";
        }

        if (!empty($_POST['last_name'])) {
            $ln = $_POST['last_name'];
            $sql .= " AND last_name LIKE '%$ln%'";
        }

        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
            $sql .= " AND title LIKE '%$title%'";
        }

        if (!empty($_POST['sale_date'])) {
            $ld = $_POST['sale_date'];
            $sql .= " AND sale_date LIKE '%$ld%'";
        }

        if (!empty($_POST['sale_price'])) {
            $dt = $_POST['sale_price'];
            $sql .= " AND sale_price = '$dt'";
        }
    }

    $sql .= " ORDER BY sale_id";

    $r = mysqli_query($conn, $sql);
    ?>

    <form method="POST">
        <div>
            <label for="id">Search by ID</label><br>
            <input type="text" name="id" id="id">
        </div>

        <div>
            <label for="fn">First Name</label><br>
            <input type="text" name="first_name" id="fn">
        </div>

        <div>
            <label for="ls">Last Name</label><br>
            <input type="text" name="last_name" id="ls">
        </div>

        <div>
            <label for="title">Book Title</label><br>
            <input type="text" name="title" id="title">
        </div>

        <div>
            <label>Sale Date</label><br>
            <input type="date" name="sale_date">
        </div>

        <div>
            <label>Sale Price</label><br>
            <input type="number" name="sale_price">
        </div>

        <div style="align-self: end;">
            <input type="submit" value="Search" style="background-color: #391B25; color: white">
            <input type="reset" value="Refresh">
        </div>
    </form>

    <a href="addSale.php"><button class="btn btn-add">Add Sale</button></a>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Borrower Name</th>
            <th>Book Title</th>
            <th>Sale Date</th>
            <th>Sale Price</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($r)) { ?>
            <tr>
                <td><?= $row['sale_id'] ?></td>
                <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['sale_date'] ?></td>
                <td><?= $row['sale_price'] ?></td>
                <td>
                    <a href="edit_sale.php?id=<?= $row['sale_id'] ?>"><button class="btn btn-edit">Edit</button></a> |
                    <a onclick="return confirm('Are you sure?');" 
                       href="delete_sale.php?id=<?= $row['sale_id'] ?>"><button class="btn btn-delete">Delete</button></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
