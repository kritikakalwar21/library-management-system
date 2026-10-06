<?php
include "db.php";

if (isset($_POST['add_book'])) {

    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO books (title, author, category, quantity, available)
            VALUES ('$title', '$author', '$category', '$quantity', '$quantity')";

    if (mysqli_query($conn, $sql)) {
        echo "Book added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
</head>
<body>

<h1>Add New Book</h1>

<form method="POST">

    <label>Book Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Author:</label><br>
    <input type="text" name="author" required><br><br>

    <label>Category:</label><br>
    <input type="text" name="category"><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" required><br><br>

    <input type="submit" name="add_book" value="Add Book">

</form>

<br>

<a href="books.php">View Books</a>

</body>
</html>