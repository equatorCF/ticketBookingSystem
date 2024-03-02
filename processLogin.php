<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["Username"];
    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Verify credentials
    $sql = "SELECT * FROM user WHERE UserName = ? AND UserEmail = ? AND Password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email,$password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['userId'] = $user['UserId'];
        $_SESSION['userName'] = $user['UserName'];
        $_SESSION['role'] = $user['Role'];
        $_SESSION['email'] = $user['UserEmail'];

        if($_SESSION['role'] == 'user'){
        header("Location:eventBooking.php");
        exit();
        } else if($_SESSION['role'] == 'admin'){
        
        header("Location:dashboard.php");
        exit();
        }
    } else {
        include 'loginError.php';
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
