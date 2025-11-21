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

<style>
    body {
        background-color: #FEF7E4;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
    }

    .content {
        margin-left: 350px;
        padding: 20px;
        width: calc(100% - 250px);
    }

    .add-container {
        width: 450px;
        margin: 70px ;
        background: rgba(255, 255, 255, 0.6);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    }

    h2 {
        text-align: center;
        color: #391B25;
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        color: #391B25;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 8px 0 15px 0;
        border: 1px solid #999;
        border-radius: 6px;
        font-size: 15px;
    }

    button {
        width: 100%;
        background-color: #2d7d2d;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        font-weight: bold;
    }

    button:hover {
        background-color: #1e571e;
    }

    .back-btn {
        margin-top: 10px;
        display: block;
        text-align: center;
        background-color: #b32121;
        padding: 10px;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }

    .back-btn:hover {
        background-color: #7a1616;
    }
</style>

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