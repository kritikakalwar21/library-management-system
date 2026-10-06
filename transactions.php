<?php
include "db.php";

$result = mysqli_query(
    $conn,
    "SELECT transactions.id,
            books.title,
            members.name,
            transactions.issue_date,
            transactions.return_date,
            transactions.status,
            transactions.fine
     FROM transactions
     JOIN books ON transactions.book_id = books.id
     JOIN members ON transactions.member_id = members.id
     ORDER BY transactions.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
</head>
<body>

<h1>Transaction History</h1>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Book</th>
    <th>Member</th>
    <th>Issue Date</th>
    <th>Return Date</th>
    <th>Status</th>
    <th>Fine</th>
</tr>

<?php
while ($row = mysqli_fetch_assoc($result)) {
?>

<tr>
    <td><?php echo $row['id']; ?></td>

    <td><?php echo $row['title']; ?></td>

    <td><?php echo $row['name']; ?></td>

    <td><?php echo $row['issue_date']; ?></td>

    <td>
        <?php
        echo $row['return_date']
            ? $row['return_date']
            : "Not Returned";
        ?>
    </td>

    <td><?php echo $row['status']; ?></td>

    <td>₹<?php echo $row['fine']; ?></td>
</tr>

<?php
}
?>

</table>

<br>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>