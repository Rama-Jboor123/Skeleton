<?php 
include 'header.php';
require 'db.php';

$id = $_GET['id'];

// Get book by ID
$sql = "select borrower_id,first_name ,last_name,type_name,contact_info
            FROM borrower NATURAL JOIN borrowertype
            WHERE borrower_id='$id'";
$result = mysqli_query($conn, $sql);
$br = mysqli_fetch_assoc($result);

// Update process
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $t = $_POST['first_name'];
    $c = $_POST['last_name'];
    //$ty = $_POST['type'];
    $p = $_POST['contact_info'];
     $ty=0;
      if($_POST['type']=='Citizen')
        $ty=3;
      if($_POST['type']=='School Student')
        $ty=1;
      if($_POST['type']=='University Student')
        $ty=2;

    $sql = "
        UPDATE borrower 
        SET 
            first_name = '$t',
            last_name = '$c',
            type_id = '$ty',
            contact_info = '$p'
        WHERE borrower_id = $id
    ";

    mysqli_query($conn, $sql);

    header("Location: borrowers.php");
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

    .edit-container {
        width: 450px;
        margin:70px ;
        background: rgba(255, 255, 255, 0.6);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    }

    .content h2 {
        text-align: center;
        color: #391B25;
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
    <div class="edit-container">
        <h2>Edit Borrower</h2>
<form method="post">
            <label for="t">First Name</label>
            <input name="first_name" id="t" value="<?php echo $br['first_name']?>">

            <label for="c">last_name</label>
            <input name="last_name" id="c" value="<?php echo $br['last_name']?>">

            <label style="margin-left: 200px">Type</label><br>
            <select name="type" style="margin:auto;display:block;width:100%;height:30px;margin-bottom:20px;text-align:center">
                <option value=""><?php echo $br['type_name']?></option>
                <option value="Citizen">Citizen</option>
                <option value="School Student">School Student</option>
                <option value="University Student">University Student</option>
            </select>
        

            <label for="p">Contact_info</label>
            <input name="contact_info" id="p" value="<?php echo $br['contact_info']?>">

            <button type="submit">Save</button>
        </form>

        <a href="borrowers.php" class="back-btn">Back to Borrower</a>
    </div>
</div>>