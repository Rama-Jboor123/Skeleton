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
    <title>Publishers</title>
     <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="content">
    <h2>Publishers</h2>

    <?php
    
    $sql = "SELECT * FROM publisher WHERE 1";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $sql .= " AND publisher_id = '$id'";
        }

        if (!empty($_POST['name'])) {
            $name = $_POST['name'];
            $sql .= " AND name LIKE '%$name%'";
        }

        if (!empty($_POST['city'])) {
            $city = $_POST['city'];
            $sql .= " AND city LIKE '%$city%'";
        }

        if (!empty($_POST['country'])) {
            $country = $_POST['country'];
            if ($country != "") {
                $sql .= " AND country like '%$country%'";
            }
        }

        if (!empty($_POST['contact_info'])) {
            $contact_info = $_POST['contact_info'];
            $sql .= " AND contact_info like '%$contact_info%'";
        }
    }

   

    $r = mysqli_query($conn, $sql);
    ?>
    
    
    <form method="POST">
        <div>
            <label for="id">Search by ID</label><br>
            <input type="text" name="id" id="id">
        </div>

        <div>
            <label for="name">Name</label><br>
            <input type="text" name="name" id="name">
        </div>

        <div>
            <label for="city">City</label><br>
            <input type="text" name="city" id="city">
        </div>

         <div>
            <label for="country">Country</label><br>
            <input type="text" name="country" id="country">
        </div>
        
        <div>
            <label for="cn">Contact_info</label><br>
            <input type="text" name="contact_info" id="cn">
        </div>

        <div style="align-self: end;">
            <input type="submit" value="Search" style="background-color: #391B25;color:white">
            <input type="reset" value="Refresh">
        </div>
    </form>
    <?php if ($_SESSION['role'] == 'admin'): ?>
     <a href="addPublisher.php" ><button class="btn btn-add">Add publisher</button></a>
    <?php endif ?>
    <!-- Publishers Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>City</th>
            <th>Country</th>
            <th>Contact_info</th>
            <?php if ($_SESSION['role'] == 'admin'): ?>
            <th>Actions</th>
            <?php endif?>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($r)) { ?>
            <tr>
                <td><?php echo $row['publisher_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['city']; ?></td>
                <td><?php echo $row['country']; ?></td>
                <td><?php echo $row['contact_info']; ?></td>
                <td>
                    <a href="edit_publisher.php?id=<?php echo $row['publisher_id']; ?>"><button class="btn btn-edit">Edit</button></a> |
                    <a onclick="return confirm('Are you sure?');"
                       href="delete_publisher.php?id=<?php echo $row['publisher_id']; ?>"><button class="btn btn-delete">Delet</button></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
