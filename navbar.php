<?php
    include 'welcomeMessage.php';
    $page = "Ticket Booking System";
    if($_SESSION['role']== 'admin'){
    $page = "Admin Dashboard";
    }else{
        $page = "Ticket Booking System";
    } 
    ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><?php echo $page;?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#"><?php echo $welcomeMessage.$_SESSION['userName']; ?>!</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="eventBooking.php">View Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
