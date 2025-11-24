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
    <title>Authors</title>
<link rel="stylesheet" href="style.css">

</head>
<body>

<div class="content">
    <h2>Authors</h2>

    <?php
    
    $sql = "SELECT * FROM author WHERE 1";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $sql .= " AND author_id = '$id'";
        }

        if (!empty($_POST['first_name'])) {
            $fn = $_POST['first_name'];
            $sql .= " AND first_name LIKE '%$fn%'";
        }

        if (!empty($_POST['last_name'])) {
            $ls = $_POST['last_name'];
            $sql .= " AND last_name LIKE '%$ls%'";
        }

        if (!empty($_POST['country'])) {
            $cn = $_POST['country'];
            if ($cn != "") {
                $sql .= " AND country like '%$cn%'";
            }
        }

        if (!empty($_POST['bio'])) {
            $b = $_POST['bio'];
            $sql .= " AND bio like '%$b'";
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
            <label for="fn">First name</label><br>
            <input type="text" name="first_name" id="fn">
        </div>

        <div>
            <label for="ls">Last name</label><br>
            <input type="text" name="last_name" id="ls">
        </div>

        <div>
            <label for="cn">Country</label><br>
            <input type="text" name="country" id="cn">
        </div>

        
        <div>
            <label for="b">Bio</label><br>
            <input type="text" name="bio" id="b">
        </div>

        <div style="align-self: end;">
            <input type="submit" value="Search" style="background-color: #391B25;color:white">
            <input type="reset" value="Refresh">
        </div>
    </form>
     <?php if ($_SESSION['role'] == 'admin'): ?>
     <a href="addAuthor.php" ><button class="btn btn-add">Add Author</button></a>
    <?php endif ?>
     
    <!-- Author Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last name</th>
            <th>Country</th>
            <th>Bio</th>
            <?php if ($_SESSION['role'] == 'admin'): ?>
            <th>Actions</th>
            <?php endif ?>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($r)) { ?>
            <tr>
                <td><?php echo $row['author_id']; ?></td>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['country']; ?></td>
                <td><?php echo $row['bio']; ?></td>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                <td>
                    <a href="edit_Author.php?id=<?php echo $row['author_id']; ?>"><button class="btn btn-edit">Edit</button></a> |
                    <a onclick="return confirm('Are you sure?');"
                       href="delete_Author.php?id=<?php echo $row['author_id']; ?>"><button class="btn btn-delete">Delet</button></a>
                </td>
                <?php endif ?>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
