<?php
include 'conn.php';
session_start();
// Check if user is not logged in or is not an admin
if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'admin') {
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
        <div class="row">
            <div class="col-md-6">
                <h1>Post Event</h1>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Event Form</h5>
                        <form method="post" action="addEventHandler.php">
                            <div class="form-group">
                                <label for="eventName">Event Name</label>
                                <input type="text" class="form-control" id="eventName" name="eventName" required>
                            </div>
                            <div class="form-group">
                                <label for="eventDescription">Event Description</label>
                                <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="eventDate">Event Date</label>
                                <input type="date" class="form-control" id="eventDate" name="eventDate" required>
                            </div>
                            <div class="form-group">
                                <label for="maxAttendees">Max Attendees</label>
                                <input type="number" class="form-control" id="maxAttendees" name="maxAttendees" required>
                            </div> 
                            <button type="submit" class="btn btn-primary">Post Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
