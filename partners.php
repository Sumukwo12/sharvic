<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<!-- Page Banner -->
<section class="page-banner" style="background-image: url('images/tt.jpg'); background-size: cover; background-position: 10px -800px; padding: 120px 0; color: #131e32; text-align: center; text-transform: translateY(20%);">
    <div class="container">
        <h1>Our Partners</h1>
        <p>Organizations we collaborate with to deliver exceptional results</p>
    </div>
</section>

<!-- Partners Section -->
<section class="partners-section" style="padding: 90px 0;">
    <div class="container">
        <div class="section-title">
            <h2>Our Valued Partners</h2>
            <p>We collaborate with leading organizations across various sectors</p>
        </div>
        <div class="partners-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 50px;">
            <?php
            $sql = "SELECT * FROM partners";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="partner-card" style="background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); padding: 30px; text-align: center; transition: all 0.3s ease;">';
                    echo '<div style="height: 120px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">';
                    echo '<img src="images/' . $row["logo"] . '" alt="' . $row["name"] . '" style="max-width: 100%; max-height: 100px; object-fit: contain;">';
                    echo '</div>';
                    echo '<h3 style="font-size: 20px; color: #131e32; margin-bottom: 10px;">' . $row["name"] . '</h3>';
                    echo '</div>';
                }
            } else {
                echo "<p style='text-align: center;'>No partners found</p>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Partnership Benefits -->
<section class="benefits-section" style="padding: 80px 0; background-color: #f5f5f5;">
    <div class="container">
        <div class="section-title">
            <h2>Partnership Benefits</h2>
            <p>Why partner with Sharvic East Africa Limited</p>
        </div>
        <div class="benefits-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 50px;">
            <div class="benefit-card" style="background-color: #fff; border-radius: 8px; padding: 30px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <i class="fas fa-handshake" style="font-size: 50px; color: #131e32;"></i>
                </div>
                <h3 style="font-size: 22px; text-align: center; margin-bottom: 15px; color: #131e32;">Strategic Collaboration</h3>
                <p style="text-align: center;">We work closely with our partners to create mutually beneficial relationships that drive growth and success.</p>
            </div>
            <div class="benefit-card" style="background-color: #fff; border-radius: 8px; padding: 30px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <i class="fas fa-cogs" style="font-size: 50px; color: #131e32;"></i>
                </div>
                <h3 style="font-size: 22px; text-align: center; margin-bottom: 15px; color: #131e32;">Technical Expertise</h3>
                <p style="text-align: center;">Our partners benefit from our technical expertise and experience in various construction and infrastructure projects.</p>
            </div>
            <div class="benefit-card" style="background-color: #fff; border-radius: 8px; padding: 30px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <i class="fas fa-chart-line" style="font-size: 50px; color: #131e32;"></i>
                </div>
                <h3 style="font-size: 22px; text-align: center; margin-bottom: 15px; color: #131e32;">Growth Opportunities</h3>
                <p style="text-align: center;">Partnering with us opens up new growth opportunities and access to a wider network of clients and projects.</p>
            </div>
            <div class="benefit-card" style="background-color: #fff; border-radius: 8px; padding: 30px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <i class="fas fa-shield-alt" style="font-size: 50px; color: #131e32;"></i>
                </div>
                <h3 style="font-size: 22px; text-align: center; margin-bottom: 15px; color: #131e32;">Reliability & Trust</h3>
                <p style="text-align: center;">We build long-term relationships based on reliability, trust, and consistent delivery of quality services.</p>
            </div>
        </div>
    </div>
</section>

<!-- Become a Partner -->
<section class="become-partner" style="padding: 80px 0; background-image: url('images/highlight2.jpg'); background-size: cover; background-position: center; color: #fff; text-align: center;">
    <div class="container">
        <h2 style="font-size: 36px; color: #ffc147; margin-bottom: 20px;">Become Our Partner</h2>
        <p style="font-size: 18px; color: #ffc147; margin-bottom: 30px; max-width: 700px; margin-left: auto; margin-right: auto;">Interested in partnering with Lawn East Africa Limited? Contact us today to discuss potential collaboration opportunities.</p>
        <a href="contact.php" class="btn" style="background-color: #fff; color: #131e32; font-size: 16px; padding: 15px 40px;">Contact Us Now</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
