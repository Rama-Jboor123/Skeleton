<?php 
include 'header.php';
require 'db.php';

$errors = [];  

// To keep form values after validation error
$fn = $ln = $bookTitle = $periodName = $ld = $dd = $rd = "";

if($_SERVER['REQUEST_METHOD']=='POST'){

    // Read & sanitize input
    $fn = trim(mysqli_real_escape_string($conn, $_POST['first_name']));
    $ln = trim(mysqli_real_escape_string($conn, $_POST['last_name']));
    $bookTitle = trim(mysqli_real_escape_string($conn, $_POST['title']));
    $periodName = $_POST['period_name'] ?? "";
    $ld = $_POST['loan_date'] ?? "";
    $dd = $_POST['due_date'] ?? "";
    $rd = $_POST['return_date'] ?? "";

    // Validation
    if (empty($fn)) $errors[] = "First name is required.";
    if (empty($ln)) $errors[] = "Last name is required.";
    if (empty($bookTitle)) $errors[] = "Book title is required.";
    if (empty($periodName)) $errors[] = "You must select a loan period.";
    if (empty($ld)) $errors[] = "Loan date is required.";
    if (empty($dd)) $errors[] = "Due date is required.";

    // Check borrower exists
    if (empty($errors)) {
        $sql = "SELECT borrower_id 
                FROM borrower 
                WHERE first_name='$fn' AND last_name='$ln'";
        $r = mysqli_query($conn, $sql);

        if (mysqli_num_rows($r) == 0) {
            $errors[] = "Borrower not found.";
        } else {
            $row = mysqli_fetch_assoc($r);
            $bId = $row['borrower_id'];
        }
    }

    // Check book exists
    if (empty($errors)) {
        $sql = "SELECT book_id FROM book WHERE title='$bookTitle'";
        $r = mysqli_query($conn, $sql);

        if (mysqli_num_rows($r) == 0) {
            $errors[] = "Book title not found.";
        } else {
            $row = mysqli_fetch_assoc($r);
            $bookId = $row['book_id'];
        }
    }

    // Check period exists
    if (empty($errors)) {
        $sql = "SELECT period_id FROM loanperiod WHERE period_name='$periodName'";
        $r = mysqli_query($conn, $sql);

        if (mysqli_num_rows($r) == 0) {
            $errors[] = "Loan period not valid.";
        } else {
            $row = mysqli_fetch_assoc($r);
            $pId = $row['period_id'];
        }
    }

    // Insert loan if no errors
    if (empty($errors)) {
        $sql = "INSERT INTO loan (borrower_id, book_id, period_id, loan_date, due_date, return_date)
                VALUES ('$bId','$bookId','$pId','$ld','$dd','$rd')";

        mysqli_query($conn, $sql);

        header("Location: loans.php");
        exit;
    }
}

// Fetch loan periods for the dropdown
$periods_result = mysqli_query($conn, "SELECT period_name FROM loanperiod ORDER BY period_name");

?>

<link rel="stylesheet" href="addStyle.css">

<div class="content">
    <div class="add-container">
        <h2>Add New Loan</h2>

        <!-- Error Message Box -->
        <?php if (!empty($errors)): ?>
            <div style="background:#ffe6e6;border-left:4px solid #b30000;padding:10px;margin-bottom:20px;">
                <strong>Fix the following errors:</strong>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo htmlspecialchars($e); ?></li>
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
            <input type="text" name="title" value="<?php echo htmlspecialchars($bookTitle); ?>" required>

            <label>Loan Period</label>
            <select name="period_name" required>
                <option value="">-- Select Period --</option>
                <?php while ($period = mysqli_fetch_assoc($periods_result)): ?>
                    <option value="<?php echo htmlspecialchars($period['period_name']); ?>" <?php 
                        if ($periodName == $period['period_name']) echo 'selected'; 
                    ?>>
                        <?php echo htmlspecialchars($period['period_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Loan Date</label>
            <input type="date" name="loan_date" value="<?php echo htmlspecialchars($ld); ?>" required>

            <label>Due Date</label>
            <input type="date" name="due_date" value="<?php echo htmlspecialchars($dd); ?>" required>

            <label>Return Date</label>
            <input type="date" name="return_date" value="<?php echo htmlspecialchars($rd); ?>">

            <button type="submit">Add Loan</button>
        </form>
        
        <a href="loans.php" class="back-btn">Back to Loans</a>
    </div>
</div>
