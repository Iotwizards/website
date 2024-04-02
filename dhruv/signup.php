<?php
// Replace these values with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";  // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "<script>alert('Failed to connect to the database. Please try again later.');</script>";
    echo "<script>console.error('Database connection error: " . $conn->connect_error . "');</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $contactNo = test_input($_POST["contactNo"]);
    $password = test_input($_POST["password"]);
    $confirmPassword = test_input($_POST["confirmPassword"]);
    $rollno = test_input($_POST["roll_no"]);
    $rememberMe = isset($_POST["rememberMe"]) ? "Yes" : "No";

    // Validate data
    $errors = validateForm($name, $email, $contactNo, $password, $confirmPassword, $rollno);

    if (empty($errors)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the 'users' table
        $sqlInsert = "INSERT INTO data_base (name, email, contactNo, password, rollno, rememberMe) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);

        if ($stmtInsert === false) {
            echo "Error preparing the INSERT SQL statement: " . $conn->error;
            echo "<script>console.error('INSERT SQL statement preparation error: " . $conn->error . "');</script>";
        } else {
            // Bind parameters and execute the INSERT statement
            $stmtInsert->bind_param("ssssss", $name, $email, $contactNo, $hashedPassword, $rollno, $rememberMe);

            if ($stmtInsert->execute()) {
                echo "Data successfully stored in 'users' table!";
                header("Location: index.html");
                echo "<script>console.error('Data successfully stored in users table!');</script>";
            } else {
                echo "Error inserting data into the 'users' table: " . $stmtInsert->error;
                echo "<script>console.error('Error inserting data into the users table: " . $stmtInsert->error . "');</script>";
            }

            // Close the INSERT statement
            $stmtInsert->close();
        }

        
    } else {
        // If there are errors, display them
        echo "Errors occurred:<br>";
        foreach ($errors as $error) {
            echo "- $error<br>";
        }
        echo "<script>console.error('Form validation errors occurred.');</script>";
    }
}



// Function to trim and sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate form data
function validateForm($name, $email, $contactNo, $password, $confirmPassword, $rollno) {
    $errors = [];

    // You can add more specific validation rules based on your requirements
    if (empty($name) || empty($email) || empty($contactNo) || empty($password) || empty($confirmPassword) || empty($rollno)) {
        $errors[] = "All fields are required.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Password and Confirm Password do not match.";
    }

    return $errors;
}

// Close the database connection
$conn->close();
?>
