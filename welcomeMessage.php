
<?php
$hour = date('H');
$welcomeMessage = '';

if ($hour >= 5 && $hour < 12) {
    $welcomeMessage = 'Good Morning,';
} elseif ($hour >= 12 && $hour < 18) {
    $welcomeMessage = 'Good Afternoon,';
} else {
    $welcomeMessage = 'Good evening,';
}

//


?>