<?php
// FILE: delete_bio.php
require_once 'auth_check.php';

// Prepare a delete statement
$sql = "DELETE FROM biodata WHERE account_id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $_SESSION['id']);
    
    if ($stmt->execute()) {
        // Redirect to dashboard with success message
        header("location: dashboard.php?status=deleted");
        exit();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    $stmt->close();
}
$conn->close();
?>