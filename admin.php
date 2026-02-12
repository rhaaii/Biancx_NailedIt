<?php 
session_start(); 
include 'db.php'; 

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$swal_title = "";
$swal_text = "";
$swal_icon = "";

if(isset($_GET['id']) && isset($_GET['action'])){
    $id = intval($_GET['id']); 
    $act = mysqli_real_escape_string($conn, $_GET['action']);
    if(mysqli_query($conn, "UPDATE appointments SET status='$act' WHERE id=$id")){
        $swal_title = "Success!";
        $swal_text = "Appointment has been $act.";
        $swal_icon = "success";
    }
}

if(isset($_GET['delete_id'])){
    $del_id = intval($_GET['delete_id']);
    if(mysqli_query($conn, "DELETE FROM appointments WHERE id=$del_id")){
        $swal_title = "Deleted!";
        $swal_text = "The appointment record has been removed.";
        $swal_icon = "success";
    }
}

if(isset($_GET['unblock_id'])){
    $unblock_id = intval($_GET['unblock_id']);
    if(mysqli_query($conn, "DELETE FROM blocked_dates WHERE id=$unblock_id")){
        $swal_title = "Date Unblocked!";
        $swal_text = "The date is now open for bookings.";
        $swal_icon = "success";
    }
}

if(isset($_POST['block_now'])){
    $b_date = mysqli_real_escape_string($conn, $_POST['block_date']);
    if(mysqli_query($conn, "INSERT INTO blocked_dates (date) VALUES ('$b_date')")){
        $swal_title = "Date Blocked!";
        $swal_text = "$b_date is now closed for bookings.";
        $swal_icon = "warning";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Bianx Nailed It</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .admin-content-flex {
            display: flex;
            gap: 20px;
            width: 98%;
            margin: 0 auto;
            align-items: flex-start;
        }
        .bookings-side {
            flex: 4;
        }
        .blocked-side {
            flex: 1;
            min-width: 250px;
        }
        .blocked-list-container {
            margin-top: 15px;
            max-height: 450px;
            overflow-y: auto;
        }
        .blocked-item {
            background: rgba(212, 175, 55, 0.1);
            border-left: 3px solid #d4af37;
            padding: 10px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }
        .unblock-btn {
            color: #ff4d4d;
            text-decoration: none;
            font-weight: bold;
            font-size: 11px;
        }
        .swal2-popup { font-family: 'Cormorant Garamond', serif !important; background: #1a1a1a !important; color: #fff !important; border: 1px solid #d4af37 !important; }
        .swal2-title { color: #d4af37 !important; }
        .swal2-confirm { background-color: #d4af37 !important; color: #000 !important; }
    </style>
</head>
<body>

<img src="download.png" id="bgImage" alt="Background">

<div class="admin-wrap">
    <div class="admin-header" style="width: 98%; margin: 0 auto 20px auto;">
        <h1>Admin Control Panel</h1>
        <a href="logout.php" class="logout-btn">LOGOUT</a>
    </div>

    <div class="admin-content-flex">
        <div class="bookings-side">
            <div class="card table-card" style="margin-top: 0;">
                <div class="table-header">
                    <h3>Client Bookings</h3>
                    <input type="text" id="searchInput" placeholder="Search client name..." onkeyup="filterTable()">
                </div>

                <div class="table-wrapper">
                    <table id="appointmentsTable">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Service</th>
                                <th>Date & Time</th>
                                <th>Client Notes</th> 
                                <th>Status</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $res = mysqli_query($conn, "SELECT * FROM appointments ORDER BY id DESC");
                        while($row = mysqli_fetch_assoc($res)){
                            $statusColor = ($row['status']=='Approved') ? '#00ff00' : (($row['status']=='Declined') ? '#ff4d4d' : '#ffcc00');
                            
                            // 12-hour format adjustment
                            $formattedTime = date("g:i A", strtotime($row['appt_time']));
                            $formattedDate = date("M d, Y", strtotime($row['appt_date']));
                        ?>
                            <tr class="appointment-row">
                                <td class="client-name"><strong><?php echo htmlspecialchars($row['client_name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['service']); ?></td>
                                <td>
                                    <?php echo $formattedDate; ?><br>
                                    <small><?php echo $formattedTime; ?></small>
                                </td>
                                <td>
                                    <div class="note-box">
                                        <?php echo !empty($row['note']) ? htmlspecialchars($row['note']) : '<i style="color: #555;">No notes</i>'; ?>
                                    </div>
                                </td>
                                <td style="font-weight:bold; color: <?php echo $statusColor; ?>">
                                    <?php echo $row['status']; ?>
                                </td>
                                <td>
                                    <div class="action-container">
                                        <div class="decision-btns">
                                            <?php if($row['status']=='Pending'){ ?>
                                                <a href="#" onclick="confirmAction('admin.php?id=<?php echo $row['id']; ?>&action=Approved', 'Approve this?')" class="btn-action approve">Approve</a>
                                                <a href="#" onclick="confirmAction('admin.php?id=<?php echo $row['id']; ?>&action=Declined', 'Decline this?')" class="btn-action decline">Decline</a>
                                            <?php } else { echo "<span class='processed'>Processed</span>"; } ?>
                                        </div>
                                        <a href="#" onclick="confirmAction('admin.php?delete_id=<?php echo $row['id']; ?>', 'Permanently delete this?')" class="btn-action delete">Delete</a>
                                    </div>
                                </td>
                            </tr>  
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="blocked-side">
            <div class="card" style="margin-top: 0;">
                <h3>Block Date</h3>
                <form class="block-form" method="POST">
                    <input type="date" name="block_date" required style="width: 100%; margin-bottom: 10px; padding: 10px;">
                    <button type="submit" name="block_now" class="btn-gold" style="width: 100%;">BLOCK NOW</button>
                </form>
            </div>

            <div class="card" style="margin-top: 20px;">
                <h3>Blocked Dates</h3>
                <div class="blocked-list-container">
                    <?php 
                    $b_res = mysqli_query($conn, "SELECT * FROM blocked_dates ORDER BY date ASC");
                    if(mysqli_num_rows($b_res) > 0){
                        while($b_row = mysqli_fetch_assoc($b_res)){
                            echo "<div class='blocked-item'>
                                    <span>".date('M d, Y', strtotime($b_row['date']))."</span>
                                    <a href='#' onclick=\"confirmAction('admin.php?unblock_id={$b_row['id']}', 'Unblock this date?')\" class='unblock-btn'>REMOVE</a>
                                  </div>";
                        }
                    } else {
                        echo "<p style='color: #888; text-align: center;'>No blocked dates.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterTable() {
    let input = document.getElementById('searchInput').value.toLowerCase();
    let rows = document.getElementsByClassName('appointment-row');
    for (let i = 0; i < rows.length; i++) {
        let nameElement = rows[i].getElementsByClassName('client-name')[0];
        if (nameElement) {
            let name = nameElement.innerText.toLowerCase();
            rows[i].style.display = name.includes(input) ? "" : "none";
        }
    }
}

function confirmAction(url, message) {
    Swal.fire({
        title: 'Are you sure?',
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, proceed!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) { window.location.href = url; }
    });
}

<?php if($swal_title != ""): ?>
    Swal.fire({
        title: '<?php echo $swal_title; ?>',
        text: '<?php echo $swal_text; ?>',
        icon: '<?php echo $swal_icon; ?>',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'admin.php';
    });
<?php endif; ?>
</script>
</body>
</html>