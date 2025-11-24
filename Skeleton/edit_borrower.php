<?php 
include 'header.php';
require 'db.php';

// To store errors
$errors = [];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// If invalid ID
if ($id <= 0) {
    die("<h2 style='color:red;margin:50px;'>Invalid Borrower ID.</h2>");
}

// Fetch borrower info
$sql = "SELECT borrower_id, first_name, last_name, type_id, type_name, contact_info
        FROM borrower 
        NATURAL JOIN borrowertype
        WHERE borrower_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$br = mysqli_fetch_assoc($result);

// If borrower does not exist
if (!$br) {
    die("<h2 style='color:red;margin:50px;'>Borrower not found.</h2>");
}

// Fill form initial values
$first = $br['first_name'];
$last = $br['last_name'];
$type_id = $br['type_id'];
$contact = $br['contact_info'];

$type_options = [
    3 => "Citizen",
    1 => "School Student",
    2 => "University Student"
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $first = trim($_POST['first_name']);
    $last = trim($_POST['last_name']);
    $selected_type = $_POST['type'];
    $contact = trim($_POST['contact_info']);

    // Validation
    if (empty($first)) $errors[] = "First name is required.";
    if (empty($last)) $errors[] = "Last name is required.";
    if (empty($selected_type)) $errors[] = "Borrower type is required.";
    if (empty($contact)) $errors[] = "Contact info is required.";

    // Convert type to ID
    $mapping = [
        "Citizen" => 3,
        "School Student" => 1,
        "University Student" => 2
    ];

    if (!isset($mapping[$selected_type])) {
        $errors[] = "Invalid borrower type.";
    } else {
        $type_id = $mapping[$selected_type];
    }

    // If no errors → Update
    if (empty($errors)) {

        $sql = "UPDATE borrower
                SET first_name = ?, last_name = ?, type_id = ?, contact_info = ?
                WHERE borrower_id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssisi", $first, $last, $type_id, $contact, $id);
        mysqli_stmt_execute($stmt);

        header("Location: borrowers.php");
        exit;
    }
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

    h2 {
        text-align: center;
        color: #391B25;
    }

    label {
        font-weight: bold;
        color: #391B25;
    }

    input, select {
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

    .error-box {
        background: #ffe6e6;
        padding: 10px;
        border-left: 4px solid #b30000;
        margin-bottom: 15px;
    }
</style>

<div class="content">
    <div class="edit-container">
        <h2>Edit Borrower</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <strong>Please fix the following errors:</strong>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post">

            <label>First Name</label>
            <input name="first_name" value="<?php echo htmlspecialchars($first); ?>">

            <label>Last Name</label>
            <input name="last_name" value="<?php echo htmlspecialchars($last); ?>">

            <label>Type</label>
            <select name="type">
                <option value="">-- Select --</option>

                <?php 
                foreach ($type_options as $key => $name) {
                    $selected = ($type_id == $key) ? "selected" : "";
                    echo "<option value='$name' $selected>$name</option>";
                }
                ?>
            </select>

            <label>Contact Info</label>
            <input name="contact_info" value="<?php echo htmlspecialchars($contact); ?>">

            <button type="submit">Save</button>
        </form>

        <a href="borrowers.php" class="back-btn">Back to Borrower</a>
    </div>
</div>
