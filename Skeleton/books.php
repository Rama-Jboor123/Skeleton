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
    <title>Books</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="content">
    <h2>Books</h2>

    <?php
    
    $sql = "SELECT * FROM book WHERE 1";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $sql .= " AND book_id = '$id'";
        }

        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
            $sql .= " AND title LIKE '%$title%'";
        }

        if (!empty($_POST['category'])) {
            $category = $_POST['category'];
            $sql .= " AND category LIKE '%$category%'";
        }

        if (!empty($_POST['type'])) {
            $type = $_POST['type'];
            if ($type != "") {
                $sql .= " AND book_type = '$type'";
            }
        }

        if (!empty($_POST['price'])) {
            $price = $_POST['price'];
            $sql .= " AND original_price = '$price'";
        }
    }

    $sql .= " ORDER BY book_id DESC";

    $r = mysqli_query($conn, $sql);
    ?>
    
    
    <form method="POST">
        <div>
            <label for="id">Search by ID</label><br>
            <input type="text" name="id" id="id">
        </div>

        <div>
            <label for="title">Title</label><br>
            <input type="text" name="title" id="title">
        </div>

        <div>
            <label for="category">Category</label><br>
            <input type="text" name="category" id="category">
        </div>


        <div>
            <label>Type</label><br>
            <select name="type">
                <option value="">-- All --</option>
                <option value="type1">Type1</option>
                <option value="type2">Type2</option>
                <option value="type3">Type3</option>
            </select>
        </div>

        <div>
            <label for="price">Price</label><br>
            <input type="number" name="price" id="price">
        </div>

        <div style="align-self: end;">
            <input type="submit" value="Search" style="background-color: #391B25;color:white">
            <input type="reset" value="Refresh">
        </div>
    </form>

     <a href="addBook.php" ><button class="btn btn-add">Add Book</button></a>

    <!-- Books Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Type</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($r)) { ?>
            <tr>
                <td><?php echo $row['book_id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['book_type']; ?></td>
                <td><?php echo $row['original_price']; ?></td>
                <td>
                    <a href="edit_book.php?id=<?php echo $row['book_id']; ?>"><button class="btn btn-edit">Edit</button></a> |
                    <a onclick="return confirm('Are you sure?');"
                       href="delete_book.php?id=<?php echo $row['book_id']; ?>"><button class="btn btn-delete">Delet</button></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
