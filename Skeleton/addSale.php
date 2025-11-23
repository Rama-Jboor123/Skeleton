<?php 
include 'header.php';
require 'db.php';

if($_SERVER['REQUEST_METHOD']=='POST'){

    $fn = mysqli_real_escape_string($conn, $_POST['first_name']);
    $ln = mysqli_real_escape_string($conn, $_POST['last_name']);
    $bookTitle = mysqli_real_escape_string($conn, $_POST['title']);
    $sp = $_POST['sale_price'];
    $ld = $_POST['sale_date'];

    /*** 1. Check Borrower ***/
    $sql = "SELECT borrower_id 
            FROM borrower 
            WHERE first_name='$fn' AND last_name='$ln'";
    $r = mysqli_query($conn, $sql);

    if(mysqli_num_rows($r) == 0){
        die("❌ Error: Borrower does not exist.");
    }

    $row = mysqli_fetch_assoc($r);
    $bId = $row['borrower_id'];

    /*** 2. Check Book ***/
    $sql = "SELECT book_id FROM book WHERE title='$bookTitle'";
    $r = mysqli_query($conn, $sql);

    if(mysqli_num_rows($r) == 0){
        die("❌ Error: Book title not found.");
    }

    $row = mysqli_fetch_assoc($r);
    $bookId = $row['book_id'];

    /*** 3. Insert Sale ***/
    $sql = "INSERT INTO sale (borrower_id, book_id, sale_date, sale_price)
            VALUES ($bId, $bookId, '$ld', '$sp')";

    if(!mysqli_query($conn, $sql)){
        die("❌ Insert Failed: " . mysqli_error($conn));
    }

    header("Location: sales.php");
    exit;
}
?>

<link rel="stylesheet" href="addStyle.css">

<div class="content">
    <div class="add-container">
        <h2>Add New Sale</h2>

        <form method="POST">

            <label>First Name</label>
            <input type="text" name="first_name" required>

            <label>Last Name</label>
            <input type="text" name="last_name" required>

            <label>Book Title</label>
            <input type="text" name="title" required>

            <label>Sale Date</label>
            <input type="date" name="sale_date" required>

            <label>Sale Price</label>
            <input type="number" name="sale_price" required>

            <button type="submit">Save Sale</button>
        </form>

        <a href="sales.php" class="back-btn">Back to Sales</a>
    </div>
</div>
