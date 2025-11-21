<?php 
include 'header.php';
require 'db.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
$t = $_POST['title'];
    $c = $_POST['category'];
    $ty = $_POST['book_type'];
    $p = $_POST['original_price'];

    $sql="insert into book (title,category,book_type,original_price) value ('$t','$c','$ty','$p')";
    mysqli_query($conn, $sql);

    header("Location: books.php");
    exit;
}
?>
<link rel="stylesheet" href="addStyle.css">

<div class="content">

    <div class="add-container">
        <h2>Add New Book</h2>

<form method="post">
            <label for="t">Title</label>
            <input name="title" id="t">

            <label for="c">Category</label>
            <input name="category" id="c">

            <label for="ty">Type</label>
            <input name="book_type" id="ty">

            <label for="p">Price</label>
            <input name="original_price" id="p">

            <button type="submit">Save</button>
        </form>

        <a href="books.php" class="back-btn">Back to Books</a>
    </div>
</div>