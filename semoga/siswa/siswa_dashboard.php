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

// Proses Presensi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_presensi"])) {
    $materiId = $_POST["materi_id"];
    $siswaId = $_SESSION['user_id'];
    $hadir = 1; // Siswa dianggap hadir saat melihat materi

    // Cek apakah siswa sudah menginput presensi untuk materi ini
    if (!isset($_SESSION['presensi'][$materiId])) {
        // Panggil fungsi presensi untuk menyimpan data presensi
        presensi($siswaId, $materiId, $hadir);

        // Tandai materi ini sudah dihadiri
        $_SESSION['presensi'][$materiId] = true;

        $success_message = "Presensi updated successfully.";
    } else {
        $error_message = "Presensi for this material has already been submitted.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa | Dashboard</title>
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

        body {
            background-color: #f8f9fa;

        }

        .dashboard-container {
            margin: 20px;
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
    </style>
</head>

<body>

    <div class="container-fluid dashboard-container">
        <div class="row">
            <!-- Menu Container -->
            <div class="col-md-3 menu-container">
                <h3>Siswa Dashboard</h3>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="siswa_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_mentor.php">View Mentor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>

            <!-- Content Container -->
            <div class="col-md-9 content-container">
                <h1>Welcome,
                    <?php echo $_SESSION['username']; ?> (Siswa)!
                </h1>

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

                <!-- Daftar Materi -->
                <div class="materi-container">
                    <h1 class="mt-4">Materi Kuliah Seni</h1>

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
                                    <form method="post" action="">
                                        <input type="hidden" name="materi_id" value="<?php echo $materi['materi_id']; ?>">
                                        <button type="submit" name="submit_presensi" class="btn btn-primary">Input
                                            Presensi</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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