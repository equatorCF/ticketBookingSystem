<?php
include 'conn.php';
session_start();

// Check if user is not logged in or is not an admin or user
if (!isset($_SESSION['userId']))   {
    header("Location: login.php");
    exit();
}
function getEventNameById($conn,$eventId) {
    $sql = "SELECT EventName FROM event WHERE EventId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['EventName'];
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>View Tickets</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1>Tickets</h1>
        <div class="row">
            <?php
            // Fetch and display tickets
            $sql = "SELECT * FROM ticket";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . getEventNameById($conn,$row['EventId']) ."</h5>";
                  //  echo "<p class='card-text'>" . $row['EventId'] . "</p>";
                    echo "<p>TicketType: " . $row['TicketType'] . "</p>";
                    echo "<p>Price: " . $row['Price'] . "</p>";
                    echo "<a href='viewTicketOwner.php?EventId=" . $row['TicketId'] . "' class='btn btn-primary'>View Owner</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='alert alert-danger text-center' role='alert'>No Tickets Found</div>";
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>