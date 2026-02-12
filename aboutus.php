<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Bianx Nailed It</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="aboutus.css">
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

    <div class="about-container">
        <div class="about-box">
            <h1 class="about-title">Our Team</h1>
            <p class="about-subtitle">Crafting Magic at Your Fingertips</p>
            
            <div class="about-text">
                <p>Welcome to <strong>Bianx, Nailed It</strong>. We specialize in luxury nail art designed for the modern Queen. Our mission is to make you feel empowered and elegant from the moment you sit in our chair.</p>
            </div>

            <div class="about-gallery">
                <div class="photo-card">
                    <img src="rhaiza.jpg" alt="Rhaiza">
                    <span>Delgado, Rhaiza</span>
                </div>
                <div class="photo-card">
                    <img src="audrey.jpg" alt="Audrey">
                    <span>Galace, Audrey</span>
                </div>
                <div class="photo-card">
                    <img src="bianca.jpg" alt="Bianca">
                    <span>Lim, Ma. Bianca</span>
                </div>
                <div class="photo-card">
                    <img src="cha.jpg" alt="Ashley">
                    <span>Saldo, Ashley</span>
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

</body>
</html>