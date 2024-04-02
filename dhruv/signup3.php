<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";  
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "<script>alert('Failed to connect to the database. Please try again later.');</script>";
    echo "<script>console.error('Database connection error: " . $conn->connect_error . "');</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $contactNo = test_input($_POST["contactNo"]);
    $password = test_input($_POST["password"]);
    $confirmPassword = test_input($_POST["confirmPassword"]);
    $rollno = test_input($_POST["roll_no"]);
    $rememberMe = isset($_POST["rememberMe"]) ? "Yes" : "No";

  
    $errors = validateForm($name, $email, $contactNo, $password, $confirmPassword, $rollno);

    if (empty($errors)) {
       
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $sqlInsert = "INSERT INTO data_base (name, email, contactNo, password, rollno, rememberMe) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);

        if ($stmtInsert === false) {
            echo "Error preparing the INSERT SQL statement: " . $conn->error;
            echo "<script>console.error('INSERT SQL statement preparation error: " . $conn->error . "');</script>";
        } else {
            
            $stmtInsert->bind_param("ssssss", $name, $email, $contactNo, $hashedPassword, $rollno, $rememberMe);

            if ($stmtInsert->execute()) {
                echo "Data successfully stored in 'users' table!";
                header("Location: index.html");
                echo "<script>console.error('Data successfully stored in users table!');</script>";
            } else {
                echo "Error inserting data into the 'users' table: " . $stmtInsert->error;
                echo "<script>console.error('Error inserting data into the users table: " . $stmtInsert->error . "');</script>";
            }

            
            $stmtInsert->close();
        }

        
    } else {
        
        echo "Errors occurred:<br>";
        foreach ($errors as $error) {
            echo "- $error<br>";
        }
        echo "<script>console.error('Form validation errors occurred.');</script>";
    }
}




function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function validateForm($name, $email, $contactNo, $password, $confirmPassword, $rollno) {
    $errors = [];

  
    if (empty($name) || empty($email) || empty($contactNo) || empty($password) || empty($confirmPassword) || empty($rollno)) {
        $errors[] = "All fields are required.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Password and Confirm Password do not match.";
    }

    return $errors;
}


$conn->close();
?>
