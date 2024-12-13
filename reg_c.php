<?php
session_start();
include("dbconn.php");

if (isset($_POST["register"])) {
    // Get form data
    $fname = trim($_POST['fname']);
    $sname = trim($_POST['sname']);
    $email = trim($_POST['email']);
    $password = $_POST['pswd'];
    $password2 = $_POST['cpswd'];

    $name = strtoupper($sname) . ', ' . $fname;

    if (empty($fname) || empty($sname) || empty($email) || empty($password) || empty($password2)) {
        $_SESSION['status'] = "All fields are required!";
        $_SESSION['status_type'] = "danger";
        header("Location: register.php");
        exit(0);
    } elseif ($password != $password2) {
        $_SESSION['status'] = "Passwords do not match!";
        $_SESSION['status_type'] = "danger";
        header("Location: register.php");
        exit(0);
    } else {
        try {
            // Generate user ID
            $query = "SELECT MAX(id) AS max_id FROM users";
            $result = $conn->query($query);

            if (!$result) {
                throw new Exception("Database query failed: " . $conn->error);
            }

            $row = $result->fetch_assoc();
            $new_id = isset($row['max_id']) ? $row['max_id'] + 1 : 1;
            $user_id = "pb" . str_pad($new_id, 4, "0", STR_PAD_LEFT);

            // Generate machine serial code
            $query_serial = "SELECT MAX(id) AS max_id FROM users";
            $result_serial = $conn->query($query_serial);

            if (!$result_serial) {
                throw new Exception("Database query failed for serial: " . $conn->error);
            }

            $row_serial = $result_serial->fetch_assoc();
            $serial_number = isset($row_serial['max_id']) ? $row_serial['max_id'] + 1 : 1;
            $serial_code = "pbrvmGGez" . str_pad($serial_number, 6, "0", STR_PAD_LEFT);

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $created_at = date('Y-m-d H:i:s');

            // Insert into database
            $insert_query = "INSERT INTO users (user_id, name, email, password, created_at, serial) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);

            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $conn->error);
            }

            $stmt->bind_param("ssssss", $user_id, $name, $email, $hashed_password, $created_at, $serial_code);

            if ($stmt->execute()) {
                $_SESSION['status'] = "Registration successful!";
                $_SESSION['status_type'] = "success";
                header("Location: index.php");
                exit(0);
            } else {
                throw new Exception("Registration failed: " . $stmt->error);
            }
        } catch (Exception $e) {
            $_SESSION['status'] = "Error: " . $e->getMessage();
            $_SESSION['status_type'] = "danger";
            header("Location: register.php");
            exit(0);
        }
    }
}
?>
