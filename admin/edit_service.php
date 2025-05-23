<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include '../includes/db_connect.php';

$errors = [];
$success = false;

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: services.php");
    exit;
}

$id = $_GET['id'];

// Fetch service data
$query = "SELECT * FROM services WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: services.php");
    exit;
}

$service = $result->fetch_assoc();
$stmt->close();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    
    if (empty($title)) {
        $errors[] = "Title is required";
    }
    
    if (empty($description)) {
        $errors[] = "Description is required";
    }
    
    if (empty($category)) {
        $errors[] = "Category is required";
    }
    
    // Handle image upload if a new image is provided
    $image_updated = false;
    $new_filename = $service['image']; // Default to current image
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        // Check if file type is allowed
        if (!in_array(strtolower($filetype), $allowed)) {
            $errors[] = "Only JPG, JPEG, PNG, and GIF files are allowed";
        }
        
        // Generate unique filename
        $new_filename = uniqid() . '.' . $filetype;
        $upload_path = '../images/' . $new_filename;
        
        // Move uploaded file
        if (empty($errors)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $image_updated = true;
                
                // Delete old image
                $old_image_path = '../images/' . $service['image'];
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            } else {
                $errors[] = "Failed to upload image";
            }
        }
    }
    
    // Update database if no errors
    if (empty($errors)) {
        $sql = "UPDATE services SET title = ?, description = ?, category = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $title, $description, $category, $new_filename, $id);
        
        if ($stmt->execute()) {
            $success = true;
            
            // Refresh service data
            $query = "SELECT * FROM services WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $service = $result->fetch_assoc();
        } else {
            $errors[] = "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service - Sharvic East Africa Limited</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffc741;
            color: #333;
        }
        
        .dashboard {
            display: flex;
        }
        
        .sidebar {
            width: 250px;
            background-color: #131e32;
            color: #fff;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px 0;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        .sidebar-header h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }
        
        .sidebar-header p {
            font-size: 12px;
            opacity: 0.7;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-menu ul {
            list-style: none;
        }
        
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .header h2 {
            font-size: 24px;
            color: #0056b3;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-info span {
            margin-right: 10px;
        }
        
        .btn {
            background-color: #0056b3;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn:hover {
            background-color: #003d7a;
        }
        
        .btn-danger {
            background-color: #f44336;
        }
        
        .btn-danger:hover {
            background-color: #d32f2f;
        }
        
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .content-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            font-size: 14px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #0056b3;
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        .current-image {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        
        .current-image img {
            max-width: 200px;
            max-height: 150px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="sidebar-header">
                <h1>Sharvic East Africa</h1>
                <p>Admin Dashboard</p>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="projects.php"><i class="fas fa-project-diagram"></i> Projects</a></li>
                    <li><a href="services.php" class="active"><i class="fas fa-cogs"></i> Services</a></li>
                    <li><a href="partners.php"><i class="fas fa-handshake"></i> Partners</a></li>
                    <li><a href="messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
                    <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </div>
        </div>
        
        <div class="main-content">
            <div class="header">
                <h2>Edit Service</h2>
                <div class="user-info">
                    <span>Welcome, <?php echo $_SESSION['admin_username']; ?></span>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    Service updated successfully!
                </div>
            <?php endif; ?>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <div class="content-box">
                <div class="content-header">
                    <h3>Edit Service Details</h3>
                    <a href="services.php" class="btn"><i class="fas fa-arrow-left"></i> Back to Services</a>
                </div>
                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Service Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($service['title']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="construction" <?php echo ($service['category'] == 'construction') ? 'selected' : ''; ?>>Building & Civil Works</option>
                            <option value="water" <?php echo ($service['category'] == 'water') ? 'selected' : ''; ?>>Water Systems & Sewerage</option>
                            <option value="telecom" <?php echo ($service['category'] == 'telecom') ? 'selected' : ''; ?>>Telecommunication</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Service Image</label>
                        <div class="current-image">
                            <p>Current Image:</p>
                            <img src="../images/<?php echo $service['image']; ?>" alt="<?php echo $service['title']; ?>">
                        </div>
                        <input type="file" id="image" name="image" class="form-control">
                        <small style="color: #666; display: block; margin-top: 5px;">Leave empty to keep current image. Recommended size: 800x600 pixels. Max file size: 2MB.</small>
                    </div>
                    
                    <div style="text-align: right;">
                        <button type="submit" class="btn">Update Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
