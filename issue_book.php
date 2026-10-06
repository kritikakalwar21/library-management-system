<?php
include "db.php";

$message = "";

if (isset($_POST['issue_book'])) {

    $book_id = $_POST['book_id'];
    $member_id = $_POST['member_id'];
    $issue_date = date("Y-m-d");

    $check = mysqli_query($conn, "SELECT available FROM books WHERE id='$book_id'");
    $book = mysqli_fetch_assoc($check);

    if ($book['available'] > 0) {

        $sql = "INSERT INTO transactions 
                (book_id, member_id, issue_date, status)
                VALUES ('$book_id', '$member_id', '$issue_date', 'Issued')";

        if (mysqli_query($conn, $sql)) {

            mysqli_query(
                $conn,
                "UPDATE books SET available = available - 1 WHERE id='$book_id'"
            );

            $message = "Book issued successfully.";

        } else {
            $message = "Error: " . mysqli_error($conn);
        }

    } else {
        $message = "Book is not available.";
    }
}

$books = mysqli_query(
    $conn,
    "SELECT * FROM books WHERE available > 0"
);

$members = mysqli_query(
    $conn,
    "SELECT * FROM members"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issue Book</title>
</head>
<body>

<h1>Issue Book</h1>

<?php
if ($message != "") {
    echo "<p>$message</p>";
}
?>

<form method="POST">

    <label>Select Book:</label><br>

    <select name="book_id" required>

        <option value="">Select Book</option>

        <?php
        while ($book = mysqli_fetch_assoc($books)) {
        ?>

        <option value="<?php echo $book['id']; ?>">
            <?php echo $book['title']; ?>
        </option>

        <?php
        }
        ?>

    </select>

    <br><br>

    <label>Select Member:</label><br>

    <select name="member_id" required>

        <option value="">Select Member</option>

        <?php
        while ($member = mysqli_fetch_assoc($members)) {
        ?>

        <option value="<?php echo $member['id']; ?>">
            <?php echo $member['name']; ?>
        </option>

        <?php
        }
        ?>

    </select>

    <br><br>

    <input type="submit" name="issue_book" value="Issue Book">

</form>

<br>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>