
<table class="table table-responsive fixed-height-table" id="table2" style="display:none;">
<thead>
    <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Description</th>
        <th>Max Attendees</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php
    // Fetch and display events
    //$sql = "SELECT * FROM event LIMIT 100";
    $sql = "SELECT * FROM event";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['EventName'] . "</td>";
            echo "<td>" . $row['EventDate'] . "</td>";
            echo "<td>" . $row['EventDescription'] . "</td>";
            echo "<td>" . $row['MaxAttendees'] . "</td>";
            echo "<td class='d-flex justify-content-between'>";
            echo "<a href='edit_event.php?id=" . $row['EventId'] . "' class='btn btn-sm btn-primary mr-1 flex-grow-1'>Edit</a>";
            echo "<a href='delete_event.php?id=" . $row['EventId'] . "' class='btn btn-sm btn-danger flex-grow-1'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No events found</td></tr>";
    }
?>
</tbody>
</table>