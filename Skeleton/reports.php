<?php
//include 'header.php';
//include 'minue.php';
require 'db.php';
?>


<h2>Reports</h2>

<form method="POST">
    <label>Select Report:</label>
    <select name="report_type" onchange="this.form.submit()">
        <option value="">-- Select a report --</option>
        <option value="total_value">Total value of all books</option>
        <option value="books_by_author">Books written by selected author</option>
        <option value="books_by_borrower">Books borrowed or bought by a specific borrower</option>
        <option value="books_by_country">Books published in a selected country.</option>
        <option value="borrower_no_book">Borrowers who never borrowed or bought a book.</option>
        <option value="books_multiple_authors">Books with more than one author</option>
        <option value="available_books">Books available for borrowing</option>
        <option value="current_loans">Current loans and due dates</option>
        <option value="Book_sale">Books that were sold and their sale prices.</option>
        <option value="loan_history">Loan history for a selected borrower.</option>
        <option value="borrowed_in_range">Books borrowed within a date range</option>
        <option value="books_per_category">Books per category</option>

    </select>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $type = $_POST['report_type'];

    if ($type == "total_value") {
        $sql = "SELECT SUM(original_price) AS total FROM book";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        echo "<h3>Total value of all books:</h3>";
        echo "<p><strong>" . $row['total'] . " $</strong></p>";
    }

    if ($type == "books_by_author") {

        echo '<form method="POST">
                <input type="hidden" name="report_type" value="books_by_author">
                <label>Enter author first_name:</label>
                <input type="text" name="firs_name">
                <label>Enter author last_name:</label>
                <input type="text" name="last_name">
                <button type="submit">Search</button>
              </form>';

               $sql = "SELECT book_id, title
                    FROM book NATURAL JOIN bookauthor NATURAL JOIN author
                    WHERE 1";

        if (!empty($_POST['first_name'])) {
            $auth1 = $_POST['first_name'];
            $sql.=" And first_name like '%$auth1'";

        }

        if (!empty($_POST['last_name'])) {
            $auth1 = $_POST['last_name'];
            $sql.=" And last_name like '%$auth1'";

        }
         if (!empty($_POST['last_name']) || !empty($_POST['first_name']) ){
                     $result = mysqli_query($conn, $sql);
                      
            echo "<table border='1'>
                    <tr><th>ID</th><th>Title</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['book_id']}</td>
                        <td>{$row['title']}</td>
                      </tr>";
            }

            echo "</table>";
        }
        
    }

    if ($type == "available_books") {
        $sql = "SELECT * FROM book WHERE book_id NOT IN 
                (SELECT book_id FROM loan WHERE return_date IS NULL)";
        $r = mysqli_query($conn, $sql);

        echo "<h3>Books available for borrowing:</h3>";
        echo "<table border='1'>
                <tr><th>ID</th><th>Title</th><th>Category</th></tr>";

        while ($row = mysqli_fetch_assoc($r)) {
            echo "<tr>
                    <td>{$row['book_id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['category']}</td>
                  </tr>";
        }
        echo "</table>";
    }


 if ($type == "books_by_borrower") {

        echo '<form method="POST">
                <input type="hidden" name="report_type" value="books_by_borrower">
                <label>Enter borrower first_name:</label>
                <input type="text" name="first_name">
                <label>Enter borrower last_name:</label>
                <input type="text" name="last_name">
                <button type="submit">Search</button>
              </form>';

               $sql = "SELECT book_id, title
                    FROM book NATURAL JOIN loan NATURAL JOIN borrower
                    WHERE 1";

        if (!empty($_POST['first_name'])) {
            $auth1 = $_POST['first_name'];
            $sql.=" And first_name like '%$auth1'";

        }

        if (!empty($_POST['last_name'])) {
            $auth2 = $_POST['last_name'];
            $sql.=" And last_name like '%$auth2'";

        }
         if (!empty($_POST['last_name']) || !empty($_POST['first_name']) ){
                     $result = mysqli_query($conn, $sql);
                      
            echo "<table border='1'>
                    <h3>Book that are borrowerd by this borrower</h3>
                    <tr><th>ID</th><th>Title</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['book_id']}</td>
                        <td>{$row['title']}</td>
                      </tr>";
            }

            echo "</table>";
        }
             $sql = "SELECT book_id, title
                    FROM book NATURAL JOIN sale NATURAL JOIN borrower
                    WHERE 1";

        if (!empty($_POST['first_name'])) {
            $auth1 = $_POST['first_name'];
            $sql.=" And first_name like '%$auth1'";

        }

        if (!empty($_POST['last_name'])) {
            $auth2 = $_POST['last_name'];
            $sql.=" And last_name like '%$auth2'";

        }
         if (!empty($_POST['last_name']) || !empty($_POST['first_name']) ){
                     $result = mysqli_query($conn, $sql);
                      
            echo "<table border='1'>
                    <h3>Book that are saled by this borrower</h3>
                    <tr><th>ID</th><th>Title</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['book_id']}</td>
                        <td>{$row['title']}</td>
                      </tr>";
            }

            echo "</table>";



        }

    }
         if ($type == "books_by_country") {
            echo '<form method="POST">
                <input type="hidden" name="report_type" value="books_by_country">
                <label>Enter Country:</label>
                <input type="text" name="country">
                <button type="submit">Search</button>
              </form>';

              
        if (!empty($_POST['country'])) {
            $country = $_POST['country'];
             $sql = "SELECT book_id,title,name,country
                       FROM book NATURAL JOIN publisher
                      WHERE country like '%$country%'
                    ";

        
           $result = mysqli_query($conn, $sql);
            echo "<table border='1'>
                    <h3>Book that published in $country</h3>
                    <tr><th>ID</th><th>Title</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['book_id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['country']}</td>
                      </tr>";
            }

            echo "</table>";
        }

         }

         if ($type == "borrower_no_book") {

    $sql = "SELECT *
            FROM borrower 
            WHERE borrower_id NOT IN (SELECT borrower_id FROM loan)
              AND borrower_id NOT IN (SELECT borrower_id FROM sale)";
    
    $r = mysqli_query($conn, $sql);

    echo "<h3>Borrowers who never borrowed or bought a book:</h3>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($r)) {
        echo "<tr>
                <td>{$row['borrower_id']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
              </tr>";
    }

    echo "</table>";
}

if ($type == "books_multiple_authors") {

    $sql = "SELECT book.book_id, book.title, COUNT(author_id) AS authors_count
            FROM book
            NATURAL JOIN bookauthor
            GROUP BY book_id
            HAVING COUNT(author_id) > 1";

    $r = mysqli_query($conn, $sql);

    echo "<h3>Books with more than one author:</h3>";

    echo "<table border='1'>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Number of Authors</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($r)) {
        echo "<tr>
                <td>{$row['book_id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['authors_count']}</td>
              </tr>";
    }

    echo "</table>";
}

if ($type == "current_loans") {

    $sql = "SELECT loan_id, first_name, last_name, title, loan_date, due_date
            FROM loan 
            NATURAL JOIN borrower 
            NATURAL JOIN book
            WHERE return_date IS NULL
            ORDER BY due_date";

    $r = mysqli_query($conn, $sql);

    echo "<h3>Current Loans and Due Dates:</h3>";

    echo "<table border='1'>
            <tr>
                <th>Loan ID</th>
                <th>Borrower</th>
                <th>Book Title</th>
                <th>Loan Date</th>
                <th>Due Date</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($r)) {
        echo "<tr>
                <td>{$row['loan_id']}</td>
                <td>{$row['first_name']} {$row['last_name']}</td>
                <td>{$row['title']}</td>
                <td>{$row['loan_date']}</td>
                <td>{$row['due_date']}</td>
              </tr>";
    }

    echo "</table>";
}

if ($type == "Book_sale") {
        $sql = "SELECT *
                FROM book NATURAL JOIN sale";
        $r = mysqli_query($conn, $sql);

        echo "<h3>Books that saled and there price:</h3>";
        echo "<table border='1'>
                <tr><th>ID</th><th>Title</th><th>Sale Price</th></tr>";

        while ($row = mysqli_fetch_assoc($r)) {
            echo "<tr>
                    <td>{$row['book_id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['sale_price']}</td>
                  </tr>";
        }
        echo "</table>";
    }


   if ($type == "loan_history") {

    echo '<form method="POST">
            <input type="hidden" name="report_type" value="loan_history">

            <label>Borrower First Name:</label>
            <input type="text" name="first_name">

            <label>Borrower Last Name:</label>
            <input type="text" name="last_name">

            <button type="submit">Search</button>
          </form>';

    // Only run the query when user enters something
    if (!empty($_POST['first_name']) || !empty($_POST['last_name'])) {

        $fn = $_POST['first_name'];
        $ln = $_POST['last_name'];

        $sql = "SELECT loan_id, title, first_name, last_name, loan_date, due_date, return_date
                FROM loan 
                NATURAL JOIN borrower 
                NATURAL JOIN book
                WHERE 1";

        if (!empty($fn)) {
            $sql .= " AND first_name LIKE '%$fn%'";
        }
        if (!empty($ln)) {
            $sql .= " AND last_name LIKE '%$ln%'";
        }

        $sql .= " ORDER BY loan_date DESC";

        $r = mysqli_query($conn, $sql);

        echo "<h3>Loan History</h3>";

        echo "<table border='1'>
                <tr>
                    <th>Loan ID</th>
                    <th>Borrower</th>
                    <th>Book Title</th>
                    <th>Loan Date</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($r)) {
            echo "<tr>
                    <td>{$row['loan_id']}</td>
                    <td>{$row['first_name']} {$row['last_name']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['loan_date']}</td>
                    <td>{$row['due_date']}</td>
                    <td>{$row['return_date']}</td>
                  </tr>";
        }

        echo "</table>";
    }
}

    


    if ($type == "borrowed_in_range") {

 
    echo '<form method="POST">
            <input type="hidden" name="report_type" value="borrowed_in_range">

            <label>Start Date:</label>
            <input type="date" name="start_date" required>

            <label>End Date:</label>
            <input type="date" name="end_date" required>

            <button type="submit">Search</button>
          </form>';

   
    if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {

        $start = $_POST['start_date'];
        $end   = $_POST['end_date'];

        $sql = "SELECT loan_id, first_name, last_name, title, loan_date, due_date
                FROM loan 
                NATURAL JOIN borrower 
                NATURAL JOIN book
                WHERE loan_date BETWEEN '$start' AND '$end'
                ORDER BY loan_date";

        $r = mysqli_query($conn, $sql);

        echo "<h3>Books borrowed between $start and $end:</h3>";

        echo "<table border='1'>
                <tr>
                    <th>Loan ID</th>
                    <th>Borrower</th>
                    <th>Book Title</th>
                    <th>Loan Date</th>
                    <th>Due Date</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($r)) {
            echo "<tr>
                    <td>{$row['loan_id']}</td>
                    <td>{$row['first_name']} {$row['last_name']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['loan_date']}</td>
                    <td>{$row['due_date']}</td>
                  </tr>";
        }

        echo "</table>";
    }
}

if ($type == "books_per_category") {

    // SQL: count books grouped by category
    $sql = "SELECT category, COUNT(*) AS total_books
            FROM book
            GROUP BY category
            ORDER BY total_books DESC";

    $result = mysqli_query($conn, $sql);

    echo "<h3>Books per Category (Table View):</h3>";

    echo "<table border='1'>
            <tr>
                <th>Category</th>
                <th>Total Books</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['category']}</td>
                <td>{$row['total_books']}</td>
              </tr>";
    }

    echo "</table>";

    echo "
    <h3>Books per Category (Bar Chart)</h3>
    <div id='chart_div' style='width: 700px; height: 400px;'></div>

    <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
    <script type='text/javascript'>
        google.charts.load('current', {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Category', 'Total Books'],
";
mysqli_data_seek($result, 0); // reset pointer for second loop
while ($row = mysqli_fetch_assoc($result)) {
    echo "['{$row['category']}', {$row['total_books']}],";
}
echo "
            ]);

            var options = {
                title: 'Books per Category',
                legend: { position: 'none' },
                bar: { groupWidth: '60%' }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
";

}


         }
    
    
    
    
    
    

    

    









?>
