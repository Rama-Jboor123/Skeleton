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
    <title>Library Home</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url("https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIzLTA1L2pvYjE4MDgtcmVtaXgtMDRiLWQuanBn.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            display: flex;
        }

        .content {
            margin-left: 250px; 
            width: calc(100% - 250px);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

       
        .box {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border-radius: 15px;
            padding: 40px;
            width: 50%;
            text-align: center;
            color: white;
        }

        .box h1 {
            margin-bottom: 10px;
        }
    </style>

</head>
<body>

    <div class="content">
        <div class="box">
            <h1>Welcome to Our Library System, <?php echo $_SESSION['username']; ?>!</h1>
            <p>Select an option from the left menu to begin.</p>
        </div>
    </div>

</body>
</html>
