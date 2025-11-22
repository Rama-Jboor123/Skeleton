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
    <title>Borrowers</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="content">
    <h2>Borrowers</h2>

    <?php
    
    $sql = "select borrower_id,first_name ,last_name,type_name,contact_info
            FROM borrower NATURAL JOIN borrowertype
            WHERE 1";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $sql .= " AND borrower_id = '$id'";
        }

         if (!empty($_POST['first_name'])) {
            $fn = $_POST['first_name'];
            $sql .= " AND first_name LIKE '%$fn%'";
        }

        if (!empty($_POST['last_name'])) {
            $ls = $_POST['last_name'];
            $sql .= " AND last_name LIKE '%$ls%'";
        }


        if (!empty($_POST['type'])) {
            $type = $_POST['type'];
            if ($type != "") {
                $sql .= " AND type_name = '$type'";
            }
        }

         if (!empty($_POST['contact_info'])) {
            $contact_info = $_POST['contact_info'];
            $sql .= " AND contact_info like '%$contact_info%'";
        }
    }

     $sql .= " ORDER BY borrower_id ";
   
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
            <label>Type</label><br>
            <select name="type">
                <option value="">-- All --</option>
                <option value="Citizen">Citizen</option>
                <option value="School Student">School Student</option>
                <option value="University Student">University Student</option>
            </select>
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

     <a href="addBorrower.php" ><button class="btn btn-add">Add Borrower</button></a>

    <!-- Borrower Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Frist Name</th>
            <th>Last Name</th>
            <th>Type</th>
            <th>Contact_info</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($r)) { ?>
            <tr>
                <td><?php echo $row['borrower_id']; ?></td>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['type_name']; ?></td>
                <td><?php echo $row['contact_info']; ?></td>
                <td>
                    <a href="edit_borrower.php?id=<?php echo $row['borrower_id']; ?>"><button class="btn btn-edit">Edit</button></a> |
                    <a onclick="return confirm('Are you sure?');"
                       href="delete_borrower.php?id=<?php echo $row['borrower_id']; ?>"><button class="btn btn-delete">Delet</button></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
