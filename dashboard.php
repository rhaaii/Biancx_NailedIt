<?php 
session_start(); 
include 'db.php'; 

if(!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
$client_fullname = $user['firstname'] . " " . $user['lastname'];

$status = ""; 

if(isset($_POST['book'])){
    $date = $_POST['appt_date'];
    $time = $_POST['appt_time'];
    $service = $_POST['service'];
    $note = mysqli_real_escape_string($conn, $_POST['note']);

    $check_blocked = mysqli_query($conn, "SELECT * FROM blocked_dates WHERE date = '$date'");
    $check_duplicate = mysqli_query($conn, "SELECT * FROM appointments WHERE appt_date = '$date' AND appt_time = '$time' AND status != 'Declined'");

    if(mysqli_num_rows($check_blocked) > 0){
        $status = "blocked";
    } 
    else if(mysqli_num_rows($check_duplicate) > 0){
        $status = "taken";
    } 
    else {
        $sql = "INSERT INTO appointments (client_name, appt_date, appt_time, service, note, status) 
                VALUES ('$client_fullname', '$date', '$time', '$service', '$note', 'Pending')";
        
        if(mysqli_query($conn, $sql)){
            $status = "success";
        } else {
            $status = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Bianx Nailed It</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup {
            font-family: 'Cormorant Garamond', serif !important;
            background: #121212 !important;
            color: #f8f8f8 !important;
            border: 2px solid #d4af37 !important;
        }
        .swal2-title { color: #d4af37 !important; }
        .swal2-confirm {
            background: #d4af37 !important;
            color: #000 !important;
            font-weight: bold !important;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<img src="download.png" id="bgImage" alt="Background">

<div class="nav">
    <h2 class="welcome-text">Welcome, <?php echo htmlspecialchars($user['firstname']); ?>!</h2>
    <a href="logout.php" class="logout">LOGOUT</a>
</div>

<div class="container">
    <div class="card booking-card">
        <h3 class="card-title">Book Now</h3>
        <form method="POST">
            <label>Select Date:</label>
            <input type="date" name="appt_date" required>
            <label>Select Time:</label>
            <input type="time" name="appt_time" required>
            <label>Service:</label>
            <select name="service" required>
                <option value="Classic Manicure">Classic Manicure</option>
                <option value="Gel Extensions">Gel Extensions</option>
                <option value="Nail Art Slay">Nail Art Slay</option>
            </select>
            <textarea name="note" placeholder="Any special requests?"></textarea>
            <button type="submit" name="book" class="btn-gold">CONFIRM</button>
        </form>
    </div>

    <div class="card appointments-card">
        <h3 class="card-title">My Appointments</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Date & Time</th>
                        <th>Notes</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $res = mysqli_query($conn, "SELECT * FROM appointments WHERE client_name='$client_fullname' ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($res)){
                        $statusColor = ($row['status'] == 'Approved') ? '#00ff00' : (($row['status'] == 'Declined') ? '#ff4d4d' : '#ffcc00');
                        $noteText = !empty($row['note']) ? htmlspecialchars($row['note']) : '<i style="color: #777;">None</i>';
                        
                        // Ginawang AM/PM format ang oras gamit ang date() at strtotime()
                        $formattedTime = date("g:i A", strtotime($row['appt_time']));
                        $formattedDate = date("M d, Y", strtotime($row['appt_date']));

                        echo "<tr>
                            <td>{$row['service']}</td>
                            <td>$formattedDate<br><small>$formattedTime</small></td>
                            <td style='font-size: 13px; max-width: 150px; color: #ccc;'>$noteText</td>
                            <td style='color: $statusColor; font-weight:bold;'>{$row['status']}</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if($status != ""): ?>
<script>
    let title = "";
    let msg = "";
    let icon = "";

    switch('<?php echo $status; ?>') {
        case 'success':
            title = "Slay, Queen!";
            msg = "Your appointment has been requested successfully.";
            icon = "success";
            break;
        case 'blocked':
            title = "Date Unavailable";
            msg = "Sorry, this date is blocked. Please pick another day!";
            icon = "error";
            break;
        case 'taken':
            title = "Slot Busy";
            msg = "This time is already taken. Let's try another slot!";
            icon = "warning";
            break;
        case 'error':
            title = "Oops!";
            msg = "Something went wrong. Please try again.";
            icon = "question";
            break;
    }

    Swal.fire({
        title: title,
        text: msg,
        icon: icon,
        confirmButtonText: 'OKAY'
    }).then(() => {
        window.location.href = 'dashboard.php';
    });
</script>
<?php endif; ?>

</body>
</html>