
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
    <title>Reservation Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1>Reserve Ticket For This Event</h1>
        <div class="row p-3">

            <?php
            // Database connection
            include 'conn.php';
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            if (isset($_GET['EventId'])) {
                $eventId = $_GET['EventId'];
                // Now you can use $eventId in your code 

                $sql = "SELECT*FROM event WHERE EventId = $eventId";
                $result = mysqli_query($conn, $sql);
                // Fetch and display events

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='col-md-4 mb-4'>";
                        echo "<div class='card'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . $row['EventName'] . "</h5>";
                        echo "<p class='card-text'>" . $row['EventDescription'] . "</p>";
                        echo "<p>Date: " . $row['EventDate'] . "</p>";
                        echo "<p>Max Attendees: " . $row['MaxAttendees'] . "</p>";

                        // Reservation form
                        echo "<form action='reservation.php' method='post'>";
                        echo "<input type='hidden' name='EventId' value='" . $eventId . "'>";
                        echo "<input type='hidden' name='UserId' value='".$_SESSION['userId']."'"; // Assuming user_id is 1 for this example
                        echo "<input type='hidden' name='EventName' value='" . $row['EventName'] . "'>";
                        echo "<input type='hidden' name='EventDescription' value='" . $row['EventDescription'] . "'>";
                        echo "<input type='hidden' name='EventDate' value='" . $row['EventDate'] . "'>";
                        echo "<input type='hidden' name='MaxAttendees' value='" . $row['MaxAttendees'] . "'>";
                        echo "<div class='form-group'>";
                        echo "<label for='TicketType'>Select Ticket Type:</label>";
                        echo "<select class='form-control' id='TicketType' name='TicketType'>";
                        echo "<option value='VIP'>VIP KSH.3000</option>";
                        echo "<option value='Regular'>Regular KSH.1800</option>";
                        echo "</select>";
                        echo "</div>";
                        echo "<div class='form-group'>";
                        echo "<label for='Quantity'>Quantity:</label>";
                        echo "<input type='number' class='form-control' id='Quantity' name='Quantity' min='1' max='5'>";
                        echo "</div>";
                        echo "<button type='submit' class='btn btn-primary'>Reserve Ticket</button>";
                        echo "</form>";

                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No events found</p>";
                }
            } else {
                echo "<h5 class='text-danger'>Something Went Wrong !! Please Try Again</h5>";
               
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </div>
        <a href='eventBooking.php' class='btn btn-primary'>Back to Events</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>