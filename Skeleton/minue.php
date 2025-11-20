<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            background: #f7f7f7;
        }

        /* Sidebar */
        nav {
            display:inline-block;
            width: 250px;
            height: 100vh;
            margin-top:66px;
            background-color: #4A2C2A;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 20px;
            color: white;
        }

        nav ul {
            list-style: none;
            padding-left: 0;
        }

        nav ul li {
            padding: 15px;
            margin: 5px 0;
            transition: 0.3s;
        }

        nav ul li:hover {
            background-color: #7a3d2e;
            cursor: pointer;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        /* Main Content */
        .content {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }

        h1 {
            color: #333;
        }
    </style>
</head>
<body>

    <nav>
        <ul>
            <li><a href="books.php"> Books</a></li>
            <li><a href="authors.php"> Authors</a></li>
            <li><a href="publishers.php"> Publishers</a></li>
            <li><a href="borrowers.php"> Borrowers</a></li>
            <li><a href="loans.php"> Loans</a></li>
            <li><a href="sales.php"> Sales</a></li>
            <li><a href="reports.php"> Reports</a></li>
            <li><a href="aboutme.php"> About Developer</a></li>
        </ul>
    </nav>

    

</body>
</html>
