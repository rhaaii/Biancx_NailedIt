<?php 
session_start(); 
include 'db.php'; 

$error_msg = ""; 

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']); 
    
    $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$pass'");
    
    if(mysqli_num_rows($res) > 0){
        $user = mysqli_fetch_assoc($res);
        $_SESSION['user'] = $user; 
        
        if($user['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }
        exit(); 
    } else { 
        $error_msg = "Invalid Email or Password"; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bianx Nailed It</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <img src="download.png" id="bgImage" alt="Background">

    <div class="login-container">
        <form class="login-box" method="POST">
            <h1 class="login-title">Welcome Back,</h1>
            <p class="login-subtitle">Your Highness.</p>

            <?php if($error_msg != ""): ?>
                <p style='color:#ff6b6b; font-weight:bold; margin-bottom:15px;'><?php echo $error_msg; ?></p>
            <?php endif; ?>

            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" name="login" class="login-btn">Login</button>

            <div class="login-footer">
                <span>Don't have an account? <a href="register.php">Sign Up</a></span>
            </div>
        </form>
    </div>
</body>
</html>