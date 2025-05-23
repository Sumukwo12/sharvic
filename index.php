<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<style>
  #hero-section {
    position: relative;
    padding: 150px 0;
    text-align: center;
    overflow: hidden;
  }

  .hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-size: cover;
    background-position: center;
    transition: opacity 1s ease-in-out;
    z-index: 0;
    opacity: 0;
  }

  .hero-bg.active {
    opacity: 1;
  }

  .container {
    position: relative;
    z-index: 1;
  }

  .hero-content {
    transition: all 1s ease-in-out;
    opacity: 0;
    transform: translateY(30px);
    color: white; /* default  */
  }

  .hero-content.active {
    opacity: 1;
    transform: translateY(0);
  }
</style>

<section id="hero-section" class="hero">
  <!-- Background Images -->
  <div class="hero-bg active" style="background-image: url('images/tt.jpg');"></div>
  <div class="hero-bg" style="background-image: url('images/ravine.jpeg');"></div>
  <div class="hero-bg" style="background-image: url('images/ravine (1).jpg');"></div>
  <div class="hero-bg" style="background-image: url('images/highlight3.jpg');"></div>
  <div class="hero-bg" style="background-image: url('images/kkiota.jpeg');"></div>

  <!-- Text Container -->
  <div class="container">
    <div id="hero-content" class="hero-content active">
      <h1>Bringing Tomorrow's Technology Today</h1>
      <p>Sharvic East Africa Limited is a fully Kenyan owned construction company with technical and financial capacity to provide construction services to projects of any magnitude in Kenya and East Africa.</p>
      <div class="hero-buttons">
        <a href="about.php" class="btn">Learn More</a>
        <a href="contact.php" class="btn btn-outline">Contact Us</a>
      </div>
    </div>
  </div>
</section>

<script>
  const backgrounds = document.querySelectorAll("#hero-section .hero-bg");
  const content = document.getElementById("hero-content");
  const textColors = ["#131e32", "#ffeb3b", "#00e5ff", "#131e32", "#ff4081"]; // Colors per image
  let current = 0;

  setInterval(() => {
    // Backgrounds
    backgrounds[current].classList.remove("active");

    // Animate text out
    content.classList.remove("active");

    // Move to next index
    current = (current + 1) % backgrounds.length;

    // Set timeout to wait for fade out
    setTimeout(() => {
      backgrounds[current].classList.add("active");

      // Change text color
      content.style.color = textColors[current];

      // Animate text in
      content.classList.add("active");
    }, 500); // Delay to match half the fade duration
  }, 5000);
</script>

<!-- About Section -->
<section class="about-section">
    <div class="container">
        <div class="section-title">
            <h2>About Us</h2>
            <p>Learn more about Sharvic East Africa Limited and our commitment to excellence</p>
        </div>
        <div class="about-content">
            <div class="about-image">
                <img src="images/about-img2.jpg" alt="About Lawn East Africa">
            </div>
            <div class="about-text">
                <h2>Who We Are</h2>
                <p>Sharvic East Africa Limited (SEAL) is a fully Kenyan owned construction company. It has both the technical and financial capacity to fully provide construction services to projects of any magnitude in any part of Kenya and the East African region.</p>
                <p>The company was incorporated in the year 2013 and immediately started its operations as a sub-contractor for the major telecommunication contractors. Aside from these works, the company has over time diversified its operations to include construction works in other sectors such as buildings, water projects, road projects, transportation, logistics, hiring out of construction equipment and supply of construction materials.</p>
                <div class="core-values">
                    <h3>Our Core Values</h3>
                    <div class="values-list">
                        <div class="value-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Customer satisfaction and accountability</span>
                        </div>
                        <div class="value-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Quality and professionalism</span>
                        </div>
                        <div class="value-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Integrity and Honesty</span>
                        </div>
                        <div class="value-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Efficiency</span>
                        </div>
                        <div class="value-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Safety</span>
                        </div>
                        <div class="value-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Open and free communication</span>
                        </div>
                    </div>
                </div>
                <a href="about.php" class="btn" style="margin-top: 20px;">Read More</a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section">
    <div class="container">
        <div class="section-title">
            <h2>Our Services</h2>
            <p>We provide a wide range of construction and infrastructure services</p>
        </div>
        <div class="services-container">
            <?php
            include 'includes/db_connect.php';
            
            $sql = "SELECT * FROM services LIMIT 3";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="service-card">';
                    echo '<div class="service-image">';
                    echo '<img src="images/' . $row["image"] . '" alt="' . $row["title"] . '">';
                    echo '</div>';
                    echo '<div class="service-content">';
                    echo '<h3>' . $row["title"] . '</h3>';
                    echo '<p>' . substr($row["description"], 0, 150) . '...</p>';
                    echo '<a href="services.php#' . $row["category"] . '" class="btn">Learn More</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No services found";
            }
            ?>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section class="projects-section">
    <div class="container">
        <div class="section-title">
            <h2>Our Projects</h2>
            <p>Explore some of our recent and ongoing projects</p>
        </div>
        <div class="projects-container">
            <?php
            $sql = "SELECT * FROM projects LIMIT 3";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="project-card">';
                    echo '<div class="project-image">';
                    echo '<img src="images/' . $row["image"] . '" alt="' . $row["title"] . '">';
                    echo '<div class="project-status">' . $row["status"] . '</div>';
                    echo '</div>';
                    echo '<div class="project-content">';
                    echo '<h3>' . $row["title"] . '</h3>';
                    echo '<div class="project-client"><strong>Client:</strong> ' . $row["client"] . '</div>';
                    echo '<p>' . substr($row["description"], 0, 100) . '...</p>';
                    echo '<a href="projects.php" class="btn">View Details</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No projects found";
            }
            ?>
        </div>
        <div style="text-align: center; margin-top: 40px;">
            <a href="projects.php" class="btn">View All Projects</a>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="partners-section">
    <div class="container">
        <div class="section-title">
            <h2>Our Partners</h2>
            <p>We collaborate with leading organizations to deliver exceptional results</p>
        </div>
        <div class="partners-container">
            <?php
            $sql = "SELECT * FROM partners";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="partner-logo">';
                    echo '<img src="images/' . $row["logo"] . '" alt="' . $row["name"] . '">';
                    echo '</div>';
                }
            } else {
                echo "No partners found";
            }
            
            $conn->close();
            ?>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section" style="background-image: url('images/ravine (1).jpeg'); background-size: cover; background-position: center; color: #131e32; opacity: 1.5; text-align: center;">
    <div class="container">
        <h2 style="font-size: 36px; margin-bottom: 20px;">Ready to Start Your Project?</h2>
        <p style="font-size: 20px; margin-bottom: 30px; max-width: 700px; margin-left: auto; margin-right: auto;">Contact us today to discuss your project requirements and how we can help bring your vision to life.</p>
        <a href="contact.php" class="btn" style="background-color: #ffc741; color: #131e32; font-size: 16px; padding: 15px 40px;">Contact Us Now</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
