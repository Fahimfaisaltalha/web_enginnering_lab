<?php
// FILE: dashboard.php
// This is the main page after a user logs in.
require_once 'auth_check.php'; // Protect this page

// Fetch user's bio data from the database
$account_id = $_SESSION['id'];
$bio_data = null;

$stmt = $conn->prepare("SELECT * FROM biodata WHERE account_id = ?");
$stmt->bind_param("i", $account_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $bio_data = $result->fetch_assoc();
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header-nav">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        
        <h1>Your Bio Data</h1>

        <?php 
        if (isset($_GET['status']) && $_GET['status'] == 'success') {
            echo '<div class="message success">Bio data saved successfully!</div>';
        }
        if (isset($_GET['status']) && $_GET['status'] == 'deleted') {
            echo '<div class="message success">Bio data deleted successfully!</div>';
        }
        ?>

        <?php if ($bio_data): ?>
            <div class="bio-data-container">
                <h2><?php echo htmlspecialchars($bio_data['full_name']); ?></h2>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($bio_data['dob']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars(ucfirst($bio_data['gender'])); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($bio_data['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($bio_data['phone']); ?></p>
                <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($bio_data['address'])); ?></p>
                <p><strong>Marital Status:</strong> <?php echo htmlspecialchars(ucfirst($bio_data['marital_status'])); ?></p>
                <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($bio_data['blood_group']); ?></p>
                <p><strong>Hobbies:</strong> <?php echo htmlspecialchars($bio_data['hobbies']); ?></p>
                <p><strong>GitHub:</strong> <a href="<?php echo htmlspecialchars($bio_data['github_url']); ?>" target="_blank"><?php echo htmlspecialchars($bio_data['github_url']); ?></a></p>
                <p><strong>LinkedIn:</strong> <a href="<?php echo htmlspecialchars($bio_data['linkedin_url']); ?>" target="_blank"><?php echo htmlspecialchars($bio_data['linkedin_url']); ?></a></p>
                <div class="bio-actions">
                    <a href="edit_bio.php" class="btn">Edit Bio Data</a>
                    <a href="delete_bio.php" onclick="return confirm('Are you sure you want to delete your bio data? This cannot be undone.');" class="btn btn-danger">Delete Bio Data</a>
                </div>
            </div>
        <?php else: ?>
            <div class="message">
                <p>You have not created your bio data yet.</p>
                <a href="create_bio.php" class="btn">Create Your Bio Data Now</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>