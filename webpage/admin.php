<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <script src="../backEnd/nodeFiles/connection.js"></script>
    <link rel="stylesheet" href="css/login_style.css">
    <title>Admin Login</title> 
</head>
<body>
<div id = "container">
<?php
require "functions/connect.php";
$username = htmlentities($_POST['username']);
$password = htmlentities($_POST['password']);

$sql = "SELECT * FROM users WHERE username='$username' AND password ='$password' LIMIT 1";
$result = mysqli_query($conn, $sql);
$row  = mysqli_fetch_array($result);
if(mysqli_num_rows($result) == 1) {
session_start();
    $_SESSION['username'] = $row['user_name'];
    $_SESSION['id'] = $row['id'];

    header('Location: adminPanel.php');
} else {
    echo $result;
    echo "Invalid Username or Password!";
}
?>
<form method="post">
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="checkOut" class="form-check-input">
        <label class="form-check-label">Check me out</label>
    </div>
    <button type="submit" onclick="login(this.form)" class="btn btn-primary" name="login">Login</button>
</form>
</div>
</body>
</html>