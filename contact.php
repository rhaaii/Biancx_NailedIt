<?php
include 'db.php'; 

$swal_title = "";
$swal_text = "";
$swal_icon = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, message) 
            VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        $swal_title = "Sent Successfully!";
        $swal_text = "Message sent! Slay, queen! ✨";
        $swal_icon = "success";
    } else {
        $swal_title = "Error!";
        $swal_text = "Oops! Something went wrong.";
        $swal_icon = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Bianx Nailed It</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="contact.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup { 
            font-family: 'Cormorant Garamond', serif !important; 
            background: #1a1a1a !important; 
            color: #fff !important; 
            border: 1px solid #d4af37 !important; 
        }
        .swal2-title { color: #d4af37 !important; }
        .swal2-confirm { background-color: #d4af37 !important; color: #000 !important; }
    </style>
</head>
<body>

    <img src="download.png" id="bgImage" alt="Background">

    <nav class="top-nav">
        <div class="nav-container">
            <div class="nav-links">
                <a href="index.html">Home</a>
                <a href="https://forms.office.com/pages/responsepage.aspx?id=AFdmyraDPEOxXFhFOIDK5VZCyn6LA1ZHpZYVLeeCS7FUODA1SUtJNUdHMFY3M09MTk1FTjZYOEtQVS4u&route=shorturl" target="_blank">Rate Our Website !</a>
            </div>
        </div>
    </nav>

    <div class="contact-container">
        <div class="contact-box">
            <h1 class="contact-title">Get In Touch</h1>
            <p class="contact-subtitle">We are here to listen to your suggestions !</p>

            <div class="contact-content">
                <form class="contact-form" action="contact.php" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="How can we help you slay?" rows="4" required></textarea>
                    <button type="submit" class="send-btn">Send Message</button>
                </form>

                <div class="contact-info">
                    <div class="info-item">
                        <span>📍 Location</span>
                        <p>Manila, Philippines</p>
                    </div>
                    <div class="info-item">
                        <span>📞 Phone</span>
                        <p>+63 912 345 6789</p>
                    </div>
                    <div class="info-item">
                        <span>📲 Instagram</span>
                        <p>@BianxNailedIt</p>
                    </div>
                    <div class="info-item">
                        <span>📲 Facebook</span>
                        <p>@BianxNailedIt</p>
                    </div>
                </div>
            </div>
            <button class="back-home" onclick="window.location.href='index.html'">Back to Home</button>
        </div>
    </div>

    <footer class="bottom-nav">
        <div class="footer-content">
            <p>&copy; 2024 Bianx Nailed It. All Rights Reserved.</p>
        </div>
    </footer>

<script>
<?php if($swal_title != ""): ?>
    Swal.fire({
        title: '<?php echo $swal_title; ?>',
        text: '<?php echo $swal_text; ?>',
        icon: '<?php echo $swal_icon; ?>',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'contact.php';
    });
<?php endif; ?>
</script>
    
</body>
</html>