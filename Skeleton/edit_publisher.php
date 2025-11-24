<?php 
include 'header.php';
require 'db.php';

$errors = [];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("<h2 style='color:red;margin:50px;'>Invalid Publisher ID.</h2>");
}

// Fetch publisher
$sql = "SELECT * FROM publisher WHERE publisher_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$bk = mysqli_fetch_assoc($result);

if (!$bk) {
    die("<h2 style='color:red;margin:50px;'>Publisher not found.</h2>");
}

// Initial values
$name = $bk['name'];
$city = $bk['city'];
$country = $bk['country'];
$contact = $bk['contact_info'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $city = trim($_POST['city']);
    $country = trim($_POST['country']);
    $contact = trim($_POST['contact_info']);

    // Validation
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($city)) $errors[] = "City is required.";
    if (empty($country)) $errors[] = "Country is required.";
    if (empty($contact)) $errors[] = "Contact info is required.";

    if (empty($errors)) {

        $sql = "UPDATE publisher 
                SET name=?, city=?, country=?, contact_info=?
                WHERE publisher_id=?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $name, $city, $country, $contact, $id);
        mysqli_stmt_execute($stmt);

        header("Location: publishers.php");
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
        margin: 70px;
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
        <h3>Edit Publisher</h3>

        <?php if (!empty($errors)): ?>
            <div style="
                background:#ffe6e6;
                padding:12px;
                margin-bottom:15px;
                border-left:4px solid #b30000;">
                <strong>Please fix the following:</strong>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo $e; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post">

            <label>Name</label>
            <input name="name" value="<?php echo htmlspecialchars($name); ?>">

            <label>City</label>
            <input name="city" value="<?php echo htmlspecialchars($city); ?>">

            <label>Country</label>
            <input name="country" value="<?php echo htmlspecialchars($country); ?>">

            <label>Contact Info</label>
            <input name="contact_info" value="<?php echo htmlspecialchars($contact); ?>">

            <button type="submit">Save</button>
        </form>

        <a href="publishers.php" class="back-btn">Back to Publishers</a>
    </div>
</div>
