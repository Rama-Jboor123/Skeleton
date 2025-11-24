<?php
include 'header.php';
include 'minue.php';
require 'db.php';

// تحقق من صلاحية الجلسة (مثال، يمكنك تعديل حسب نظامك)
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'guest'; // أو تسجيل خروج مثلاً
}

// إعداد المتغيرات للبحث
$id = $title = $category = $type = $price = "";
$params = [];
$types = "";
$sql = "SELECT 
            book.book_id,
            book.title,
            book.category,
            book.book_type,
            book.original_price,
            book.available,
            publisher.name AS publisher_name,
            GROUP_CONCAT(CONCAT(author.first_name, ' ', author.last_name) SEPARATOR ', ') AS authors
        FROM book
        LEFT JOIN publisher ON book.publisher_id = publisher.publisher_id
        LEFT JOIN bookauthor ON book.book_id = bookauthor.book_id
        LEFT JOIN author ON bookauthor.author_id = author.author_id
        WHERE 1 ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $sql .= " AND book.book_id = ? ";
        $params[] = $id;
        $types .= "i"; // عدد صحيح
    }

    if (!empty($_POST['title'])) {
        $title = $_POST['title'];
        $sql .= " AND book.title LIKE ? ";
        $params[] = "%$title%";
        $types .= "s";
    }

    if (!empty($_POST['category'])) {
        $category = $_POST['category'];
        $sql .= " AND book.category LIKE ? ";
        $params[] = "%$category%";
        $types .= "s";
    }

    if (!empty($_POST['type'])) {
        $type = $_POST['type'];
        if ($type != "") {
            $sql .= " AND book.book_type = ? ";
            $params[] = $type;
            $types .= "s";
        }
    }

    if (!empty($_POST['price'])) {
        $price = $_POST['price'];
        $sql .= " AND book.original_price = ? ";
        $params[] = $price;
        $types .= "d"; // decimal/float
    }
}

$sql .= " GROUP BY book.book_id ORDER BY book.book_id DESC";

// استخدم prepared statements
$stmt = mysqli_prepare($conn, $sql);

if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Books</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="content">
    <h2>Books</h2>

    <form method="POST" style="margin-bottom: 20px;">
        <div>
            <label for="id">Search by ID</label><br />
            <input type="text" name="id" id="id" value="<?php echo htmlspecialchars($id); ?>">
        </div>

        <div>
            <label for="title">Title</label><br />
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title); ?>">
        </div>

        <div>
            <label for="category">Category</label><br />
            <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($category); ?>">
        </div>

        <div>
            <label>Type</label><br />
            <select name="type">
                <option value="">-- All --</option>
                <option value="Type1" <?php if ($type == 'Type1') echo 'selected'; ?>>Type1</option>
                <option value="Type2" <?php if ($type == 'Type2') echo 'selected'; ?>>Type2</option>
                <option value="Type3" <?php if ($type == 'Type3') echo 'selected'; ?>>Type3</option>
            </select>
        </div>

        <div>
            <label for="price">Price</label><br />
            <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($price); ?>">
        </div>

        <div style="align-self: end; margin-top: 10px;">
            <input type="submit" value="Search" style="background-color: #391B25; color: white;" />
            <input type="reset" value="Refresh" onclick="window.location='books.php'" />
        </div>
    </form>

    <?php if ($_SESSION['role'] == 'admin'): ?>
        <a href="addBook.php"><button class="btn btn-add">Add Book</button></a>
    <?php endif; ?>

    <!-- Books Table -->
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID</th>
                <th>Title</th>
                <th>Authors</th>
                <th>Publisher</th>
                <th>Category</th>
                <th>Type</th>
                <th>Price</th>
                <th>Availability</th>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['book_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['authors']); ?></td>
                    <td><?php echo htmlspecialchars($row['publisher_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                    <td><?php echo htmlspecialchars($row['book_type']); ?></td>
                    <td><?php echo number_format($row['original_price'], 2); ?></td>
                    <td><?php echo $row['available'] ? "<span style='color:green;'>Available</span>" : "<span style='color:red;'>Not Available</span>"; ?></td>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                    <td>
                        <a href="edit_book.php?id=<?php echo $row['book_id']; ?>"><button class="btn btn-edit">Edit</button></a> |
                        <a onclick="return confirm('Are you sure?');" href="delete_book.php?id=<?php echo $row['book_id']; ?>">
                            <button class="btn btn-delete">Delete</button>
                        </a>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php } ?>

            <?php if (mysqli_num_rows($result) === 0) { ?>
                <tr><td colspan="<?php echo ($_SESSION['role'] == 'admin') ? 9 : 8; ?>" style="text-align:center;">No books found.</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
