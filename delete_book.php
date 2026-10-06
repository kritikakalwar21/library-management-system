<?php
include "db.php";

$id = $_GET['id'];

$check = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM transactions WHERE book_id='$id'"
);

$data = mysqli_fetch_assoc($check);

if ($data['total'] > 0) {

    echo "This book cannot be deleted because it has transaction history.";

    echo "<br><br>";
    echo "<a href='books.php'>Back to Books</a>";

} else {

    $sql = "DELETE FROM books WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {

        echo "Book deleted successfully.";

    } else {

        echo "Error: " . mysqli_error($conn);
    }

    echo "<br><br>";
    echo "<a href='books.php'>Back to Books</a>";
}
?>