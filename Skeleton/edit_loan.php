<?php 
include 'header.php';
require 'db.php';

$id = $_GET['id'];

$sql = "SELECT loan_id,first_name,last_name,title,loan_date,due_date,return_date,period_name
        FROM loan 
        NATURAL JOIN borrower 
        NATURAL JOIN book 
        NATURAL JOIN loanperiod
        WHERE loan_id = $id";

$result = mysqli_query($conn, $sql);
$bk = mysqli_fetch_assoc($result);


if($_SERVER['REQUEST_METHOD']=='POST'){

    $fn = $_POST['first_name'];
    $ln = $_POST['last_name'];
    $bookTitle = $_POST['title'];
    $periodName = $_POST['period_name'];

    $ld = $_POST['loan_date'];
    $dd = $_POST['due_date'];
    $rd = $_POST['return_date'];

    // Get borrower ID
    $sql = "SELECT borrower_id FROM borrower 
            WHERE first_name='$fn' AND last_name='$ln'";
    $r = mysqli_query($conn, $sql);
    $bId = mysqli_fetch_assoc($r)['borrower_id'];

    // Get book ID
    $sql = "SELECT book_id FROM book WHERE title='$bookTitle'";
    $r = mysqli_query($conn, $sql);
    $bookId = mysqli_fetch_assoc($r)['book_id'];

    // Get period ID
    $sql = "SELECT period_id FROM loanperiod WHERE period_name='$periodName'";
    $r = mysqli_query($conn, $sql);
    $pId = mysqli_fetch_assoc($r)['period_id'];

    // Update loan
    $sql = "
        UPDATE loan 
        SET 
            borrower_id = '$bId',
            book_id = '$bookId',
            period_id = '$pId',
            loan_date = '$ld',
            due_date = '$dd',
            return_date = '$rd'
        WHERE loan_id = $id
    ";

    mysqli_query($conn, $sql);

    header("Location: loans.php");
    exit;
}
?>

<link rel="stylesheet" href="addStyle.css">

<div class="content">
    <div class="add-container">

        <h2>Edit Loan</h2>

        <form method="POST">

            <label>First Name</label>
            <input type="text" name="first_name" required value="<?php echo $bk['first_name']; ?>">

            <label>Last Name</label>
            <input type="text" name="last_name" required value="<?php echo $bk['last_name']; ?>">

            <label>Book Title</label>
            <input type="text" name="title" required value="<?php echo $bk['title']; ?>">

            <label>Period Name</label>
            <select name="period_name" id="period"  style="
            width: 100%;
            height:38px;
            padding: 10px;
            margin: 0 0 15px 0;
            border: 1px solid #999;
            border-radius: 6px;
            font-size: 15px;
            background-color: white;">
                <option value="<?php echo $bk['period_name']; ?>"><?php echo $bk['period_name']; ?></option>
                <option value="3 Days">3 Days</option>
                <option value="1 Week">1 Week</option>
                <option value="2 Weeks">2 Weeks</option>
                <option value="3 Weeks">3 Weeks</option>
                <option value="1 Month">1 Month</option>
                <option value="6 Weeks">6 Weeks</option>
                <option value="2 Months">2 Months</option>
                <option value="3 Months">3 Months</option>
                <option value="Half Year">Half Year</option>
                <option value="Full Year">Full Year</option>
            </select>

            <label>Loan Date</label>
            <input type="date" name="loan_date" required value="<?php echo $bk['loan_date']; ?>">

            <label>Due Date</label>
            <input type="date" name="due_date" required value="<?php echo $bk['due_date']; ?>">

            <label>Return Date</label>
            <input type="date" name="return_date" value="<?php echo $bk['return_date']; ?>">

            <button type="submit">Save Loan</button>
        </form>

        <a href="loans.php" class="back-btn">Back to Loans</a>
    </div>
</div>
