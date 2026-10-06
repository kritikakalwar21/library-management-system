<?php
include "db.php";

if (isset($_POST['add_member'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO members (name, email, phone)
            VALUES ('$name', '$email', '$phone')";

    if (mysqli_query($conn, $sql)) {
        echo "Member added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>
</head>
<body>

<h1>Add New Member</h1>

<form method="POST">

    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone"><br><br>

    <input type="submit" name="add_member" value="Add Member">

</form>

<br>

<a href="members.php">View Members</a><br><br>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>