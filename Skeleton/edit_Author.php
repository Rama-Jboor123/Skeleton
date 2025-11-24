<?php 
include 'header.php';
require 'db.php';

$errors = [];
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("<h2 style='color:red;margin:50px;'>Invalid Author ID.</h2>");
}

// Fetch existing author
$sql = "SELECT * FROM author WHERE author_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$bk = mysqli_fetch_assoc($result);

if (!$bk) {
    die("<h2 style='color:red;margin:50px;'>Author not found.</h2>");
}

// Prepare values (initial values or after POST)
$fname = $bk['first_name'];
$lname = $bk['last_name'];
$country = $bk['country'];
$bio = $bk['bio'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get & sanitize inputs
    $fname = trim($_POST['first_name']);
    $lname = trim($_POST['last_name']);
    $country = trim($_POST['country']);
    $bio = trim($_POST['bio']);

    // Validation
    if (empty($fname)) $errors[] = "First name is required.";
    if (empty($lname)) $errors[] = "Last name is required.";
    if (empty($country)) $errors[] = "Country is required.";
    if (empty($bio)) $errors[] = "Bio is required.";

    // Update if no errors
    if (empty($errors)) {

        $sql = "UPDATE author 
                SET first_name = ?, last_name = ?, country = ?, bio = ?
                WHERE author_id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $fname, $lname, $country, $bio, $id);
        mysqli_stmt_execute($stmt);

        header("Location: authors.php");
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

    .error-box {
        background: #ffe6e6;
        padding: 10px;
        border-left: 4px solid #b30000;
        margin-bottom: 15px;
    }
</style>

<div class="content">
    <div class="edit-container">
        <h3>Edit Author</h3>

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

        <form method="POST">
            <label for="fn">First name</label><br>
            <input type="text" name="first_name" id="fn" value="<?php echo htmlspecialchars($fname); ?>">
        
            <label for="ls">Last name</label><br>
            <input type="text" name="last_name" id="ls" value="<?php echo htmlspecialchars($lname); ?>">
        
            <label for="cn">Country</label><br>
            <input type="text" name="country" id="cn" value="<?php echo htmlspecialchars($country); ?>">
     
            <label for="b">Bio</label><br>
            <input type="text" name="bio" id="b" value="<?php echo htmlspecialchars($bio); ?>">
       
            <button type="submit">Save</button>
        </form>

        <a href="authors.php" class="back-btn">Back to Authors</a>
    </div>
</div>
