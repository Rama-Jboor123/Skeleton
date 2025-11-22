<?php 
include 'header.php';
require 'db.php';

if($_SERVER['REQUEST_METHOD']=='POST'){

    
    $fn = $_POST['first_name'];
    $ln = $_POST['last_name'];
    $bookTitle = $_POST['title'];
    $periodName = $_POST['period_name'];

    $ld = $_POST['loan_date'];
    $dd = $_POST['due_date'];
    $rd = $_POST['return_date'];

    
    $sql = "SELECT borrower_id 
            FROM borrower 
            WHERE first_name='$fn' AND last_name='$ln'";
    $r = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($r);
    $bId = $row['borrower_id'];

    
    $sql = "SELECT book_id FROM book WHERE title='$bookTitle'";
    $r = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($r);
    $bookId = $row['book_id'];

    
    $sql = "SELECT period_id FROM loanperiod WHERE period_name='$periodName'";
    $r = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($r);
    $pId = $row['period_id'];

    
    $sql = "INSERT INTO loan (borrower_id, book_id, period_id, loan_date, due_date, return_date)
            VALUES ('$bId','$bookId','$pId','$ld','$dd','$rd')";
    mysqli_query($conn, $sql);

    header("Location: loans.php");
    exit;
}
?>
<link rel="stylesheet" href="addStyle.css">

<div class="content">
    <div class="add-container">
        <h2>Add New Loan</h2>

        <form method="POST">

            <label>First Name</label>
            <input type="text" name="first_name" required>

            <label>Last Name</label>
            <input type="text" name="last_name" required>

            <label>Book Title</label>
            <input type="text" name="title" required>

            <label>Period Name</label>
<select name="period_name" id="period" required 
        style="
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px 0;
            border: 1px solid #999;
            border-radius: 6px;
            font-size: 15px;
            background-color: white;
        ">
    <option value="">-- Select Period --</option>
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
            <input type="date" name="loan_date" required>

            <label>Due Date</label>
            <input type="date" name="due_date" required>

            <label>Return Date</label>
            <input type="date" name="return_date">

            <button type="submit">Save Loan</button>
        </form>

        <a href="loans.php" class="back-btn">Back to Loans</a>
    </div>
</div>

