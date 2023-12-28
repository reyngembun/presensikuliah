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

// Proses Tambah User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
    $newName = $_POST["new_name"];
    $newAlamat = $_POST["new_alamat"];
    $newNo = $_POST["new_no"];
    $newUsername = $_POST["new_username"];
    $newPassword = $_POST["new_password"];
    $newRole = $_POST["new_role"];

    // Panggil fungsi registerUser untuk menambahkan user
    if (registerSiswa($newName, $newAlamat, $newNo, $newUsername, $newPassword, $newRole)) {
        $success_message = "User added successfully.";
    } else {
        $error_message = "Failed to add user.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your custom styles here -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        h1 {
            color: #007bff;
        }

        form {
            max-width: 400px;
            margin: auto;
        }

        label {
            margin-top: 10px;
        }

        select,
        input {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center">Create Siswa</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Form Tambah User -->
        <form method="post" action="">
            <div class="form-group">
                <label for="new_name">Nama:</label>
                <input type="text" class="form-control" name="new_name" required>
            </div>

            <div class="form-group">
                <label for="new_alamat">Alamat:</label>
                <input type="text" class="form-control" name="new_alamat" required>
            </div>

            <div class="form-group">
                <label for="new_no">No Handphone:</label>
                <input type="text" class="form-control" name="new_no" required>
            </div>

            <div class="form-group">
                <label for="new_username">New Username:</label>
                <input type="text" class="form-control" name="new_username" required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" name="new_password" required>
            </div>

            <div class="form-group">
                <label for="new_role">Role:</label>
                <select class="form-control" name="new_role">
                    <option value="siswa">Siswa</option>
                </select>
            </div>

            <p class="text-center"><a href="mentor_dashboard.php">Back to Dashboard</a></p>
            <button type="submit" class="btn btn-primary" name="add_user">Register User</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>