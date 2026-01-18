<?php
// Get username and password from POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate inputs are not empty
    if (empty($username) || empty($password)) {
        echo "Error: Username and password are required.";
        exit;
    }

    // Display the received credentials (for testing purposes only)
    echo "Username: " . htmlspecialchars($username) . "<br>";
    echo "Password: " . htmlspecialchars($password) . "<br>";

    // TODO: Add authentication logic here
    // - Validate against database
    // - Hash password verification
    // - Session management

} else {
    echo "Invalid request method.";
}
?>
