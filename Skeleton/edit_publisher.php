<?php 
include 'header.php';
require 'db.php';

$id = $_GET['id'];

// Get publisher by ID
$sql = "SELECT * FROM publisher WHERE publisher_id = $id";
$result = mysqli_query($conn, $sql);
$bk = mysqli_fetch_assoc($result);

// Update process
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $t = $_POST['name'];
    $c = $_POST['city'];
    $ty = $_POST['country'];
    $p = $_POST['contact_info'];

    $sql = "
        UPDATE publisher 
        SET 
            name = '$t',
            city = '$c',
            country = '$ty',
            contact_info = '$p'
        WHERE publisher_id = $id
    ";

    mysqli_query($conn, $sql);

    header("Location: publishers.php");
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

    h3 {
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
        <h3>Edit publisher</h3>

        <form method="post">
            <label>Name</label>
            <input name="name" value="<?php echo $bk['name']; ?>">

            <label>City</label>
            <input name="city" value="<?php echo $bk['city']; ?>">

            <label>Country</label>
            <input name="country" value="<?php echo $bk['country']; ?>">

            <label>Contact_info</label>
            <input name="contact_info" value="<?php echo $bk['contact_info']; ?>">

            <button type="submit">Save</button>
        </form>

        <a href="publishers.php" class="back-btn">Back to Publishers</a>
    </div>
</div>
