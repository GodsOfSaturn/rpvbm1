<?php
include("dbconn.php");

header('Content-Type: application/json');

$data = [];

// Fetch the latest bin status
$sql = "SELECT bin_full FROM bin_status ORDER BY timestamp DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    // Assuming bin_full is 1 for full and 0 for not full
    $data['bin_status'] = $row['bin_full'] == 1 ? 'full' : 'not_full';
} else {
    $data['bin_status'] = 'not_full'; // Default value in case of error
}

// Fetch the total rewards
$sql = "SELECT reward_count FROM rewards ORDER BY timestamp DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $data['total_rewards'] = $row['reward_count'];
}

// Fetch the latest bottle count (total bottles collected)
$sql = "SELECT SUM(bottle_count) as bottle_count FROM bottle_data";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $data['bottle_count'] = $row['bottle_count'];
}

echo json_encode($data);
mysqli_close($conn);
?>
