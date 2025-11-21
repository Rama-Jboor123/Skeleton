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