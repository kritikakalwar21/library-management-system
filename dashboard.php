<?php
include "db.php";

$book_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM books");
$book_data = mysqli_fetch_assoc($book_query);

$member_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM members");
$member_data = mysqli_fetch_assoc($member_query);

$issue_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM transactions WHERE status='Issued'");
$issue_data = mysqli_fetch_assoc($issue_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Dashboard</title>
</head>
<body>

<h1>Library Management System</h1>

<h2>Dashboard</h2>

<p>Total Books: <?php echo $book_data['total']; ?></p>

<p>Total Members: <?php echo $member_data['total']; ?></p>

<p>Issued Books: <?php echo $issue_data['total']; ?></p>

<br>

<a href="books.php">Manage Books</a><br><br>

<a href="members.php">Manage Members</a><br><br>

<a href="issue_book.php">Issue Book</a><br><br>

<a href="return_book.php">Return Book</a>

</body>
</html>