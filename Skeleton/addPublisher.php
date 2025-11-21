<?php 
include 'header.php';
require 'db.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
$t = $_POST['name'];
    $c = $_POST['city'];
    $ty = $_POST['country'];
    $p = $_POST['contact_info'];

    $sql="insert into publisher (name,city,country,contact_info) value ('$t','$c','$ty','$p')";
    mysqli_query($conn, $sql);

    header("Location: publishers.php");
    exit;
}
?>

<link rel="stylesheet" href="addStyle.css">

<div class="content">

    <div class="add-container">
        <h2>Add New publisher</h2>

<form method="post">
            <label for="t">Nmae</label>
            <input type="text" name="name" id="t">

            <label for="c">City</label>
            <input type="text" name="city" id="c">

            <label for="ty">Country</label>
            <input type="text" name="country" id="ty">

            <label for="p">Contact_info</label>
            <input type="text" name="contact_info" id="p">

            <button type="submit">Save</button>
        </form>

        <a href="publishers.php" class="back-btn">Back to Publishers</a>
    </div>
</div>