function validateForm(event) {
    event.preventDefault(); // Prevent the form from submitting by default

    var email = document.getElementById("email").value;
    var contactNo = document.getElementById("contactNo").value;

    // Check if email is in the correct format
    if (!/^\S+@\S+\.\S+$/.test(email)) {
        alert("Please enter a valid email address!");
        return false;
    }

    // Check if contact number has exactly 10 digits
    if (!/^\d{10}$/.test(contactNo)) {
        alert("Contact number should have exactly 10 digits!");
        return false;
    }

    // Check if passwords match
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return false;
    }

    // Continue with form submission if all validations pass
    document.getElementById("signupForm").submit();
    // window.location.href = "nextpage.html";//next page
}
