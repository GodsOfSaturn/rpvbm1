<?php
include("dbconn.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['file_type'])) {
    $fileType = $_GET['file_type'];

    // Check file type and call the appropriate function
    if ($fileType === 'csv') {
        generateCSVReport($conn);
    } elseif ($fileType === 'txt') {
        generateTextReport($conn);
    } else {
        echo "Invalid file type.";
    }
} else {
    echo "Invalid request method or missing file type.";
}

mysqli_close($conn);

// Function to generate the CSV report
function generateCSVReport($conn) {
    $report = fetchReportData($conn);

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="report.csv"');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Write the headers to the CSV
    fputcsv($output, ['Description', 'Value']);

    // Write the report data to the CSV
    foreach ($report as $description => $value) {
        fputcsv($output, [$description, $value]);
    }

    // Close the output stream
    fclose($output);
}

// Function to generate the text report
function generateTextReport($conn) {
    $report = fetchReportData($conn);

    // Prepare the content for the text file
    $currentDate = date('Y-m-d H:i:s');
    $content = "
==========================================
               REPORT SUMMARY
==========================================
Date: $currentDate

Total Rewards:     " . $report['Total Rewards (₱)'] . "
Total Bottles Collected: " . $report['Total Bottles Collected'] . "
Bin Status:       " . $report['Bin Status'] . "

==========================================
End of Report
==========================================";

    // Set headers for text file download
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="report.txt"');

    // Output the content
    echo $content;
}

// Function to fetch report data from the database
function fetchReportData($conn) {
    $report = [];

    // Fetch total rewards
    $sql_rewards = "SELECT SUM(reward_count) AS total_rewards FROM rewards";
    $result_rewards = mysqli_query($conn, $sql_rewards);
    if ($result_rewards) {
        $row = mysqli_fetch_assoc($result_rewards);
        $report['Total Rewards (₱)'] = $row['total_rewards'] ?? 0; // Use 0 if null
    } else {
        $report['Total Rewards (₱)'] = 0;
    }

    // Fetch total bottles collected
    $sql_bottles = "SELECT SUM(bottle_count) AS total_bottles FROM bottle_data";
    $result_bottles = mysqli_query($conn, $sql_bottles);
    if ($result_bottles) {
        $row = mysqli_fetch_assoc($result_bottles);
        $report['Total Bottles Collected'] = $row['total_bottles'] ?? 0; // Use 0 if null
    } else {
        $report['Total Bottles Collected'] = 0;
    }

    // Fetch latest bin status
    $sql_bin_status = "SELECT bin_full FROM bin_status ORDER BY timestamp DESC LIMIT 1";
    $result_bin_status = mysqli_query($conn, $sql_bin_status);
    if ($result_bin_status) {
        $row = mysqli_fetch_assoc($result_bin_status);
        $report['Bin Status'] = $row['bin_full'] == 1 ? 'Full' : 'Not Full';
    } else {
        $report['Bin Status'] = 'Unknown'; // No data available
    }

    return $report;
}
?>
