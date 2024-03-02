<?php
include 'conn.php';
session_start();
// Check if user is not logged in or is not an admin
if(isset($_SESSION['userId']) && $_SESSION['role']=='user'){
  include 'adminError.php';
    return;
}
if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
// Count reservations made today
$today = date("Y-m-d");
$sql = "SELECT COUNT(*) AS count FROM reservation WHERE DATE(ReservationDate) = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $today);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$reservationCount = $row['count'];

// Count the number of events
$sql = "SELECT COUNT(*) AS count FROM event";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$eventCount = $row['count'];
//top event by Id
$sql = "SELECT EventId, COUNT(*) AS ReservationCount FROM reservation GROUP BY EventId ORDER BY ReservationCount DESC LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $topEventId = $row['EventId'];
    $topEventCount = $row['ReservationCount'];
    // Use $topEventId as needed
}
$sql = "SELECT SUM(NumberOfPeopleAllocated) AS Attendees FROM ticket WHERE EventId = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $eventId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$attendees = $row['Attendees'];

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
    .fixed-height-table {
        max-height: calc(5* 3.5rem);
        overflow-y: auto;
    }
</style>
</head>

<body>
<?php include 'navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block bg-primary text-white sidebar border-top border-white">

                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item mt-1">
                            <a class="nav-link text-light btn btn-primary" href="#">Manage Admins</a>
                        </li>
                        <li class="nav-item mt-1">
                            <a class="nav-link text-light btn btn-primary" href="addEvent.php">Add Event</a>
                        </li>
                        <li class="nav-item mt-1">
                            <a class="nav-link text-light btn btn-primary" href="viewTickets.php">View Tickets</a>
                        </li>
                        <li class="nav-item mt-1">
                            <a class="nav-link text-light btn btn-primary" href="#">Manage Reservations</a>
                        </li>
                        <li class="nav-item mt-1">
                            <a class="nav-link text-light btn btn-primary" href="#">Check Earnings</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <span class="text-danger"><h3>Welcome,<?php echo $_SESSION['userName']; ?></h3></span>
                <h1 class="h2">Dashboard</h1>
                    <button class="navbar-toggler d-md-none" type="button" data-toggle="collapse"
                        data-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <!-- Carousel -->
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="card-deck">
                                <div class="card" id="card1">
                                    <div class="card-body">
                                        <h5 class="card-title">Today Reservations</h5>
                                        <p class="card-text text-danger"><?php echo $reservationCount; ?></p>
                                    </div>
                                </div>
                                <div class="card" id="card2">
                                    <div class="card-body">
                                        <h5 class="card-title">Upcoming Events</h5>
                                        <p class="card-text text-success"><?php echo $eventCount; ?></p>
                                    </div>
                                </div>
                                <div class="card" id="card3">
                                    <div class="card-body">
                                        <h5 class="card-title">Users</h5>
                                        <p class="card-text"><h6 class="text-danger"><button class="btn btn-sm btn-danger">See All</button></h6></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="card-deck">
                                
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Today's Sold Tickets</h5>
                                        <p class="card-text text-danger">109</p>
                                    </div>
                                </div>
                                <?php
                                // Fetch event details based on the top event ID
                                $sql = "SELECT * FROM event WHERE EventId = ?";
                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "i", $topEventId);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if ($row = mysqli_fetch_assoc($result)) {
                                    $eventName = $row['EventName'];
                                    $eventDate = $row['EventDate'];
                                    $eventDescription = $row['EventDescription'];
                                    $maxAttendees = $row['MaxAttendees'];
                                  
                                    // Display the top event details in a card
                                    echo '
                                    <div class="card">
                                    <div class="card-body">
                                    <h5 class="card-title text-success">Top Event</h5>
                                    <h6 class="card-title">' . $eventName . '</h6>
                                    <p class="card-text">Description: ' . $eventDescription . '</p>
                                    <p class="card-text text-primary">Max Attendees:<span class="text-success">' . $topEventCount .'</span>/<span class="text-danger">' .$maxAttendees.'</span></p>
                                    </div>
                                    </div>';
                                }
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-success">Today's Earnings</h5>
                                        <p class="card-text text-primary">$118,000</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <!-- Add User Button -->
                <div class="mt-3">
                    <button type="button" class="btn btn-primary" id="addUserBtn">Add User</button>
                    <?php include 'addUserForm.php'; ?>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h2>Recent Reservations</h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-1">
                    <?php include_once 'display.php'; ?>
                </div>
            </main>
        </div>
    </div>
    <script>
    //sidenav menu-button click
    $(document).ready(function(){
        $(".nav-link.btn.btn-primary").hover(
            function(){
                $(this).addClass('btn-light').removeClass('btn-primary text-light');
            },
            function(){
                $(this).addClass('btn-primary text-light').removeClass('btn-light');
            }
        );
    });
    //card click
    $(document).ready(function(){
        // Click event handler for cards
        $('.card').click(function(){
            var cardId = $(this).attr('id');
            // Hide all tables
            $('table').hide();
            // Show the table with the same ID as the clicked card
            $('#' + cardId.replace('card', 'table')).show();
        });
    });
    //add form
    $(document).ready(function() {
            // Show the form when "Add User" button is clicked
            $('#addUserBtn').click(function() {
                $('#addForm').fadeIn();
            });

            // Hide the form when close button is clicked
            $('.close-btn').click(function() {
                $('#addForm').fadeOut();
            });
        });

</script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
