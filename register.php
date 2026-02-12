<?php 
include 'db.php'; 

$swal_title = "";
$swal_text = "";
$swal_icon = "";
$redirect = false;

if(isset($_POST['register'])){
    $fname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = md5($_POST['password']);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $swal_title = "Email Taken!";
        $swal_text = "This email is already registered. Try logging in instead.";
        $swal_icon = "error";
    } else {
        $sql = "INSERT INTO users (firstname, lastname, email, password, role) 
                VALUES ('$fname', '$lname', '$email', '$pass', 'client')";
        if(mysqli_query($conn, $sql)){
            $swal_title = "Welcome, Queen!";
            $swal_text = "Your account has been created successfully.";
            $swal_icon = "success";
            $redirect = true;
        } else {
            $swal_title = "Error!";
            $swal_text = "Something went wrong. Please try again.";
            $swal_icon = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Bianx Nailed It</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="register.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup { font-family: 'Cormorant Garamond', serif !important; background: #121212 !important; color: #f8f8f8 !important; border: 2px solid #d4af37 !important; }
        .swal2-title { color: #d4af37 !important; }
        .swal2-confirm { background: #d4af37 !important; color: #000 !important; font-weight: bold !important; }
    </style>
</head>
<body>
    <img src="download.png" id="bgImage" alt="Background">
    
    <div class="reg-container">
        <form class="reg-box" method="POST">
            <h1 class="reg-title">Join The Club,</h1>
            <p class="reg-subtitle">Start Your Pamper.</p>
            
            <div class="input-group">
                <input type="text" name="firstname" placeholder="First Name" required>
            </div>
            <div class="input-group">
                <input type="text" name="lastname" placeholder="Last Name" required>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" name="register" class="reg-btn">Create Account</button>
            
            <div class="reg-footer">
                <span>Already a member? <a href="login.php">Login here</a></span>
            </div>
        </form>
    </div>

<script>
<?php if($swal_title != ""): ?>
    Swal.fire({
        title: '<?php echo $swal_title; ?>',
        text: '<?php echo $swal_text; ?>',
        icon: '<?php echo $swal_icon; ?>',
        confirmButtonText: 'OK'
    }).then(() => {
        <?php if($redirect): ?>
            window.location.href = 'login.php';
        <?php endif; ?>
    });
<?php endif; ?>
</script>
</body>
</html>