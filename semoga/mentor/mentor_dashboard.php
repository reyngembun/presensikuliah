<?php
session_start();

// Fungsi untuk memeriksa apakah pengguna sudah login
function isUserLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Jika pengguna belum login, redirect ke halaman login
if (!isUserLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

include("../includes/functions.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor | Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your custom styles here -->
    <style>
        .dashboard-container {
            margin: 20px;
        }

        .menu-container {
            height: 100vh;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding: 20px;
        }

        .content-container {
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="container-fluid dashboard-container">
        <div class="row">
            <!-- Menu Container -->
            <div class="col-md-3 menu-container">
                <h3>Mentor Dashboard</h3>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="view_siswa.php">View Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="materi_mentor.php">Manage Materi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="presensi.php">Presensi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>

            <!-- Content Container -->
            <div class="col-md-9 content-container">
                <h1>Welcome,
                    <?php echo $_SESSION['username']; ?> (Mentor)!
                </h1>
                <br>
                <div class="tab-content">
                    <?php if (isset($success_message)): ?>
                        <p class="alert alert-success">
                            <?php echo $success_message; ?>
                        </p>
                    <?php endif; ?>
                    <?php if (isset($error_message)): ?>
                        <p class="alert alert-danger">
                            <?php echo $error_message; ?>
                        </p>
                    <?php endif; ?>

                    <form method="post" action="">
                        <!-- Add User Form -->
                    </form>


                    <!-- Materi Tab -->
                    <div id="manage-materi" class="tab-pane fade">
                        <!-- Materi Content -->
                    </div>

                    <!-- Presensi Tab -->
                    <div id="presensi" class="tab-pane fade">

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>