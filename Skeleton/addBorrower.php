<?php 
include 'header.php';
require 'db.php';

$errors = [];   // Array to store errors
$first = $last = $contact = $type = "";  // To keep form values after error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Read input safely
    $first = trim(mysqli_real_escape_string($conn, $_POST['first_name']));
    $last  = trim(mysqli_real_escape_string($conn, $_POST['last_name']));
    $contact = trim(mysqli_real_escape_string($conn, $_POST['contact_info']));
    $type = $_POST['type'];

    // Validation
    if (empty($first)) $errors[] = "First Name is required.";
    if (empty($last)) $errors[] = "Last Name is required.";
    if (empty($contact)) $errors[] = "Contact Information is required.";
    if (empty($type)) $errors[] = "Borrower Type is required.";

    // Convert type to type_id
    $type_id = 0;
    if ($type == 'Citizen') $type_id = 3;
    if ($type == 'School Student') $type_id = 1;
    if ($type == 'University Student') $type_id = 2;

    // If no errors → insert
    if (empty($errors)) {
        $sql = "INSERT INTO borrower (first_name, last_name, type_id, contact_info)
                VALUES ('$first', '$last', '$type_id', '$contact')";

        mysqli_query($conn, $sql);
        header("Location: borrowers.php");
        exit;
    }
}
?>

<link rel="stylesheet" href="addStyle.css">

<div class="content">
    <div class="add-container">
        <h2>Add Borrower</h2>

        <!-- Error Box -->
        <?php if (!empty($errors)): ?>
            <div style="background:#ffe5e5;padding:10px;border-left:4px solid #c00;margin-bottom:20px;">
                <strong>Please fix the following errors:</strong>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo $e; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post">

            <label>First Name</label>
            <input type="text" name="first_name" value="<?php echo $first; ?>">

            <label>Last Name</label>
            <input type="text" name="last_name" value="<?php echo $last; ?>">

            <label>Type</label>
            <select name="type" style="width:100%;height:35px;margin-bottom:15px;">
                <option value="">-- Select --</option>
                <option <?php if($type=='Citizen') echo 'selected'; ?>>Citizen</option>
                <option <?php if($type=='School Student') echo 'selected'; ?>>School Student</option>
                <option <?php if($type=='University Student') echo 'selected'; ?>>University Student</option>
            </select>

            <label>Contact Info</label>
            <input type="text" name="contact_info" value="<?php echo $contact; ?>">

            <button type="submit">Save</button>
        </form>

        <a href="borrowers.php" class="back-btn">Back to Borrowers</a>
    </div>
</div>
