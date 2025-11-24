<?php
session_start();
require 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $u = trim($_POST['username']);
    $e = trim($_POST['email']);
    $p = $_POST['password'];
    $r = $_POST['role'];

    // Validate inputs
    if (strlen($u) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }

    if (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if (strlen($p) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    $allowed_roles = ['admin', 'staff', 'student'];
    if (!in_array($r, $allowed_roles)) {
        $errors[] = "Invalid role selected.";
    }

    // Check if username or email already exists
    $check_sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "ss", $u, $e);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Username or Email already exists.";
    }

    if (empty($errors)) {
        $hashed = password_hash($p, PASSWORD_DEFAULT);

        $insert_sql = "INSERT INTO users(username,email,password,role) VALUES(?,?,?,?)";
        $stmt2 = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($stmt2, "ssss", $u, $e, $hashed, $r);
        mysqli_stmt_execute($stmt2);

        header("Location: login.php");
        exit;
    }
}
?>
<?php if (!empty($errors)): ?>
    <div style="background:#ffdddd; padding:10px; border-left:4px solid red; margin-bottom:15px;">
        <strong>Please fix the following errors:</strong>
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?php echo htmlspecialchars($err); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

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
            color: black;
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
document.querySelector('form').addEventListener('submit', function(e) {
    const username = this.username.value.trim();
    const email = this.email.value.trim();
    const password = this.password.value;
    const role = this.role.value;

    let errors = [];

    if (username.length < 3) {
        errors.push("Username must be at least 3 characters.");
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        errors.push("Invalid email address.");
    }

    if (password.length < 6) {
        errors.push("Password must be at least 6 characters.");
    }

    const allowedRoles = ['admin', 'staff', 'student'];
    if (!allowedRoles.includes(role)) {
        errors.push("Invalid role selected.");
    }

    if (errors.length > 0) {
        e.preventDefault();
        alert("Please fix these errors:\n- " + errors.join("\n- "));
    }
});

</script>
</body>
</html>
