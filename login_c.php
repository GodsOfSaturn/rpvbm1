<?php
session_start();
include("dbconn.php");

if (isset($_POST['login'])) {
    // Get form data
    $user_id = trim($_POST['user_id']);
    $password = $_POST['password'];

    // Check if fields are empty
    if (empty($user_id) || empty($password)) {
        $_SESSION['status'] = "Please enter both User ID and Password!";
        $_SESSION['status_type'] = "danger";
        header("Location: login.php");
        exit(0);
    }

    // Prepare query to check if the user exists
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Start the session and set user data
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            // Redirect to the dashboard
            $_SESSION['status'] = "Login successful!";
            $_SESSION['status_type'] = "success";
            header("Location: dashboard.php");
            exit(0);
        } else {
            $_SESSION['status'] = "Incorrect password!";
            $_SESSION['status_type'] = "danger";
            header("Location: login.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "User ID not found!";
        $_SESSION['status_type'] = "danger";
        header("Location: login.php");
        exit(0);
    }
}
?>