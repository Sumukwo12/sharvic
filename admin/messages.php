<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include '../includes/db_connect.php';

// Handle delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Delete the record
    $deleteQuery = "DELETE FROM contact_messages WHERE id = $id";
    if ($conn->query($deleteQuery) === TRUE) {
        $deleteSuccess = "Message deleted successfully";
    } else {
        $deleteError = "Error deleting message: " . $conn->error;
    }
}

// Fetch all messages
$query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Messages - Sharvic East Africa Limited</title>
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
        
        .btn-warning {
            background-color: #ff9800;
        }
        
        .btn-warning:hover {
            background-color: #e68a00;
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
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        table th {
            background-color: #f9f9f9;
            font-weight: 600;
        }
        
        table tr:hover {
            background-color: #f5f5f5;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .message-content {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 600px;
            max-width: 90%;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: #333;
        }
        
        .modal-header {
            margin-bottom: 20px;
        }
        
        .modal-footer {
            margin-top: 20px;
            text-align: right;
        }
        
        .message-details {
            margin-bottom: 20px;
        }
        
        .message-details p {
            margin-bottom: 10px;
        }
        
        .message-details strong {
            font-weight: 600;
            margin-right: 5px;
        }
        
        .message-text {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #eee;
            margin-top: 10px;
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
                    <li><a href="services.php"><i class="fas fa-cogs"></i> Services</a></li>
                    <li><a href="partners.php"><i class="fas fa-handshake"></i> Partners</a></li>
                    <li><a href="messages.php" class="active"><i class="fas fa-envelope"></i> Messages</a></li>
                    <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </div>
        </div>
        
        <div class="main-content">
            <div class="header">
                <h2>Manage Messages</h2>
                <div class="user-info">
                    <span>Welcome, <?php echo $_SESSION['admin_username']; ?></span>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
            
            <?php if (isset($deleteSuccess)): ?>
                <div class="alert alert-success">
                    <?php echo $deleteSuccess; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($deleteError)): ?>
                <div class="alert alert-danger">
                    <?php echo $deleteError; ?>
                </div>
            <?php endif; ?>
            
            <div class="content-box">
                <div class="content-header">
                    <h3>All Messages</h3>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["subject"]) . "</td>";
                                echo "<td class='message-content'>" . htmlspecialchars($row["message"]) . "</td>";
                                echo "<td>" . date('M d, Y H:i', strtotime($row["created_at"])) . "</td>";
                                echo "<td class='action-buttons'>";
                                echo "<button class='btn view-btn' data-id='" . $row["id"] . "' data-name='" . htmlspecialchars($row["name"]) . "' data-email='" . htmlspecialchars($row["email"]) . "' data-subject='" . htmlspecialchars($row["subject"]) . "' data-message='" . htmlspecialchars($row["message"]) . "' data-date='" . date('M d, Y H:i', strtotime($row["created_at"])) . "'><i class='fas fa-eye'></i> View</button>";
                                echo "<button class='btn btn-danger delete-btn' data-id='" . $row["id"] . "'><i class='fas fa-trash'></i> Delete</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' style='text-align: center;'>No messages found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- View Message Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <h3>Message Details</h3>
            </div>
            <div class="message-details">
                <p><strong>From:</strong> <span id="modalName"></span> (<span id="modalEmail"></span>)</p>
                <p><strong>Subject:</strong> <span id="modalSubject"></span></p>
                <p><strong>Date:</strong> <span id="modalDate"></span></p>
                <p><strong>Message:</strong></p>
                <div class="message-text" id="modalMessage"></div>
            </div>
            <div class="modal-footer">
                <button class="btn" id="closeModal">Close</button>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <h3>Confirm Delete</h3>
            </div>
            <p>Are you sure you want to delete this message? This action cannot be undone.</p>
            <div class="modal-footer">
                <button class="btn" id="cancelDelete">Cancel</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
    
    <script>
        // View message modal
        const viewModal = document.getElementById('viewModal');
        const viewButtons = document.querySelectorAll('.view-btn');
        const closeViewBtn = viewModal.querySelector('.close');
        const closeModalBtn = document.getElementById('closeModal');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const subject = this.getAttribute('data-subject');
                const message = this.getAttribute('data-message');
                const date = this.getAttribute('data-date');
                
                document.getElementById('modalName').textContent = name;
                document.getElementById('modalEmail').textContent = email;
                document.getElementById('modalSubject').textContent = subject;
                document.getElementById('modalMessage').textContent = message;
                document.getElementById('modalDate').textContent = date;
                
                viewModal.style.display = 'block';
            });
        });
        
        closeViewBtn.addEventListener('click', function() {
            viewModal.style.display = 'none';
        });
        
        closeModalBtn.addEventListener('click', function() {
            viewModal.style.display = 'none';
        });
        
        // Delete confirmation modal
        const deleteModal = document.getElementById('deleteModal');
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const closeDeleteBtn = deleteModal.querySelector('.close');
        const cancelBtn = document.getElementById('cancelDelete');
        const confirmBtn = document.getElementById('confirmDelete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const messageId = this.getAttribute('data-id');
                confirmBtn.href = `messages.php?delete=${messageId}`;
                deleteModal.style.display = 'block';
            });
        });
        
        closeDeleteBtn.addEventListener('click', function() {
            deleteModal.style.display = 'none';
        });
        
        cancelBtn.addEventListener('click', function() {
            deleteModal.style.display = 'none';
        });
        
        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target == viewModal) {
                viewModal.style.display = 'none';
            }
            if (event.target == deleteModal) {
                deleteModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>
