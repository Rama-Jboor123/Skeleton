<?php 
include 'header.php';
require 'db.php';

$errors = [];
$name = $city = $country = $contact = "";

if($_SERVER['REQUEST_METHOD']=='POST'){

    // Sanitize user input
    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $city = trim(mysqli_real_escape_string($conn, $_POST['city']));
    $country = trim(mysqli_real_escape_string($conn, $_POST['country']));
    $contact = trim(mysqli_real_escape_string($conn, $_POST['contact_info']));

    // Validation
    if (empty($name)) $errors[] = "Publisher name is required.";
    if (empty($city)) $errors[] = "City is required.";
    if (empty($country)) $errors[] = "Country is required.";
    if (empty($contact)) $errors[] = "Contact information is required.";

    // Insert into DB if no validation errors
    if (empty($errors)) {
        $sql = "INSERT INTO publisher (name, city, country, contact_info) 
                VALUES ('$name', '$city', '$country', '$contact')";

        mysqli_query($conn, $sql);

        header("Location: publishers.php");
        exit;
    }
}
?>

<link rel="stylesheet" href="addStyle.css">

<div class="content">

    <div class="add-container">
        <h2>Add New Publisher</h2>

        <!-- Error Box -->
        <?php if (!empty($errors)): ?>
            <div style="background:#ffe6e6;border-left:4px solid #b30000;padding:10px;margin-bottom:20px;">
                <strong>Please fix the following errors:</strong>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo $e; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

<form method="post">

            <label for="t">Name</label>
            <input type="text" name="name" id="t" value="<?php echo $name; ?>">

            <label for="c">City</label>
            <input type="text" name="city" id="c" value="<?php echo $city; ?>">

            <label for="ty">Country</label>
            <input type="text" name="country" id="ty" value="<?php echo $country; ?>">

            <label for="p">Contact Info</label>
            <input type="text" name="contact_info" id="p" value="<?php echo $contact; ?>">

            <button type="submit">Save</button>
        </form>

        <a href="publishers.php" class="back-btn">Back to Publishers</a>
    </div>
</div>
