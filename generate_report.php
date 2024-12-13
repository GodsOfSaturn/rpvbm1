<?php
include("dbconn.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET request for generating the report
    generateReport($conn);
} else {
    echo "Invalid request method.";
}

mysqli_close($conn);

// Function to generate the report
function generateReport($conn) {
    $report = [];

    // Fetch total rewards for the report
    $sql_rewards = "SELECT SUM(reward_count) AS total_rewards FROM rewards";
    $result_rewards = mysqli_query($conn, $sql_rewards);
    if ($result_rewards) {
        $row = mysqli_fetch_assoc($result_rewards);
        $report['total_rewards'] = $row['total_rewards'];
    } else {
        $report['total_rewards'] = 0;
    }

    // Fetch total bottles collected for the report
    $sql_bottles = "SELECT SUM(bottle_count) AS total_bottles FROM bottle_data";
    $result_bottles = mysqli_query($conn, $sql_bottles);
    if ($result_bottles) {
        $row = mysqli_fetch_assoc($result_bottles);
        $report['total_bottles'] = $row['total_bottles'];
    } else {
        $report['total_bottles'] = 0;
    }

    // Fetch latest bin status for the report
    $sql_bin_status = "SELECT bin_full FROM bin_status ORDER BY timestamp DESC LIMIT 1";
    $result_bin_status = mysqli_query($conn, $sql_bin_status);
    if ($result_bin_status) {
        $row = mysqli_fetch_assoc($result_bin_status);
        $report['bin_status'] = $row['bin_full'] == 1 ? 'Full' : 'Not Full';
    } else {
        $report['bin_status'] = 'Unknown'; // No data available
    }

    // Get the current date for the report
    $currentDate = date('Y-m-d H:i:s');

    // Prepare the content for the text file
    $content = "
==========================================
               REPORT SUMMARY
==========================================
Date: $currentDate

Total Rewards:     " . $report['total_rewards'] . "
Total Bottles Collected: " . $report['total_bottles'] . "
Bin Status:       " . $report['bin_status'] . "

==========================================
End of Report
==========================================";

    // Set headers to force file download
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="report.txt"');
    
    // Output the content
    echo $content;
}
?>
