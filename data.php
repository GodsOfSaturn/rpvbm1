<?php
include("dbconn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST requests (for sending data from Arduino)
    $bin_status = isset($_POST['bin_status']) ? $_POST['bin_status'] : null;
    $rewards = isset($_POST['rewards']) ? $_POST['rewards'] : null;
    $bottle_data = isset($_POST['bottle_data']) ? $_POST['bottle_data'] : null;

    if ($bin_status !== null) {
        handleBinStatus($conn, $bin_status);
    }

    if ($rewards !== null) {
        handleRewards($conn, $rewards); // Updated to handle bottle count for reward calculation
    }

    if ($bottle_data !== null) {
        handleBottleData($conn, $bottle_data);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET requests (for sending real-time data to the front-end)
    fetchRealTimeData($conn);
} else {
    echo "Invalid request method.";
}

mysqli_close($conn);

// Function to fetch the latest data
function fetchRealTimeData($conn) {
    $data = [];

    // Fetch the total rewards
    $sql = "SELECT reward_count FROM rewards ORDER BY timestamp DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $data['total_rewards'] = $row['reward_count'];
    }

    // Fetch the latest bottle data (total bottles collected)
    $sql = "SELECT SUM(bottle_count) as bottle_count FROM bottle_data";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $data['bottle_count'] = $row['bottle_count'];
    }

    // Fetch the latest bin status
    $sql = "SELECT bin_full FROM bin_status ORDER BY timestamp DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $data['bin_status'] = $row['bin_full'];
    }

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
}

// Handle bin status updates
function handleBinStatus($conn, $bin_status) {
    $sql = "INSERT INTO bin_status (bin_full, timestamp) VALUES (?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'i', $bin_status);

    if (mysqli_stmt_execute($stmt)) {
        echo "Bin status recorded successfully.";
    } else {
        echo "Error recording bin status: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Handle rewards updates based on bottle count
function handleRewards($conn, $bottle_count) {
    // Calculate the rewards based on the total bottles collected
    $rewards = floor($bottle_count / 5); // 1 peso for every 5 bottles

    // Insert the calculated reward into the rewards table
    $sql = "INSERT INTO rewards (reward_count, timestamp) VALUES (?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'i', $rewards);

    if (mysqli_stmt_execute($stmt)) {
        echo "Rewards recorded successfully.";
    } else {
        echo "Error recording rewards: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
// Handle bottle data updates
function handleBottleData($conn) {
    $bottle_data = 1;  // Ensure bottle count is always 1 for each insert
    $sql = "INSERT INTO bottle_data (bottle_count, timestamp) VALUES (?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'i', $bottle_data);

    if (mysqli_stmt_execute($stmt)) {
        echo "Bottle data recorded successfully.";
    } else {
        echo "Error recording bottle data: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
