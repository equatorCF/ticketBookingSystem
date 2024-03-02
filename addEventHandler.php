
<?php
include 'conn.php';
session_start();

// Check if user is not logged in or is not an user
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Booking System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $eventName = $_POST["eventName"];
                            $eventDescription = $_POST["eventDescription"];
                            $eventDate = $_POST["eventDate"];
                            $maxAttendees = $_POST["maxAttendees"];

                            // Insert into the database
                            $sql = "INSERT INTO event (eventName, eventDescription, eventDate, maxAttendees) VALUES (?, ?, ?, ?)";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "sssi", $eventName, $eventDescription, $eventDate, $maxAttendees);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);

                            echo "<div class='alert alert-success' role='alert'>Event Posted Successfully</div>";
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>Error Occurred While Posting Event</div>";
                        }
                        echo '<a href="addEvent.php" class="btn btn-primary">Back to Post Event</a>';

                        mysqli_close($conn);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
