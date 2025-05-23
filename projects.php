<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<!-- Page Banner -->
<section class="page-banner" style="background-image: url('images/img2.jpg'); background-size: cover; background-position: center; padding: 120px 0; color: #fff; text-align: center;">
    <div class="container">
        <h1>Our Projects</h1>
        <p>Explore our portfolio of completed and ongoing projects</p>
    </div>
</section>

<!-- Projects Section -->
<section class="projects-section" style="padding: 80px 0;">
    <div class="container">
        <div class="section-title">
            <h2>Project Portfolio</h2>
            <p>We have successfully completed numerous projects across various sectors</p>
        </div>
        
        <!-- Project Filters -->
        <div class="project-filters" style="text-align: center; margin-bottom: 40px;">
            <button class="filter-btn active" data-filter="all" style="background-color: #ffc741; color: #fff; border: none; padding: 10px 20px; margin: 0 5px 10px; border-radius: 4px; cursor: pointer; transition: all 0.3s ease;">All Projects</button>
            <button class="filter-btn" data-filter="completed" style="background-color: #f5f5f5; color: #333; border: none; padding: 10px 20px; margin: 0 5px 10px; border-radius: 4px; cursor: pointer; transition: all 0.3s ease;">Completed</button>
            <button class="filter-btn" data-filter="ongoing" style="background-color: #f5f5f5; color: #333; border: none; padding: 10px 20px; margin: 0 5px 10px; border-radius: 4px; cursor: pointer; transition: all 0.3s ease;">Ongoing</button>
        </div>
        
        <!-- Projects Grid -->
        <div class="projects-container">
            <?php
            $sql = "SELECT * FROM projects";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $statusClass = (strpos(strtolower($row["status"]), 'completed') !== false) ? 'completed' : 'ongoing';
                    
                    echo '<div class="project-card ' . $statusClass . '">';
                    echo '<div class="project-image">';
                    echo '<img src="images/' . $row["image"] . '" alt="' . $row["title"] . '">';
                    echo '<div class="project-status">' . $row["status"] . '</div>';
                    echo '</div>';
                    echo '<div class="project-content">';
                    echo '<h3>' . $row["title"] . '</h3>';
                    echo '<div class="project-client"><strong>Client:</strong> ' . $row["client"] . '</div>';
                    echo '<p>' . $row["description"] . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p style='text-align: center;'>No projects found</p>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Project Highlights -->
<section class="project-highlights" style="padding: 80px 0; background-color: #f5f5f5;">
    <div class="container">
        <div class="section-title">
            <h2>Project Highlights</h2>
            <p>Some of our notable projects and achievements</p>
        </div>
        <div class="highlights-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 50px;">
            <div class="highlight-card" style="background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                <img src="images/highlight1.jpg" alt="Project Highlight" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h3 style="font-size: 22px; color: #131e32; margin-bottom: 15px;">Construction of Governors Residence</h3>
                    <p style="margin-bottom: 15px;">Joint Venture with Patience Services Limited for Construction of Governors Residence at Bomet County. This project is currently 70% completed.</p>
                </div>
            </div>
            <div class="highlight-card" style="background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                <img src="images/highlight2.jpg" alt="Project Highlight" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h3 style="font-size: 22px; color: #131e32; margin-bottom: 15px;">SGR Project</h3>
                    <p style="margin-bottom: 15px;">Labour Works for Slope Protection and Drainage Works on the Nairobi-Naivasha SGR Project- Sections 1, 3 and 5. This project has been successfully completed.</p>
                </div>
            </div>
            <div class="highlight-card" style="background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                <img src="images/highlight3.jpg" alt="Project Highlight" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h3 style="font-size: 22px; color: #131e32; margin-bottom: 15px;">Kiota School Tuition Block</h3>
                    <p style="margin-bottom: 15px;">Construction of Tuition Block at Karen Campus. We were the Main Contractor for this 32 classroom Tuition Block at Kiota School, Karen Campus.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials-section" style="padding: 80px 0; background-image: linear-gradient(rgb(19, 30, 50), rgb(19, 30, 50)), url('images/testimonial-bg.jpg'); background-size: cover; background-position: center; color: #fff; text-align: center;">
    <div class="container">
        <div class="section-title" style="margin-bottom: 50px;">
            <h2 style="color: #fff;">What Our Clients Say</h2>
            <p style="color: #fff;">Testimonials from our satisfied clients</p>
        </div>
        <div class="testimonials-container" style="max-width: 800px; margin: 0 auto;">
            <div class="testimonial" style="background-color: #fff; padding: 30px; border-radius: 8px; margin-bottom: 30px;">
                <div class="quote" style="font-size: 24px; margin-bottom: 20px;">
                    <i class="fas fa-quote-left"></i>
                </div>
                <p style="font-size: 18px; color: #131e32; font-style: italic; margin-bottom: 20px;">Sharvic East Africa Limited delivered our project on time and within budget. Their professionalism and attention to detail were impressive. We highly recommend their services.</p>
                <div class="client-info">
                    <h4 style="font-size: 18px;color: #131e32; margin-bottom: 5px;">John Doe</h4>
                    <p style="font-size: 14px;color: #131e32;">Project Manager, Ravine Dairies Limited</p>
                </div>
            </div>
            <div class="testimonial" style="background-color: #fff; padding: 30px; border-radius: 8px;">
                <div class="quote" style="font-size: 24px; margin-bottom: 20px;">
                    <i class="fas fa-quote-left"></i>
                </div>
                <p style="font-size: 18px; color: #131e32; font-style: italic; margin-bottom: 20px;">Working with Sharvic East Africa Limited was a great experience. Their team is knowledgeable, responsive, and committed to delivering quality work. We look forward to working with them again in the future.</p>
                <div class="client-info">
                    <h4 style="font-size: 18px; color: #131e32; margin-bottom: 5px;">Jane Smith</h4>
                    <p style="font-size: 14px; color: #131e32;">Director, Kiota School</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section" style="padding: 80px 0; text-align: center;">
    <div class="container">
        <h2 style="font-size: 36px; color: #132e32; margin-bottom: 20px;">Let's Discuss Your Project</h2>
        <p style="font-size: 18px; margin-bottom: 30px; max-width: 700px; margin-left: auto; margin-right: auto;">Whether you have a specific project in mind or need consultation on your construction needs, our team is ready to assist you.</p>
        <a href="contact.php" class="btn" style="background-color: #131e32; color: #fff; font-size: 16px; padding: 15px 40px;">Contact Us Now</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
