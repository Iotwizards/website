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

        // Check if the email already exists
        $sqlCheckEmail = "SELECT email FROM data_base WHERE email = ?";
        $stmtCheckEmail = $conn->prepare($sqlCheckEmail);
        $stmtCheckEmail->bind_param("s", $email);
        $stmtCheckEmail->execute();
        $result = $stmtCheckEmail->get_result();
        if ($result->num_rows > 0) {
            // Email already exists, display error message
            echo "<script>alert('Email already exists in the database.');</script>";
            echo "<script>window.location = './signup.html';</script>";
            exit; // Stop further execution
            
        }

        // Proceed with insertion if email doesn't exist
        
        $sqlInsert = "INSERT INTO data_base (name, email, contactNo, password, rollno, rememberMe) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);

        if ($stmtInsert === false) {
            echo "Error preparing the INSERT SQL statement: " . $conn->error;
        } else {
            
            $stmtInsert->bind_param("ssssss", $name, $email, $contactNo, $hashedPassword, $rollno, $rememberMe);

            if ($stmtInsert->execute()) {
                echo "Data successfully stored in 'users' table!";
                header("Location: index.html");
                exit; // Stop further execution
            } else {
                echo "Error inserting data into the 'users' table: " . $stmtInsert->error;
            }

            
            $stmtInsert->close();
        }

        
    } else {
        
        echo "Errors occurred:<br>";
        foreach ($errors as $error) {
            echo "- $error<br>";
        }
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
