<?php
include "db.php";

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM books WHERE id='$id'");
$book = mysqli_fetch_assoc($result);

if (!$book) {
    die("Book not found.");
}

if (isset($_POST['update_book'])) {

    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];

    $old_quantity = $book['quantity'];
    $old_available = $book['available'];

    $issued = $old_quantity - $old_available;

    if ($quantity < $issued) {

        echo "Quantity cannot be less than the number of issued books.";

    } else {

        $new_available = $quantity - $issued;

        $sql = "UPDATE books
                SET title='$title',
                    author='$author',
                    category='$category',
                    quantity='$quantity',
                    available='$new_available'
                WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {

            echo "Book updated successfully.";

            $result = mysqli_query($conn, "SELECT * FROM books WHERE id='$id'");
            $book = mysqli_fetch_assoc($result);

        } else {

            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
</head>
<body>

<h1>Edit Book</h1>

<form method="POST">

    <label>Book Title:</label><br>
    <input type="text" name="title"
           value="<?php echo $book['title']; ?>" required>
    <br><br>

    <label>Author:</label><br>
    <input type="text" name="author"
           value="<?php echo $book['author']; ?>" required>
    <br><br>

    <label>Category:</label><br>
    <input type="text" name="category"
           value="<?php echo $book['category']; ?>">
    <br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity"
           value="<?php echo $book['quantity']; ?>" required>
    <br><br>

    <input type="submit" name="update_book" value="Update Book">

</form>

<br>

<a href="books.php">Back to Books</a>

</body>
</html>
