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

// Proses Tambah Materi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_materi"])) {
    $userId = $_SESSION['user_id'];
    $judul = $_POST["judul"];
    $isi = $_POST["isi"];

    // Panggil fungsi addMateri untuk menambahkan materi
    $result = addMateri($userId, $judul, $isi);

    if ($result === true) {
        $success_message = "Materi added successfully.";
    } else {
        $error_message = "Failed to add materi. Error: $result";
    }
}

// Ambil daftar materi
$materiList = getMateri();

// Proses Hapus Materi
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"]) && $_GET["action"] === "delete_materi" && isset($_GET["id"])) {
    $materiIdToDelete = $_GET["id"];

    // Panggil fungsi deleteMateri untuk menghapus materi
    $result = deleteMateri($materiIdToDelete);

    if ($result === true) {
        $success_message = "Materi deleted successfully.";
    } else {
        $error_message = "Failed to delete materi. Error: $result";
    }
}

?>


<!-- materi_admin.php -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Dashboard - Materi</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
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

        .materi-container {
            padding: 20px;
        }

        .materi-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .materi-card-header {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .materi-card-body {
            padding: 20px;
        }

        .materi-card-footer {
            padding: 10px;
            background-color: #f8f9fa;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .materi-action {
            margin-top: 10px;
        }

        .btn-primary,
        .btn-info,
        .btn-danger {
            margin-right: 10px;
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

            <!-- Materi Container -->
            <div class="col-md-9 materi-container">
                <h1 class="mt-4">Materi Kuliah Seni</h1>

                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Form Tambah Materi -->
                <div class="materi-card">
                    <div class="materi-card-header">
                        <h5>Tambah Materi Baru</h5>
                    </div>
                    <div class="materi-card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="judul">Judul:</label>
                                <input type="text" class="form-control" name="judul" required>
                            </div>
                            <div class="form-group">
                                <label for="isi">Isi:</label>
                                <textarea class="form-control" name="isi" rows="4" required></textarea>
                            </div>
                            <div class="materi-action">
                                <button type="submit" class="btn btn-primary" name="add_materi">Tambah Materi</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Daftar Materi -->
                <h3 class="mt-4">Daftar Materi</h3>

                <?php foreach ($materiList as $materi): ?>
                    <div class="materi-card">
                        <div class="materi-card-header">
                            <h5>
                                <?php echo $materi['judul']; ?>
                            </h5>
                        </div>
                        <div class="materi-card-body">
                            <p>
                                <?php echo $materi['isi']; ?>
                            </p>
                        </div>
                        <div class="materi-card-footer">
                            <p>Posted by
                                <?php echo $materi['nama']; ?> on
                                <?php echo $materi['tanggal_upload']; ?>
                            </p>
                            <div class="materi-action">
                                <a href='edit_materi.php?id=<?php echo $materi['materi_id']; ?>'
                                    class="btn btn-warning">Edit</a>
                                <a href='materi_mentor.php?action=delete_materi&id=<?php echo $materi['materi_id']; ?>'
                                    class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>

</body>

</html>