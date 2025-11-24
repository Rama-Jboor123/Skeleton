<?php 
include 'header.php';
require 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize input
    $t  = trim(htmlspecialchars($_POST['first_name']));
    $c  = trim(htmlspecialchars($_POST['last_name']));
    $ty = trim(htmlspecialchars($_POST['country']));
    $p  = trim(htmlspecialchars($_POST['bio']));

    // Validation
    if (empty($t)) $errors[] = "First name is required.";
    if (empty($c)) $errors[] = "Last name is required.";
    if (empty($ty)) $errors[] = "Country is required.";
    if (empty($p)) $errors[] = "Bio cannot be empty.";

    // Optional: check duplicate author
    if (empty($errors)) {
        $check = "SELECT * FROM author WHERE first_name='$t' AND last_name='$c'";
        $res = mysqli_query($conn, $check);

        if (mysqli_num_rows($res) > 0) {
            $errors[] = "This author already exists in the database.";
        }
    }

    // If no errors → insert
    if (empty($errors)) {
        $sql = "INSERT INTO author (first_name, last_name, country, bio) 
                VALUES ('$t', '$c', '$ty', '$p')";
        mysqli_query($conn, $sql);

        header("Location: authors.php");
        exit;
    }
}
?>

<link rel="stylesheet" href="addStyle.css">

<div class="content">
    <div class="add-container">
        <h2>Add New Author</h2>

        <!-- Display errors if exist -->
        <?php if (!empty($errors)): ?>
            <div style="background-color:#ffdddd; padding:10px; border-left:4px solid red; margin-bottom:15px;">
                <strong>Error:</strong>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo $e; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">

            <label for="fn">First name</label>
            <input type="text" name="first_name" id="fn" value="<?php echo $_POST['first_name'] ?? ''; ?>">

            <label for="ls">Last name</label>
            <input type="text" name="last_name" id="ls" value="<?php echo $_POST['last_name'] ?? ''; ?>">

            <label for="cn">Country</label>
            <input type="text" name="country" id="cn" value="<?php echo $_POST['country'] ?? ''; ?>">

            <label for="b">Bio</label>
            <input type="text" name="bio" id="b" value="<?php echo $_POST['bio'] ?? ''; ?>">

            <button type="submit">Save</button>

        </form>

        <a href="authors.php" class="back-btn">Back to Authors</a>
    </div>
</div>
