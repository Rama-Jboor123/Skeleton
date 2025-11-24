<?php 
include 'header.php';
require 'db.php';

// Store errors
$errors = [];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Invalid ID
if ($id <= 0) {
    die("<h2 style='color:red;margin:50px;'>Invalid Loan ID.</h2>");
}

// Fetch loan info
$sql = "SELECT loan_id, first_name, last_name, title, loan_date, due_date, return_date, period_name
        FROM loan 
        NATURAL JOIN borrower 
        NATURAL JOIN book 
        NATURAL JOIN loanperiod
        WHERE loan_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$bk = mysqli_fetch_assoc($result);

// Loan not found
if (!$bk) {
    die("<h2 style='color:red;margin:50px;'>Loan not found.</h2>");
}

// Initial values
$fn = $bk['first_name'];
$ln = $bk['last_name'];
$title = $bk['title'];
$period = $bk['period_name'];
$loan_date = $bk['loan_date'];
$due_date = $bk['due_date'];
$return_date = $bk['return_date'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Read inputs
    $fn = trim($_POST['first_name']);
    $ln = trim($_POST['last_name']);
    $title = trim($_POST['title']);
    $period = $_POST['period_name'];
    $loan_date = $_POST['loan_date'];
    $due_date = $_POST['due_date'];
    $return_date = $_POST['return_date'];

    // Validation
    if (empty($fn)) $errors[] = "First Name is required.";
    if (empty($ln)) $errors[] = "Last Name is required.";
    if (empty($title)) $errors[] = "Book title is required.";
    if (empty($period)) $errors[] = "Loan period is required.";
    if (empty($loan_date)) $errors[] = "Loan date is required.";
    if (empty($due_date)) $errors[] = "Due date is required.";

    // Validate borrower
    $sql = "SELECT borrower_id FROM borrower WHERE first_name = ? AND last_name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $fn, $ln);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    if (!$row) {
        $errors[] = "Borrower not found.";
    } else {
        $bId = $row['borrower_id'];
    }

    // Validate book
    $sql = "SELECT book_id FROM book WHERE title = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $title);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    if (!$row) {
        $errors[] = "Book not found.";
    } else {
        $bookId = $row['book_id'];
    }

    // Validate period
    $sql = "SELECT period_id FROM loanperiod WHERE period_name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $period);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    if (!$row) {
        $errors[] = "Loan period not found.";
    } else {
        $pId = $row['period_id'];
    }

    // If no errors → Update
    if (empty($errors)) {

        $sql = "UPDATE loan
                SET borrower_id=?, book_id=?, period_id=?, loan_date=?, due_date=?, return_date=?
                WHERE loan_id=?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiisssi", 
            $bId, $bookId, $pId, $loan_date, $due_date, $return_date, $id);
        mysqli_stmt_execute($stmt);

        header("Location: loans.php");
        exit;
    }
}
?>

<link rel="stylesheet" href="addStyle.css">

<div class="content">
    <div class="add-container">

        <h2>Edit Loan</h2>

        <?php if (!empty($errors)): ?>
            <div style="
                background:#ffe6e6;
                padding:12px;
                margin-bottom:15px;
                border-left:4px solid #b30000;
            ">
                <strong>Please fix the following:</strong>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo $e; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">

            <label>First Name</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($fn); ?>" required>

            <label>Last Name</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($ln); ?>" required>

            <label>Book Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

            <label>Period Name</label>
            <select name="period_name" required style="
                width: 100%;
                height: 38px;
                padding: 10px;
                border-radius: 6px;
                border: 1px solid #999;">
                <option value="<?php echo $period; ?>"><?php echo $period; ?></option>
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
            <input type="date" name="loan_date" value="<?php echo $loan_date; ?>" required>

            <label>Due Date</label>
            <input type="date" name="due_date" value="<?php echo $due_date; ?>" required>

            <label>Return Date</label>
            <input type="date" name="return_date" value="<?php echo $return_date; ?>">

            <button type="submit">Save Loan</button>
        </form>

        <a href="loans.php" class="back-btn">Back to Loans</a>
    </div>
</div>
