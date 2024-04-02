<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";  
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);

    $sql = "SELECT * FROM data_base WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, display success message
            echo "<script>alert('Login successful!');</script>";
            // Redirect to dashboard or any other page
            header("Location: index.html");
            exit;
        } else {
            // Password is incorrect
            echo "<script>alert('Email or password is incorrect.');</script>";
        }
    } else {
        // Email not found
        echo "<script>alert('Email or password is incorrect.');</script>";
    }
}

$conn->close();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>