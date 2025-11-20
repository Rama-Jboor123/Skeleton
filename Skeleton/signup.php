<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $u = $_POST['username'];
    $e = $_POST['email'];
    $p = $_POST['password'];
    $r = $_POST['role'];

    $hashed = password_hash($p, PASSWORD_DEFAULT);


    $sql = "INSERT INTO users(username,email,password,role) VALUES('$u','$e','$hashed','$r')";

    mysqli_query($conn, $sql);
     header("Location: login.php");
            exit;

}
?>
<html>
<head>
<style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('https://img.freepik.com/premium-photo/many-old-books-bookshelf-library_129479-5503.jpg?semt=ais_hybrid&w=740&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .container {
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

        h1 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        form {
            text-align: left;
        }

        label {
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .login-btn {
            background: gray;
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
            display: inline-block;
        }

        .login-btn:hover {
            background: #555;
        }
    </style>

</head>
<body>

    <div class="container">
        <h1>Welcome to our Library System</h1>

        <form method="POST" >
           <input type="hidden" name="action" value="signup">


            <label>Username</label>
            <input type="text" name="username" placeholder="Username" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required>

            <label>Email</label>
            <input type="email" name="email" placeholder="Email" required>

            <label>Role</label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="staff">User</option>
                <option value="student">Student</option>
            </select>

            <input type="submit" name="submit" value="Sign Up" onclick="showmassege()">
        </form>

        <a href="login.php" class="login-btn">Login</a>
    </div>

<script>
function showmassege(){
    alert("Your succefully signed up, Now go and log in");
};
</script>
</body>
</html>
