<?php
include("header.php");
?>

<body id="page-top">
 
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
            <div class="sidebar-brand-icon rotate-n-15">
            <img src="img/logo.png" alt="Company Logo" class="img-fluid" style="max-width: 60%;">
            </div>
            <div class="sidebar-brand-text mx-3">EcoPeso</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Dashboard
        </div>
        <!-- Nav Item - Pages Collapse Menu -->
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="manage.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>manange</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <button id="generate-report-btn" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" 
                                data-bs-toggle="modal" data-bs-target="#fileTypeModal">
                            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                        </button>
                    </div>

                    <!-- Modal for File Type Selection -->
                    <div class="modal fade" id="fileTypeModal" tabindex="-1" aria-labelledby="fileTypeModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="fileTypeModalLabel">Select File Type</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Please select the type of file you want to download for the report:</p>
                                    <div class="d-flex justify-content-between">
                                        <button id="download-csv" class="btn btn-primary">CSV</button>
                                        <button id="download-txt" class="btn btn-secondary">Text File</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            

                <!-- Content Grid -->
                <div class="d-flex flex-wrap justify-content-between">
                    <!-- Total Rewards Card -->
                    <div class="card mb-4" style="width: 22%; min-width: 250px;">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Rewards</div>
                            <div id="monthly-earnings" class="h5 mb-0 font-weight-bold text-gray-800">₱0</div>
                        </div>
                    </div>

                    <!-- Total Bottles Card -->
                    <div class="card mb-4" style="width: 22%; min-width: 250px;">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Bottles</div>
                            <div id="pending-requests" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                    </div>

                    <!-- Bin Status Card -->
                    <div class="card mb-4" style="width: 22%; min-width: 250px;">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Bin Status</div>
                            <div id="bin-status" class="h5 mb-0 font-weight-bold text-gray-800">Not Full</div>
                        </div>
                    </div>
                </div>
            </div>

                    <div class="row">

                <!-- Content Column -->
                <div class="col-lg-6 mb-4">

                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2021</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

    <!-- Inline JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateData() {
                // Fetch the data from your PHP script
                fetch('http://localhost/rpvbm1/realtime-data.php') // Replace with your script's path
                    .then(response => response.json()) // Parse JSON from the PHP script
                    .then(data => {
                        // Check if elements exist before updating their content
                        const monthlyEarnings = document.getElementById('monthly-earnings');
                        const pendingRequests = document.getElementById('pending-requests');
                        const tasksProgress = document.getElementById('tasks-progress');
                        const tasksProgressBar = document.getElementById('tasks-progress-bar');

                        if (monthlyEarnings) monthlyEarnings.textContent = `$${data.total_rewards || 0}`;
                        if (pendingRequests) pendingRequests.textContent = data.bottle_count || 0;
                        if (tasksProgress) tasksProgress.textContent = `${data.bin_status}%`;
                        if (tasksProgressBar) tasksProgressBar.style.width = `${data.bin_status}%`;
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Update data every 5 seconds
            setInterval(updateData, 5000);
            updateData(); // Initial data fetch
        });
   </script>
   
   <script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listener to the "Generate Report" button
    const generateReportButton = document.getElementById('generate-report-btn');

    // Add event listeners to the file type buttons in the modal
    const downloadCSVButton = document.getElementById('download-csv');
    const downloadTXTButton = document.getElementById('download-txt');

    // Prevent default behavior for the Generate Report button and show the modal
    generateReportButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default anchor behavior (page reload)
    });

    // Handle CSV download
    downloadCSVButton.addEventListener('click', function() {
        window.location.href = 'generate_report.php?file_type=csv'; // Redirect to generate CSV
    });

    // Handle Text File download
    downloadTXTButton.addEventListener('click', function() {
        window.location.href = 'generate_report.php?file_type=txt'; // Redirect to generate Text File
    });
});
</script>


</body>