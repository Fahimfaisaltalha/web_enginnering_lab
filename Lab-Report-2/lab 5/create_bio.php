<?php
// FILE: create_bio.php
require_once 'auth_check.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $account_id = $_SESSION['id'];
    $full_name = trim($_POST['name']);
    $dob = trim($_POST['dob']);
    $gender = trim($_POST['gender']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $marital_status = trim($_POST['marital-status']);
    $blood_group = trim($_POST['blood-group']);
    $github = trim($_POST['github']);
    $linkedin = trim($_POST['linkedin']);
    
    // Handle hobbies (checkboxes)
    $hobbies = isset($_POST['hobbies']) ? implode(', ', $_POST['hobbies']) : 'None';

    // Prepare an insert statement
    $sql = "INSERT INTO biodata (account_id, full_name, dob, gender, email, phone, address, marital_status, blood_group, hobbies, github_url, linkedin_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isssssssssss", $account_id, $full_name, $dob, $gender, $email, $phone, $address, $marital_status, $blood_group, $hobbies, $github, $linkedin);
        
        if ($stmt->execute()) {
            // Redirect to dashboard with success message
            header("location: dashboard.php?status=success");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Bio Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Create Your Bio Data</h1>
        <!-- The form is the one you provided -->
        <form id="bioForm" action="create_bio.php" method="post" novalidate>
            <!-- All form-groups from your HTML go here -->
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="marital-status">Marital Status:</label>
                <div class="radio-group">
                    <input type="radio" id="married" name="marital-status" value="married" required>
                    <label for="married">Married</label>
                    <input type="radio" id="unmarried" name="marital-status" value="unmarried" required>
                    <label for="unmarried">Unmarried</label>
                </div>
            </div>
            <div class="form-group">
                <label for="blood-group">Blood Group:</label>
                <select id="blood-group" name="blood-group" required>
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option> <option value="A-">A-</option>
                    <option value="B+">B+</option> <option value="B-">B-</option>
                    <option value="O+">O+</option> <option value="O-">O-</option>
                    <option value="AB+">AB+</option> <option value="AB-">AB-</option>
                </select>
            </div>
            <div class="form-group">
                <label>Hobbies:</label>
                <div class="checkbox-group">
                    <input type="checkbox" id="reading" name="hobbies[]" value="Reading"> <label for="reading">Reading</label>
                    <input type="checkbox" id="sports" name="hobbies[]" value="Sports"> <label for="sports">Sports</label>
                    <input type="checkbox" id="music" name="hobbies[]" value="Music"> <label for="music">Music</label>
                    <input type="checkbox" id="traveling" name="hobbies[]" value="Traveling"> <label for="traveling">Traveling</label>
                </div>
            </div>
            <div class="form-group">
                <label for="github">GitHub Profile:</label>
                <input type="url" id="github" name="github" placeholder="https://github.com/username" required>
            </div>
            <div class="form-group">
                <label for="linkedin">LinkedIn Profile:</label>
                <input type="url" id="linkedin" name="linkedin" placeholder="https://linkedin.com/in/username" required>
            </div>
            <button type="submit">Save Bio Data</button>
             <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <!-- You can include your validation JS here if you want client-side validation -->
</body>
</html>