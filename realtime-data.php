<?php
include("includesdbconn.php");

header('Content-Type: application/json');

$data = [];

// Fetch the latest bin status
$sql = "SELECT bin_full FROM bin_status ORDER BY timestamp DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $data['bin_status'] = $row['bin_full'] == 1 ? 'full' : 'not_full';
} else {
    $data['bin_status'] = 'not_full'; // Default value in case of error or no data
}

// Fetch the total rewards (sum of all reward counts)
$sql = "SELECT SUM(reward_count) as total_rewards FROM rewards";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $data['total_rewards'] = $row['total_rewards'] ?? 0; // Use default 0 if null
} else {
    $data['total_rewards'] = 0; // Default to 0 if no data is found
}

// Fetch the latest bottle count (total bottles collected)
$sql = "SELECT SUM(bottle_count) as bottle_count FROM bottle_data";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $data['bottle_count'] = $row['bottle_count'] ?? 0; // Default to 0 if null
} else {
    $data['bottle_count'] = 0; // Default to 0 if no data is found
}

echo json_encode($data);
mysqli_close($conn);
?>
