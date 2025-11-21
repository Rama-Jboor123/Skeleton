<?php require 'db.php';
session_start();
$id = $_GET['id'];

/*
$sql_sale = "DELETE FROM sale WHERE book_id = $id";
mysqli_query($conn, $sql_sale);
*/


mysqli_query($conn, "DELETE FROM publisher WHERE publisher_id=$id");
header("Location: publishers.php");
?>