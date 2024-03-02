<?php
include 'conn.php';
session_start();

// Check if user is not logged in or is not an admin or user
if (!isset($_SESSION['userId']))   {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Event Booking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1>Events</h1>
        <div class="row">
            <?php
            // Fetch and display events
            $sql = "SELECT * FROM event";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row['EventName'] . "</h5>";
                    echo "<p class='card-text'>" . $row['EventDescription'] . "</p>";
                    echo "<p>Date: " . $row['EventDate'] . "</p>";
                    echo "<p>Max Attendees: " . $row['MaxAttendees'] . "</p>";
                    echo "<a href='reservationForm.php?EventId=" . $row['EventId'] . "' class='btn btn-primary'>Get Ticket Now</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No events found</p>";
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>