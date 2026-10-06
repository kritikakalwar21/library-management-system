<?php
include "db.php";

$result = mysqli_query($conn, "SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Books</title>
</head>
<body>

<h1>Library Books</h1>

<a href="add_book.php">Add New Book</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Author</th>
    <th>Category</th>
    <th>Quantity</th>
    <th>Available</th>
    <th>Action</th>
</tr>

<?php
while ($row = mysqli_fetch_assoc($result)) {
?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['author']; ?></td>
    <td><?php echo $row['category']; ?></td>
    <td><?php echo $row['quantity']; ?></td>
    <td><?php echo $row['available']; ?></td>
    <td>
    <a href="edit_book.php?id=<?php echo $row['id']; ?>">Edit</a>
    |
    <a href="delete_book.php?id=<?php echo $row['id']; ?>"
       onclick="return confirm('Are you sure you want to delete this book?');">
       Delete
    </a>
</td>
</tr>

<?php
}
?>

</table>

<br>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>