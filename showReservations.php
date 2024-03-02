<table class="table table-responsive fixed-height-table" id="table1">
<thead>
    <tr>
        <th>User</th>
        <th>Event</th>
        <th>Ticket Type</th>
        <th>Quantity</th>
        <th>Reservation Date</th>
    </tr>
</thead>
<tbody>
<?php
  // Fetch and display reservations
  $sql = "SELECT *, User.UserName AS UserName, event.EventName AS EventName,ticket.TicketType AS TicketType FROM reservation JOIN User ON reservation.UserId= user.UserId JOIN event ON reservation.EventId = event.EventId JOIN ticket ON reservation.TicketId = ticket.TicketId ORDER BY ReservationDate DESC ";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['UserName'] . "</td>";
        echo "<td>" . $row['EventName'] . "</td>";
        echo "<td>" . $row['TicketType'] . "</td>";
        echo "<td>" . $row['Quantity'] . "</td>";
        echo "<td>" . $row['ReservationDate'] . "</td>";
        echo"<td><button class='btn btn-light'>View Details</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No reservations found</td></tr>";
}
?>
</tbody>
</table>