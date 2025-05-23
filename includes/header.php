<?php
// Get current page for active menu highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sharvic East Africa Limited - Bringing Tomorrow's Technology Today</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="top-bar">
            <div class="container">
                <div class="contact-info">
                    <span><i class="fas fa-phone"></i> +254-703-999777</span>
                    <span><i class="fas fa-envelope"></i> info@sharvic-ea.co.ke</span>
                </div>
                <div class="social-media">
                    <a href="https://www.facebook.com/SHARVICEA"><i class="fab fa-facebook"></i></a>
                    <a href="https://x.com/Sharvic_EA_LTD?t=8BRkI_wiege3jvU5vEdk2Q&s=09"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/company/78708065/admin/page-posts/published/"><i class="fab fa-linkedin"></i></a>
                    <a href="https://www.instagram.com/sharviceastafrica?igsh=NDZmbThjZGpmdTBk"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="index.php">
                        <h1>Sharvic East Africa</h1>
                        <span>Bringing Tomorrow's Technology Today</span>
                    </a>
                </div>
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="about.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About Us</a></li>
                    <li><a href="services.php" class="<?php echo ($current_page == 'services.php') ? 'active' : ''; ?>">Our Services</a></li>
                    <li><a href="projects.php" class="<?php echo ($current_page == 'projects.php') ? 'active' : ''; ?>">Our Projects</a></li>
                    <li><a href="partners.php" class="<?php echo ($current_page == 'partners.php') ? 'active' : ''; ?>">Our Partners</a></li>
                    <li><a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact Us</a></li>
                </ul>
            </div>
        </nav>
    </header>
