<?php
include 'header.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $t = $_POST['first_name'];
      $c = $_POST['last_name'];
     
      $p = $_POST['contact_info'];

      $ty=0;
      if($_POST['type']=='Citizen')
        $ty=3;
      if($_POST['type']=='School Student')
        $ty=1;
      if($_POST['type']=='University Student')
        $ty=2;


      $sql = "INSERT INTO borrower (first_name,last_name,type_id,contact_info)
       VALUES('$t','$c','$ty','$p')";

      $m = mysqli_query($conn, $sql);
      header("Location: borrowers.php");
}
?>
<link rel="stylesheet" href="addStyle.css">


<div class="content">
    <div class="add-container">
        <h2>Add Borrower</h2>
<form method="post">
            <label for="t">First Name</label>
            <input name="first_name" id="t">

            <label for="c">last_name</label>
            <input name="last_name" id="c">

            <label style="margin-left: 200px">Type</label><br>
            <select name="type" style="margin:auto;display:block;width:100%;height:30px;margin-bottom:20px;text-align:center">
                <option value="Citizen">Citizen</option>
                <option value="School Student">School Student</option>
                <option value="University Student">University Student</option>
            </select>
        

            <label for="p">Contact_info</label>
            <input name="contact_info" id="p">

            <button type="submit">Save</button>
        </form>

        <a href="borrowers.php" class="back-btn">Back to Borrower</a>
    </div>
</div>>