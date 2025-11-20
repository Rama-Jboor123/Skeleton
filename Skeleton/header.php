<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>
<div style="background-color: #764444ff;margin:0;position: fixed;width:100%;" >
<h2>
    Logged in as: <?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['role']; ?>)
    <!-- | <a href="books.php">Books</a> | <a href="add_book.php">Add Book</a> | <a href="logout.php">Logout</a> -->
</h2>
</div>