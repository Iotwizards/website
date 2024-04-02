<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "user";  // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

// Perform a simple query
$sql = "SELECT * FROM `data_base`";  // Replace with your actual table name
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<br>ID: " . $row["id"] . " - Name: " . $row["name"] . " - Email: " . $row["email"];
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>