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

// Proses Hapus User
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"]) && $_GET["action"] === "delete_user" && isset($_GET["id"])) {
    $userIdToDelete = $_GET["id"];

    // Panggil fungsi deleteUser untuk menghapus user
    if (deleteUser($userIdToDelete)) {
        $success_message = "User deleted successfully.";
    } else {
        $error_message = "Failed to delete user.";
    }
}

// Ambil data pengguna dari database berdasarkan filter peran
$roleFilter = isset($_GET['role']) ? $_GET['role'] : 'all';
$users = getUsersByRole($roleFilter);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                <h3>Admin Dashboard</h3>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">View Users</a>
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
                <h1>View Users</h1>
                <br>
                <form method="get" action="">
                    <label for="role">Filter Pengguna:</label>
                    <select name="role" id="role">
                        <option value="all" <?php echo ($roleFilter === 'all' || !isset($_GET['role'])) ? 'selected' : ''; ?>>All</option>
                        <option value="admin" <?php echo ($roleFilter === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="siswa" <?php echo ($roleFilter === 'siswa') ? 'selected' : ''; ?>>Siswa</option>
                        <option value="mentor" <?php echo ($roleFilter === 'mentor') ? 'selected' : ''; ?>>Mentor</option>
                    </select>
                    <button type="submit">Filter</button>
                </form>

                <!-- Users Tab -->
                <!-- Users Tab -->
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

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Alamat</th>
                            <th>No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <?php echo $user['user_id']; ?>
                                </td>
                                <td>
                                    <?php echo $user['nama']; ?>
                                </td>
                                <td>
                                    <?php echo $user['username']; ?>
                                </td>
                                <td>
                                    <?php echo $user['role']; ?>
                                </td>
                                <td>
                                    <?php echo $user['alamat']; ?>
                                </td>
                                <td>
                                    <?php echo $user['no']; ?>
                                </td>
                                <td>
                                    <a href='edit_user.php?id=<?php echo $user['user_id']; ?>'>Edit</a>
                                    <a href='viewuser.php?action=delete_user&id=<?php echo $user['user_id']; ?>'
                                        onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>


                <a class="nav-link" href="create_user.php">Create User</a>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>