<?php 
include 'header.php';
require 'db.php';

$errors = [];
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("<h2 style='color:red;margin:50px;'>Invalid Book ID.</h2>");
}

// Fetch book
$sql = "SELECT * FROM book WHERE book_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$bk = mysqli_fetch_assoc($result);

if (!$bk) {
    die("<h2 style='color:red;margin:50px;'>Book not found.</h2>");
}

// Fetch current authors for this book
$author_sql = "SELECT author_id FROM bookauthor WHERE book_id = ?";
$stmt_auth = mysqli_prepare($conn, $author_sql);
mysqli_stmt_bind_param($stmt_auth, "i", $id);
mysqli_stmt_execute($stmt_auth);
$result_auth = mysqli_stmt_get_result($stmt_auth);

$current_authors = [];
while ($row = mysqli_fetch_assoc($result_auth)) {
    $current_authors[] = $row['author_id'];
}

// Prepare values (initial OR after POST)
$title = $bk['title'];
$category = $bk['category'];
$type = $bk['book_type'];
$price = $bk['original_price'];
$publisher_id = $bk['publisher_id'] ?? 0;
$available = $bk['available'] ?? 1; // assuming 1 = available

// Get all publishers
$publishers = mysqli_query($conn, "SELECT publisher_id, name FROM publisher ORDER BY name");

// Get all authors
$authors = mysqli_query($conn, "SELECT author_id, first_name, last_name FROM author ORDER BY last_name, first_name");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Read inputs
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $type = trim($_POST['book_type']);
    $price = trim($_POST['original_price']);
    $publisher_id = intval($_POST['publisher_id']);
    $available = isset($_POST['available']) ? 1 : 0;
    $selected_authors = $_POST['authors'] ?? [];

    // Validation
    if (empty($title)) $errors[] = "Title is required.";
    if (empty($category)) $errors[] = "Category is required.";
    if (empty($type)) $errors[] = "Book Type is required.";
    if (!is_numeric($price) || $price < 0) $errors[] = "Price must be a valid non-negative number.";
    if ($publisher_id <= 0) $errors[] = "Please select a publisher.";
    if (empty($selected_authors)) $errors[] = "Please select at least one author.";

    // If no errors → update
    if (empty($errors)) {

        $sql = "UPDATE book 
                SET title = ?, category = ?, book_type = ?, original_price = ?, publisher_id = ?, available = ?
                WHERE book_id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssdiii", $title, $category, $type, $price, $publisher_id, $available, $id);
        mysqli_stmt_execute($stmt);

        // Update authors: delete old and insert new
        mysqli_query($conn, "DELETE FROM bookauthor WHERE book_id = $id");

        foreach ($selected_authors as $auth_id) {
            $auth_id = intval($auth_id);
            if ($auth_id > 0) {
                $insert_auth = "INSERT INTO bookauthor (book_id, author_id) VALUES (?, ?)";
                $stmt_insert = mysqli_prepare($conn, $insert_auth);
                mysqli_stmt_bind_param($stmt_insert, "ii", $id, $auth_id);
                mysqli_stmt_execute($stmt_insert);
            }
        }

        header("Location: books.php");
        exit;
    }
}

?>

<style>
/* ... (احتفظ بنفس التنسيقات اللي في كودك) */
</style>

<div class="content">
    <div class="edit-container">
        <h3>Edit Book</h3>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <strong>Please fix the following errors:</strong>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post">
            <label>Title</label>
            <input name="title" value="<?php echo htmlspecialchars($title); ?>" required>

            <label>Category</label>
            <input name="category" value="<?php echo htmlspecialchars($category); ?>" required>

            <label>Type</label>
            <input name="book_type" value="<?php echo htmlspecialchars($type); ?>" required>

            <label>Price</label>
            <input name="original_price" value="<?php echo htmlspecialchars($price); ?>" required>

            <label>Publisher</label>
            <select name="publisher_id" required>
                <option value="">-- Select Publisher --</option>
                <?php foreach ($publishers as $pub): ?>
                    <option value="<?php echo $pub['publisher_id']; ?>" 
                        <?php if ($pub['publisher_id'] == $publisher_id) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($pub['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Authors</label>
            <select name="authors[]" multiple size="5" required>
                <?php foreach ($authors as $author): ?>
                    <option value="<?php echo $author['author_id']; ?>" 
                        <?php if (in_array($author['author_id'], $selected_authors ?? $current_authors)) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($author['first_name'] . ' ' . $author['last_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Available</label>
            <input type="checkbox" name="available" <?php echo ($available ? 'checked' : ''); ?>>

            <button type="submit">Save</button>
        </form>

        <a href="books.php" class="back-btn">Back to Books</a>
    </div>
</div>
