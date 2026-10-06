<?php
include "db.php";

$result = mysqli_query($conn, "SELECT * FROM members");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Members</title>
</head>
<body>

<h1>Library Members</h1>

<a href="add_member.php">Add New Member</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
</tr>

<?php
while ($row = mysqli_fetch_assoc($result)) {
?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['phone']; ?></td>
</tr>

<?php
}
?>

</table>

<br>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
