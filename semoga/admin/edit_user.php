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

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

// Ambil data user berdasarkan ID
$userId = $_GET['id'];
$user = getUserById($userId);

// Proses update user
// Proses update user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_user"])) {
    $newUsername = $_POST["new_username"];
    $newRole = $_POST["new_role"];
    $newPassword = $_POST["new_password"];

    // Cek apakah password baru diisi
    if (!empty($newPassword)) {
        // Jika diisi, lakukan pembaruan password
        if (updateUserWithPassword($userId, $newUsername, $newRole, $newPassword)) {
            $success_message = "User updated successfully.";
        } else {
            $error_message = "Failed to update user.";
        }
    } else {
        // Jika tidak diisi, lakukan pembaruan tanpa merubah password
        if (updateUser($userId, $newUsername, $newRole)) {
            $success_message = "User updated successfully.";
        } else {
            $error_message = "Failed to update user.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
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
        <h1 class="text-center">Edit User</h1>

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

        <!-- Form Edit User -->
        <!-- Form Edit User -->
        <form method="post" action="">
            <div class="form-group">
                <label for="new_username">New Username:</label>
                <input type="text" class="form-control" name="new_username" value="<?php echo $user['username']; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" name="new_password"
                    placeholder="Leave blank to keep current password">
            </div>

            <div class="form-group">
                <label for="new_role">Role:</label>
                <select class="form-control" name="new_role">
                    <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="mentor" <?php echo ($user['role'] === 'mentor') ? 'selected' : ''; ?>>Mentor</option>
                    <option value="siswa" <?php echo ($user['role'] === 'siswa') ? 'selected' : ''; ?>>Siswa</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="update_user">Update User</button>
        </form>


        <p class="text-center"><a href="admin_dashboard.php">Back to Dashboard</a></p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>