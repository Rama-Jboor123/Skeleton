<?php 
include 'header.php';
require 'db.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
$t = $_POST['first_name'];
    $c = $_POST['last_name'];
    $ty = $_POST['country'];
    $p = $_POST['bio'];

    $sql="insert into author (first_name,last_name,country,bio) value ('$t','$c','$ty','$p')";
    mysqli_query($conn, $sql);

    header("Location: authors.php");
    exit;
}
?>

<link rel="stylesheet" href="addStyle.css">

<div class="content">

    <div class="add-container">
        <h2>Add New Book</h2>

<form method="POST">
        
            

    
            <label for="fn">First name</label><br>
            <input type="text" name="first_name" id="fn">
      

        
            <label for="ls">Last name</label><br>
            <input type="text" name="last_name" id="ls">
        

       
            <label for="cn">Country</label><br>
            <input type="text" name="country" id="cn">
     

        
        
            <label for="b">Bio</label><br>
            <input type="text" name="bio" id="b">
       

        <button type="submit">Save</button>
    </form>


        <a href="authors.php" class="back-btn">Back to Authors</a>
    </div>
</div>