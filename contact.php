<?php include 'includes/header.php'; ?>

<?php
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'includes/db_connect.php';
    
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);
    
    $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        $success_message = "Your message has been sent successfully. We will get back to you soon!";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}
?>

<!-- Page Banner -->
<section class="page-banner" style="background-image: url('images/tt.jpg'); background-size: cover; background-position: center; padding: 100px 0; color: #131e32; text-align: center;">
    <div class="container">
        <h1>Contact Us</h1>
        <p>Get in touch with our team</p>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" style="padding: 80px 0;">
    <div class="container">
        <div class="section-title">
            <h2>Get In Touch</h2>
            <p>We'd love to hear from you. Contact us using the information below or fill out the form.</p>
        </div>
        <div class="contact-container">
            <div class="contact-info">
                <h3>Contact Information</h3>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="info-details">
                        <h4>Our Location</h4>
                        <p>Zahra Sign Systems, Road C, Nairobi, Kenya</p>
                        <p>P.O. Box 36495-00200, Nairobi, Kenya</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div class="info-details">
                        <h4>Phone Number</h4>
                        <p>+254-703-999777</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div class="info-details">
                        <h4>Email Address</h4>
                        <p>info@sharvic-ea.co.ke</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div class="info-details">
                        <h4>Working Hours</h4>
                        <p>Monday - Friday: 8:00 AM - 5:00 PM</p>
                        <p>Saturday: 9:00 AM - 1:00 PM</p>
                    </div>
                </div>
            </div>
            <div class="contact-form">
                <h3>Send Us a Message</h3>
                <?php if (isset($success_message)): ?>
                    <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error_message)): ?>
                    <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <form id="contactForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit" class="btn" style="width: 100%;">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section" style="padding-bottom: 80px;">
    <div class="container">
        <div style="width: 100%; height: 400px; border-radius: 8px; overflow: hidden; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1994.3761753092354!2d36.8657356!3d-1.3244732!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f118ae75a7d29%3A0xe98f4bc50a8e8195!2sGeonet%20Technologies%20Limited!5e0!3m2!1sen!2ske!4v1747908753903!5m2!1sen!2ske" width="1200" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
