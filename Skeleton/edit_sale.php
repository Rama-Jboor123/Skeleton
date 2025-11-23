<?php 
include 'header.php';
require 'db.php';

$id = $_GET['id'];

$sql = "SELECT sale_id, first_name, last_name, title, sale_price, sale_date
            FROM sale 
            NATURAL JOIN borrower 
            NATURAL JOIN book 
            WHERE sale_id=$id";

$result = mysqli_query($conn, $sql);
$bk = mysqli_fetch_assoc($result);


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
    $sql = "  UPDATE sale
        SET 
            borrower_id = '$bId',
            book_id = '$bookId',
            sale_date = '$ld',
            sale_price='$sp'
        WHERE sale_id = $id";

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

        <h2>Edit Sale</h2>

        <form method="POST">

            <label>First Name</label>
            <input type="text" name="first_name" required value="<?php echo $bk['first_name']; ?>">

            <label>Last Name</label>
            <input type="text" name="last_name" required value="<?php echo $bk['last_name']; ?>">

            <label>Book Title</label>
            <input type="text" name="title" required value="<?php echo $bk['title']; ?>">

           
            <label>Sale Date</label>
            <input type="date" name="sale_date" required value="<?php echo $bk['sale_date']; ?>">

            <label>Sale Price</label>
            <input type="number" name="sale_price" required value="<?php echo $bk['sale_price']; ?>">

           

            <button type="submit">Save Sale</button>
        </form>

        <a href="sales.php" class="back-btn">Back to Sales</a>
    </div>
</div>
<!-- C:\Users\Mtech\Downloads\Skeleton\Skeleton\edit_sale.php on line 58 -->