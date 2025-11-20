<?php
session_start();
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. Read form input
    $u = $_POST['username'];
    $p = $_POST['password'];

    // 2. Run query to find user
    $sql = "SELECT * FROM users WHERE username = '$u'";
    $result = mysqli_query($conn, $sql);

    // 3. Check if user exists (should be 1 record)
    if (mysqli_num_rows($result) == 1) {

        // 4. Fetch the user row
        $user = mysqli_fetch_assoc($result);
        
        // 5. Verify password
       
        if (password_verify($p, $user['password'])) {

            // 6. Store session data
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // 7. Redirect to books page
            header("Location: books.php");
            exit;
        }
        else{
           echo "<script>alert('Incorrect password');</script>";
        }
    }
    else{
          echo "<script>alert('There is no user with this username');</script>";
    }
}

?>
<head>
<style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;

            /* Background Image */
           background-image: url('https://img.freepik.com/premium-photo/many-old-books-bookshelf-library_129479-5503.jpg?semt=ais_hybrid&w=740&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Glass Box */
        .form-container {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border-radius: 15px;
            padding: 40px;
            width: 350px;
            color: white;
            text-align: center;
        }

        h2 {
            margin-top: 0;
            font-size: 26px;
        }

        form {
            text-align: left;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: none;
            outline: none;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #3a6fcf;
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            border: none;
            padding: 12px;
            border-radius: 8px;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #284b9b;
        }

        .signup-btn {
            margin-top: 20px;
            width: 100%;
            background-color: #0a0a23;
            color: white;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
            text-align: center;
        }

        .signup-btn:hover {
            background-color: #151545;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Login</h2>

        <form method="POST">
            <input type="hidden" name="action" value="login">


            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">
        </form>

        <a href="signup.php" class="signup-btn">Create an Account</a>
    </div>

</body>
</html>
