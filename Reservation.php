<?php
include 'conn.php';
session_start();

// Check if user is not logged in
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}
/*
function getNumAttendeesForEvent($conn, $eventId) {
    $sql = "SELECT COUNT(*) AS NumAttendees FROM reservation WHERE EventId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['NumAttendees'];
    $numAttendees = getNumAttendeesForEvent($conn, $eventId);
    $maxAttendees = getMaxAttendeesForEvent($conn, $eventId);
}
*/



?>

<!DOCTYPE html>
<html>

<head>
    <title>Reserve Ticket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Reservation Success</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    include 'conn.php';
                    // Check connection
                    function getMaxAttendeesForEvent($conn, $eventId) {
                        $sql = "SELECT MaxAttendees FROM event WHERE EventId = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $eventId);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
                        return $row['MaxAttendees'];
                    }
                    function hasExceededMaxAttendees($conn, $eventId) {
                        $sql = "SELECT SUM(NumberOfPeopleAllocated) AS Attendees FROM ticket WHERE EventId = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $eventId);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
                        $attendees = $row['Attendees'];
                    
                        // Get MaxAttendees for the event
                        $maxAttendees = getMaxAttendeesForEvent($conn, $eventId);
                    
                        return $attendees > $maxAttendees;
                    }
                    
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $eventId = $_POST["EventId"];
                    $quantity = $_POST["Quantity"];
                    $ticketType = $_POST["TicketType"];
                  

                    // Calculate ticket price based on ticket type
                    $price = 0;
                    if ($ticketType == "VIP") {
                        $price =3000.00;
                    } else if ($ticketType == "Regular") {
                        $price =1800.00;
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Select Valid Ticket Type</div>";
                        exit; // Stop execution if invalid ticket type
                    }
                    if (empty($quantity)) {
                        header('location:reservationForm.php');
                        exit;
                    }
                    $ticketPrice = $price * ($quantity);

                    if (hasExceededMaxAttendees($conn, $eventId) ) {
                
                        // Display a message or take appropriate action to indicate that the event is full
                        echo "<div class='alert alert-danger text-center' role='alert'>This Event Is Full!Reservation Limit Exceeded.Kindly Choose Another Event</div>";
                
                    }else{
                        // Allow the reservation
                    // Prepare and save ticket details 
                    $sql = "INSERT INTO ticket (EventId, TicketType,NumberOfPeopleAllocated,Price) VALUES (?, ?, ?,?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "isid", $eventId, $ticketType,$quantity, $ticketPrice);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    
                    // Select Ticket Id and add to the reservation table
                    $sql = "SELECT TicketId FROM ticket WHERE EventId = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $eventId);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $ticketId);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);

                    $userId = $_POST["UserId"];
                       

                    // Perform reservation
                    $sql = "INSERT INTO reservation (UserId, EventId, TicketId, Quantity, ReservationDate) VALUES (?, ?, ?, ?, NOW())";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "iiii", $userId, $eventId, $ticketId, $quantity);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    // Prepare the SQL statement
                    $sql = "SELECT UserEmail FROM user WHERE UserId = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $userId);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $userEmail);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
                    
                    // Send email for successful reservation
                    $to = $userEmail;
                    $subject = "Reservation Confirmation";
                    $message = "Thank you for your reservation!\n\nTicket Details:\nEvent ID: $eventId\nUser ID: $userId\nTicket ID: $ticketId\nQuantity: $quantity";
                    $headers = "From: stanleigh3oduor@gmail.com"; // Replace with the sender's email address

                    if (mail($to, $subject, $message, $headers)) {
                        // Show success message
                        echo "<div class='alert alert-success' role='alert'>Reservation successful. You have reserved $quantity ticket(s) for this event. An email with the ticket details has been sent.</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Reservation successful. You have reserved $quantity ticket(s) for this event. However, there was an error sending the email. Please contact support for assistance.</div>";
                    }
                    // Close connection
                    mysqli_close($conn);
                
                    }
                    
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Invalid request method. Please try again.</div>";
                }
                ?>
                <a href="eventBooking.php" class="btn btn-primary">Back to Events</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
