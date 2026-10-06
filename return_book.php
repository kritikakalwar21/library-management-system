<?php
include "db.php";

$message = "";

if (isset($_POST['return_book'])) {

    $transaction_id = $_POST['transaction_id'];

    $query = mysqli_query(
        $conn,
        "SELECT book_id, issue_date
         FROM transactions
         WHERE id='$transaction_id' AND status='Issued'"
    );

    $transaction = mysqli_fetch_assoc($query);

    if ($transaction) {

        $book_id = $transaction['book_id'];
        $issue_date = $transaction['issue_date'];
        $return_date = date("Y-m-d");

        $start = new DateTime($issue_date);
        $end = new DateTime($return_date);

        $days = $start->diff($end)->days;

        $fine = 0;

        if ($days > 7) {
            $fine = ($days - 7) * 5;
        }

        mysqli_query(
            $conn,
            "UPDATE transactions
             SET return_date='$return_date',
                 status='Returned',
                 fine='$fine'
             WHERE id='$transaction_id'"
        );

        mysqli_query(
            $conn,
            "UPDATE books
             SET available = available + 1
             WHERE id='$book_id'"
        );

        $message = "Book returned successfully. Fine: ₹" . $fine;

    } else {

        $message = "Invalid transaction or book already returned.";
    }
}

$result = mysqli_query(
    $conn,
    "SELECT transactions.id,
            books.title,
            members.name,
            transactions.issue_date
     FROM transactions
     JOIN books ON transactions.book_id = books.id
     JOIN members ON transactions.member_id = members.id
     WHERE transactions.status='Issued'"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Book</title>
</head>
<body>

<h1>Return Book</h1>

<?php
if ($message != "") {
    echo "<p>$message</p>";
}
?>

<form method="POST">

    <label>Select Issued Book:</label><br>

    <select name="transaction_id" required>

        <option value="">Select Book</option>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <option value="<?php echo $row['id']; ?>">
            <?php
            echo $row['title'] . " - " .
                 $row['name'] . " - Issued: " .
                 $row['issue_date'];
            ?>
        </option>

        <?php
        }
        ?>

    </select>

    <br><br>

    <input type="submit" name="return_book" value="Return Book">

</form>

<br>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>