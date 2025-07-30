<?php
// FILE: edit_bio.php
require_once 'auth_check.php';

$account_id = $_SESSION['id'];
$bio_data = null;

// First, fetch the existing data to pre-fill the form
$stmt = $conn->prepare("SELECT * FROM biodata WHERE account_id = ?");
$stmt->bind_param("i", $account_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $bio_data = $result->fetch_assoc();
    // For checkboxes, create an array of hobbies
    $hobbies_array = explode(', ', $bio_data['hobbies']);
} else {
    // If no data exists, redirect to create page
    header("location: create_bio.php");
    exit;
}
$stmt->close();

// Handle form submission for UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
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
    
    $hobbies = isset($_POST['hobbies']) ? implode(', ', $_POST['hobbies']) : 'None';

    // Prepare an update statement
    $sql = "UPDATE biodata SET full_name=?, dob=?, gender=?, email=?, phone=?, address=?, marital_status=?, blood_group=?, hobbies=?, github_url=?, linkedin_url=? WHERE account_id=?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssssssi", $full_name, $dob, $gender, $email, $phone, $address, $marital_status, $blood_group, $hobbies, $github, $linkedin, $account_id);
        
        if ($stmt->execute()) {
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
    <title>Edit Bio Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Your Bio Data</h1>
        <form id="bioForm" action="edit_bio.php" method="post" novalidate>
            <!-- Pre-filled form fields -->
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($bio_data['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($bio_data['dob']); ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="male" <?php if($bio_data['gender'] == 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if($bio_data['gender'] == 'female') echo 'selected'; ?>>Female</option>
                    <option value="other" <?php if($bio_data['gender'] == 'other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($bio_data['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($bio_data['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" rows="3" required><?php echo htmlspecialchars($bio_data['address']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Marital Status:</label>
                <div class="radio-group">
                    <input type="radio" id="married" name="marital-status" value="married" <?php if($bio_data['marital_status'] == 'married') echo 'checked'; ?> required>
                    <label for="married">Married</label>
                    <input type="radio" id="unmarried" name="marital-status" value="unmarried" <?php if($bio_data['marital_status'] == 'unmarried') echo 'checked'; ?> required>
                    <label for="unmarried">Unmarried</label>
                </div>
            </div>
            <div class="form-group">
                <label for="blood-group">Blood Group:</label>
                <select id="blood-group" name="blood-group" required>
                    <option value="A+" <?php if($bio_data['blood_group'] == 'A+') echo 'selected'; ?>>A+</option>
                    <option value="A-" <?php if($bio_data['blood_group'] == 'A-') echo 'selected'; ?>>A-</option>
                    <option value="B+" <?php if($bio_data['blood_group'] == 'B+') echo 'selected'; ?>>B+</option>
                    <option value="B-" <?php if($bio_data['blood_group'] == 'B-') echo 'selected'; ?>>B-</option>
                    <option value="O+" <?php if($bio_data['blood_group'] == 'O+') echo 'selected'; ?>>O+</option>
                    <option value="O-" <?php if($bio_data['blood_group'] == 'O-') echo 'selected'; ?>>O-</option>
                    <option value="AB+" <?php if($bio_data['blood_group'] == 'AB+') echo 'selected'; ?>>AB+</option>
                    <option value="AB-" <?php if($bio_data['blood_group'] == 'AB-') echo 'selected'; ?>>AB-</option>
                </select>
            </div>
            <div class="form-group">
                <label>Hobbies:</label>
                <div class="checkbox-group">
                    <input type="checkbox" id="reading" name="hobbies[]" value="Reading" <?php if(in_array('Reading', $hobbies_array)) echo 'checked'; ?>> <label for="reading">Reading</label>
                    <input type="checkbox" id="sports" name="hobbies[]" value="Sports" <?php if(in_array('Sports', $hobbies_array)) echo 'checked'; ?>> <label for="sports">Sports</label>
                    <input type="checkbox" id="music" name="hobbies[]" value="Music" <?php if(in_array('Music', $hobbies_array)) echo 'checked'; ?>> <label for="music">Music</label>
                    <input type="checkbox" id="traveling" name="hobbies[]" value="Traveling" <?php if(in_array('Traveling', $hobbies_array)) echo 'checked'; ?>> <label for="traveling">Traveling</label>
                </div>
            </div>
            <div class="form-group">
                <label for="github">GitHub Profile:</label>
                <input type="url" id="github" name="github" value="<?php echo htmlspecialchars($bio_data['github_url']); ?>" required>
            </div>
            <div class="form-group">
                <label for="linkedin">LinkedIn Profile:</label>
                <input type="url" id="linkedin" name="linkedin" value="<?php echo htmlspecialchars($bio_data['linkedin_url']); ?>" required>
            </div>
            <button type="submit">Update Bio Data</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>