<?php
include("header.php");
include("dbconn.php");
$query = "SELECT id, name, user_id, serial, created_at FROM users";
$result = $conn->query($query);

// Check for errors in the query execution
if (!$result) {
    die("Query failed: " . $conn->error); 
}
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

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php ">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content"><!-- Main Content -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"><!-- Topbar -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><!-- Topbar -->
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                    
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

                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
                        <div class="btn-group" role="group" aria-label="View Toggle">
                            <button class="btn btn-primary" id="listViewBtn">List View</button>
                            <button class="btn btn-secondary" id="windowedViewBtn">Windowed View</button>
                        </div>
                    </div>

                    <!-- List View -->
                    <div id="listView" class="d-none">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>User ID</th>
                                    <th>Machine Serial</th>
                                    <th>Date Created</th>
                                    <th>Health Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <?php
                                        // Simulate machine health status (e.g., placeholder logic)
                                        $health = ['good', 'warning', 'danger'][rand(0, 2)];
                                        $badgeClass = '';
                                        switch ($health) {
                                            case 'good':
                                                $badgeClass = 'badge-primary';
                                                break;
                                            case 'warning':
                                                $badgeClass = 'badge-warning';
                                                break;
                                            case 'danger':
                                                $badgeClass = 'badge-danger';
                                                break;
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= htmlspecialchars($row['name']) ?></td>
                                            <td><?= htmlspecialchars($row['user_id']) ?></td>
                                            <td><?= htmlspecialchars($row['serial']) ?></td>
                                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                                            <td><span class="badge <?= $badgeClass ?>"><?= ucfirst($health) ?></span></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No users found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Windowed View -->
                    <div id="windowedView" class="row d-none">
                        <?php if ($result->num_rows > 0): ?>
                            <?php
                            // Reset pointer to the first row for the next iteration
                            $result->data_seek(0);
                            ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php
                                // Simulate machine health status (e.g., placeholder logic)
                                $health = ['good', 'warning', 'danger'][rand(0, 2)];
                                $borderClass = '';
                                switch ($health) {
                                    case 'good':
                                        $borderClass = 'border-left-primary';
                                        break;
                                    case 'warning':
                                        $borderClass = 'border-left-warning';
                                        break;
                                    case 'danger':
                                        $borderClass = 'border-left-danger';
                                        break;
                                }
                                $badgeClass = ''; // Same logic for badge
                                switch ($health) {
                                    case 'good':
                                        $badgeClass = 'badge-primary';
                                        break;
                                    case 'warning':
                                        $badgeClass = 'badge-warning';
                                        break;
                                    case 'danger':
                                        $badgeClass = 'badge-danger';
                                        break;
                                }
                                ?>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card <?= $borderClass ?> shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1"><?= htmlspecialchars($row['name']) ?></div>
                                            <div class="text-gray-800">User ID: <?= htmlspecialchars($row['user_id']) ?></div>
                                            <div class="text-gray-800">Machine Serial: <?= htmlspecialchars($row['serial']) ?></div>
                                            <div class="text-gray-800">Date Created: <?= htmlspecialchars($row['created_at']) ?></div>
                                            <div class="text-gray-800">
                                                <span class="badge <?= $badgeClass ?>"><?= ucfirst($health) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">No users found</div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php $conn->close(); ?>

                <!-- JavaScript to Toggle Views -->
                <script>
                    const listViewBtn = document.getElementById('listViewBtn');
                    const windowedViewBtn = document.getElementById('windowedViewBtn');
                    const listView = document.getElementById('listView');
                    const windowedView = document.getElementById('windowedView');

                    listViewBtn.addEventListener('click', () => {
                        listView.classList.remove('d-none');
                        windowedView.classList.add('d-none');
                        listViewBtn.classList.add('btn-primary');
                        listViewBtn.classList.remove('btn-secondary');
                        windowedViewBtn.classList.add('btn-secondary');
                        windowedViewBtn.classList.remove('btn-primary');
                    });

                    windowedViewBtn.addEventListener('click', () => {
                        windowedView.classList.remove('d-none');
                        listView.classList.add('d-none');
                        windowedViewBtn.classList.add('btn-primary');
                        windowedViewBtn.classList.remove('btn-secondary');
                        listViewBtn.classList.add('btn-secondary');
                        listViewBtn.classList.remove('btn-primary');
                    });
                </script>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>

</body>
