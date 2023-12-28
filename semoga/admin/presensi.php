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

// Ambil daftar materi
$materiList = getMateri();
$siswaList = getSiswaList();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .dashboard-container {
            margin: 20px;
        }

        .menu-container {
            height: 100vh;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding: 20px;
        }

        .container-custom {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            overflow-x: auto;
        }

        .siswa-table {
            min-width: 100%;
            width: max-content;
        }

        .sticky-first-column th,
        .sticky-first-column td {
            min-width: 100px;
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }

        .scrolling-wrapper {
            overflow-x: auto;
            white-space: nowrap;
        }

        .sticky-first-column th:first-child,
        .sticky-first-column td:first-child {
            position: -webkit-sticky;
            position: sticky;
            left: 0;
            background-color: #f8f9fa;
            z-index: 1;
        }
    </style>
</head>

<body>

    <div class="container-fluid dashboard-container">
        <div class="row">
            <!-- Menu Container -->
            <div class="col-md-3 menu-container">
                <h3>Admin Dashboard</h3>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="viewuser.php">View Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="materi_admin.php">Manage Materi</a>
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
                <div class="container-custom">
                    <h2>Materi dan Presensi</h2>
                    <div class="scrolling-wrapper">
                        <table class="siswa-table sticky-first-column">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php foreach ($materiList as $materi): ?>
                                        <th>
                                            <?php echo $materi['judul']; ?>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($siswaList as $siswa): ?>
                                    <tr>
                                        <td>
                                            <?php echo $siswa['nama']; ?>
                                        </td>
                                        <?php foreach ($materiList as $materi): ?>
                                            <?php $siswaId = $siswa['user_id']; ?>
                                            <?php $isChecked = isSiswaHadir($siswaId, $materi['materi_id']); ?>
                                            <td>
                                                <span class="siswa-status">
                                                    <?php echo $isChecked ? 'Hadir' : 'Tidak Hadir'; ?>
                                                </span>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
