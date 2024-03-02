<?php
include 'conn.php';
function userExists($username, $email) {
    global $conn;

    $sql = "SELECT * FROM user WHERE UserName = ? OR UserEmail = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        return true; // User already exists
    }
    mysqli_stmt_close($stmt);
    return false; // User does not exist
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["Username"];
    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $role = $_POST["Role"];
    
    // Perform validation to check if user already exists
    if (userExists($username, $email)) {
        header('location:registerError.php');
        exit();
    }
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $sql = "INSERT INTO user (UserName,UserEmail,Password,Role) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPassword, $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if(!$_POST['Control']=='Control'){
        // Redirect to login page
        header("Location: login.php");
        exit();
    }else{
        header("Location:dashboard.php");
        exit();
    }
   
} else {
    // Redirect to registration page
    header("Location: register.php");
    exit();
}
mysqli_close($conn);
?>
