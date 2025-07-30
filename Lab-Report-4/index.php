<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & MySQL</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        ul { list-style-type: none; padding: 0; }
        li { background: #f4f4f4; margin: 5px 0; padding: 10px; border-left: 5px solid #007bff; }
    </style>
</head>
<body>

    <h1>PHP and MySQL Connection Example 🐘</h1>

    <?php
    // Include the database connection file
    require_once 'db_connection.php';

    echo "<h3>Fetching users from the database...</h3>";

    // SQL query to select all users from the 'users' table
    $sql = "SELECT id, name, email FROM users";
    $result = mysqli_query($conn, $sql);

    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        echo "<ul>";
        // Loop through each row of the result
        while($row = mysqli_fetch_assoc($result)) {
            // Display the data
            echo "<li><strong>ID:</strong> " . $row["id"]. " - <strong>Name:</strong> " . $row["name"]. " - <strong>Email:</strong> " . $row["email"]. "</li>";
        }
        echo "</ul>";
    } else {
        echo "No users found in the database.";
    }

    // Always close the connection when you're done
    mysqli_close($conn);
    ?>

</body>
</html>