<?php
include 'header.php';
include 'minue.php';
require 'db.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loans</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="content">
    <h2>Loans</h2>

    <?php
    
    $sql = "SELECT loan_id,first_name,last_name,title,loan_date,due_date,return_date,period_name
            FROM loan NATURAL JOIN borrower NATURAL JOIN book NATURAL join loanperiod
            WHERE 1";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $sql .= " AND loan_id = '$id'";
        }

        if (!empty($_POST['first_name'])) {
            $fn = $_POST['first_name'];
            $sql .= " AND first_name LIKE '%$fn%'";
        }

        if (!empty($_POST['last_name'])) {
            $ln = $_POST['last_name'];
            $sql .= " AND last_name LIKE '%$ln%'";
        }

        if (!empty($_POST['title'])) {
            $title= $_POST['title'];
        
                $sql .= " AND title like '%$title%'";
            
        }

        if (!empty($_POST['loan_date'])) {
            $ld= $_POST['loan_date'];
            $sql .= " AND loan_dat Like '%$ld%'";
        }

        if (!empty($_POST['due_date'])) {
            $dt= $_POST['due_date'];
            $sql .= " AND due_date Like '%$dt%'";
        }

        if (!empty($_POST['period_name'])) {
            $pn= $_POST['period_name'];
            $sql .= " AND period_name Like '%$pn%'";
        }
    }

    $sql .= " ORDER BY loan_id";

    $r = mysqli_query($conn, $sql);
    ?>
    
    
    <form method="POST">
        <div>
            <label for="id">Search by ID</label><br>
            <input type="text" name="id" id="id">
        </div>

         <div>
            <label for="fn">First name</label><br>
            <input type="text" name="first_name" id="fn">
        </div>

        <div>
            <label for="ls">Last name</label><br>
            <input type="text" name="last_name" id="ls">
        </div>

        <div>
            <label for="title">Title</label><br>
            <input type="text" name="title" id="title">
        </div>

        <div>
          <label>Period Name</label>
<select name="period_name" id="period" 
        style="
            width: 100%;
            height:38px;
            padding: 10px;
            margin: 0 0 15px 0;
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

        </div>


        <div>
            <label>Loan Date</label><br>
            <input type="date" name="loan_date" >
        </div>

        <div>
            <label>Due Date</label><br>
            <input type="date" name="due_date" >
        </div>

        <div style="align-self: end;">
            <input type="submit" value="Search" style="background-color: #391B25;color:white">
            <input type="reset" value="Refresh">
        </div>
    </form>

     <a href="addLoan.php" ><button class="btn btn-add">Add Loan</button></a>

    <!-- Loans Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Borrower Name</th>
            <th>Book Title</th>
            <th>Loan Date</th>
            <th>Due Date</th>
            <th>Period Name</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($r)) { ?>
            <tr>
                <td><?php echo $row['loan_id']; ?></td>
                <td><?php echo $row['first_name']." ". $row['last_name']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['loan_date']; ?></td>
                <td><?php echo $row['due_date']; ?></td>
                <td><?php echo $row['period_name']; ?></td>
                <td>
                    <a href="edit_loan.php?id=<?php echo $row['loan_id']; ?>"><button class="btn btn-edit">Edit</button></a> |
                    <a onclick="return confirm('Are you sure?');"
                       href="delete_loan.php?id=<?php echo $row['loan_id']; ?>"><button class="btn btn-delete">Delet</button></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
