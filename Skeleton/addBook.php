<?php 
include 'header.php';
require 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // sanitize input
    $t  = trim(htmlspecialchars($_POST['title']));
    $c  = trim(htmlspecialchars($_POST['category']));
    $ty = trim(htmlspecialchars($_POST['book_type']));
    $p  = trim(htmlspecialchars($_POST['original_price']));
    $pub_id = intval($_POST['publisher_id'] ?? 0);
    $available = isset($_POST['available']) ? 1 : 0;

    // المؤلفين المختارين (مصفوفة)
    $authors = $_POST['authors'] ?? [];

    // validation
    if (empty($t)) $errors[] = "Title is required.";
    if (empty($c)) $errors[] = "Category is required.";
    if (empty($ty)) $errors[] = "Book type is required.";
    if (empty($p)) $errors[] = "Price is required.";
    if ($pub_id <= 0) $errors[] = "Please select a publisher.";
    if (empty($authors)) $errors[] = "Please select at least one author.";

    if (!empty($p) && !is_numeric($p)) {
        $errors[] = "Price must be a numeric value.";
    }

    // check duplicates
    if (empty($errors)) {
        $check = "SELECT * FROM book WHERE title='$t' AND book_type='$ty'";
        $res = mysqli_query($conn, $check);

        if (mysqli_num_rows($res) > 0) {
            $errors[] = "This book already exists.";
        }
    }

    // insert if no errors
    if (empty($errors)) {
        $sql = "INSERT INTO book (title, category, book_type, original_price, publisher_id, available)
                VALUES ('$t', '$c', '$ty', '$p', $pub_id, $available)";
        if (mysqli_query($conn, $sql)) {
            $book_id = mysqli_insert_id($conn);

            // حفظ المؤلفين المرتبطين بالكتاب
            foreach ($authors as $author_id) {
                $author_id = intval($author_id);
                if ($author_id > 0) {
                    $sql_auth = "INSERT INTO bookauthor (book_id, author_id) VALUES ($book_id, $author_id)";
                    mysqli_query($conn, $sql_auth);
                }
            }

            header("Location: books.php");
            exit;
        } else {
            $errors[] = "Error saving the book.";
        }
    }
}

// Get publishers list for dropdown
$publisher_result = mysqli_query($conn, "SELECT publisher_id, name FROM publisher ORDER BY name");

// Get authors list for multi-select
$author_result = mysqli_query($conn, "SELECT author_id, first_name, last_name FROM author ORDER BY last_name, first_name");
?>

<link rel="stylesheet" href="addStyle.css">

<div class="content">

    <div class="add-container">
        <h2>Add New Book</h2>

        <!-- Display errors -->
        <?php if (!empty($errors)): ?>
            <div style="background:#ffdddd; padding:10px; border-left:4px solid red; margin-bottom:15px;">
                <strong>Error:</strong>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo $e; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post">

            <label for="t">Title</label>
            <input name="title" id="t" value="<?php echo $_POST['title'] ?? ''; ?>" required>

            <label for="c">Category</label>
            <input name="category" id="c" value="<?php echo $_POST['category'] ?? ''; ?>" required>

            <label for="ty">Type</label>
            <input name="book_type" id="ty" value="<?php echo $_POST['book_type'] ?? ''; ?>" required>

            <label for="p">Price</label>
            <input name="original_price" id="p" value="<?php echo $_POST['original_price'] ?? ''; ?>" required>

            <label for="publisher_id">Publisher</label>
            <select name="publisher_id" id="publisher_id" required>
                <option value="">-- Select Publisher --</option>
                <?php while ($pub = mysqli_fetch_assoc($publisher_result)): ?>
                    <option value="<?php echo $pub['publisher_id']; ?>" <?php 
                        if (isset($_POST['publisher_id']) && $_POST['publisher_id'] == $pub['publisher_id']) 
                            echo 'selected'; 
                    ?>>
                        <?php echo htmlspecialchars($pub['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="authors">Authors</label>
            <select name="authors[]" id="authors" multiple size="5" required>
                <?php while ($author = mysqli_fetch_assoc($author_result)): ?>
                    <option value="<?php echo $author['author_id']; ?>" <?php 
                        if (!empty($_POST['authors']) && in_array($author['author_id'], $_POST['authors'])) 
                            echo 'selected'; 
                    ?>>
                        <?php echo htmlspecialchars($author['first_name'] . ' ' . $author['last_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="available">Available</label>
            <input type="checkbox" name="available" id="available" <?php if (!isset($_POST['available']) || $_POST['available']) echo 'checked'; ?>>

            <button type="submit">Save</button>
        </form>

        <a href="books.php" class="back-btn">Back to Books</a>
    </div>
</div>
