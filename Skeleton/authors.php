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

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            background-color: #FEF7E4;
        }

       
        .content {
            margin-left: 250px; 
            padding: 20px;
            width: calc(100% - 250px);
        }

        h2 {
            margin-bottom: 20px;
        }

       
        form {
            background: rgba(255, 255, 255, 0.15);
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        form input, form select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid gray;
        }

        form label {
            font-weight: bold;
            color: #333;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background: #FEF7E4;
            border-radius: 10px;
            overflow: hidden;
        }

        table th {
            background: #391B25;
            color: white;
            padding: 10px;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        table tr:hover {
            background: #c4bbbbff;
        }

        a {
            text-decoration: none;
            color: #4A2C2A;
            font-weight: bold;
        }
        .btn {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    color: white;
    transition: 0.2s;
}


.btn-edit {
    background-color: #2d7d2d; 
}

.btn-edit:hover {
    background-color: #1e571e;
}


.btn-delete {
    background-color: #b32121; 
}

.btn-delete:hover {
    background-color: #7a1616;
}

.btn-add{
   background-color:#391B25;
    margin-bottom: 40px;
}

.btn-add:hover{
   background-color:#391B40;
}


    </style>

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

     <a href="addAuthor.php" ><button class="btn btn-add">Add Author</button></a>

    <!-- Author Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last name</th>
            <th>Country</th>
            <th>Bio</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($r)) { ?>
            <tr>
                <td><?php echo $row['author_id']; ?></td>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['country']; ?></td>
                <td><?php echo $row['bio']; ?></td>
                <td>
                    <a href="edit_Author.php?id=<?php echo $row['author_id']; ?>"><button class="btn btn-edit">Edit</button></a> |
                    <a onclick="return confirm('Are you sure?');"
                       href="delete_Author.php?id=<?php echo $row['author_id']; ?>"><button class="btn btn-delete">Delet</button></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
