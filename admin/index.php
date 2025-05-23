<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include '../includes/db_connect.php';

// Get counts for dashboard
$projectsQuery = "SELECT COUNT(*) as count FROM projects";
$projectsResult = $conn->query($projectsQuery);
$projectsCount = $projectsResult->fetch_assoc()['count'];

$servicesQuery = "SELECT COUNT(*) as count FROM services";
$servicesResult = $conn->query($servicesQuery);
$servicesCount = $servicesResult->fetch_assoc()['count'];

$partnersQuery = "SELECT COUNT(*) as count FROM partners";
$partnersResult = $conn->query($partnersQuery);
$partnersCount = $partnersResult->fetch_assoc()['count'];

$messagesQuery = "SELECT COUNT(*) as count FROM contact_messages";
$messagesResult = $conn->query($messagesQuery);
$messagesCount = $messagesResult->fetch_assoc()['count'];

// Get recent messages
$recentMessagesQuery = "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5";
$recentMessagesResult = $conn->query($recentMessagesQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sharvic East Africa Limited</title>
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
            border-bottom: 1px solid #131e32;
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
        
        .logout-btn {
            background-color: #f44336;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background-color: #d32f2f;
        }
        
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            align-items: center;
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(0, 86, 179, 0.1);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 20px;
        }
        
        .card-icon i {
            font-size: 24px;
            color: #0056b3;
        }
        
        .card-info h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .card-info p {
            font-size: 24px;
            font-weight: 600;
            color: #0056b3;
        }
        
        .recent-messages {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        
        .recent-messages h3 {
            font-size: 18px;
            color: #0056b3;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .message-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .message-item:last-child {
            border-bottom: none;
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .message-sender {
            font-weight: 600;
        }
        
        .message-date {
            font-size: 12px;
            color: #666;
        }
        
        .message-subject {
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        .message-content {
            color: #666;
            font-size: 14px;
        }
        
        .view-all {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #0056b3;
            text-decoration: none;
            font-weight: 500;
        }
        
        .view-all:hover {
            text-decoration: underline;
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
                    <li><a href="index.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="projects.php"><i class="fas fa-project-diagram"></i> Projects</a></li>
                    <li><a href="services.php"><i class="fas fa-cogs"></i> Services</a></li>
                    <li><a href="partners.php"><i class="fas fa-handshake"></i> Partners</a></li>
                    <li><a href="messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
                    <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </div>
        </div>
        
        <div class="main-content">
            <div class="header">
                <h2>Dashboard</h2>
                <div class="user-info">
                    <span>Welcome, <?php echo $_SESSION['admin_username']; ?></span>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
            
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <div class="card-info">
                        <h3>Total Projects</h3>
                        <p><?php echo $projectsCount; ?></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="card-info">
                        <h3>Total Services</h3>
                        <p><?php echo $servicesCount; ?></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="card-info">
                        <h3>Total Partners</h3>
                        <p><?php echo $partnersCount; ?></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="card-info">
                        <h3>Total Messages</h3>
                        <p><?php echo $messagesCount; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="recent-messages">
                <h3>Recent Messages</h3>
                
                <?php
                if ($recentMessagesResult->num_rows > 0) {
                    while($row = $recentMessagesResult->fetch_assoc()) {
                        echo '<div class="message-item">';
                        echo '<div class="message-header">';
                        echo '<div class="message-sender">' . $row["name"] . ' (' . $row["email"] . ')</div>';
                        echo '<div class="message-date">' . date('M d, Y H:i', strtotime($row["created_at"])) . '</div>';
                        echo '</div>';
                        echo '<div class="message-subject">' . $row["subject"] . '</div>';
                        echo '<div class="message-content">' . substr($row["message"], 0, 100) . (strlen($row["message"]) > 100 ? '...' : '') . '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No messages found</p>';
                }
                ?>
                
                <a href="messages.php" class="view-all">View All Messages</a>
            </div>
        </div>
    </div>
</body>
</html>
