<?php
session_start();
include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Gunakan prepared statement untuk mencegah SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Set session dan redirect ke dashboard sesuai role
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        if ($_SESSION['role'] === 'admin') {
            header("Location: admin/admin_dashboard.php");
        } elseif ($_SESSION['role'] === 'mentor') {
            header("Location: mentor/mentor_dashboard.php");
        } elseif ($_SESSION['role'] === 'siswa') {
            header("Location: siswa/siswa_dashboard.php");
        }
        exit();
    } else {
        // Login gagal
        $error_message = "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your custom styles here -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('index3.jpg');
            /* Ganti 'background-image.jpg' dengan path gambar Anda */
            background-size: cover;
            background-position: center;
            color: #000000;
            /* Warna teks diubah menjadi hitam */

        }

        .container {
            display: flex;
            max-width: 800px;
        }

        .left-content {
            flex: 1;
            padding: 20px;
        }

        .right-content {
            flex: 1;
            background-color: rgba(255, 255, 255, 0.8);
            /* Warna latar belakang formulir */
            padding: 20px;
            border-radius: 10px;
        }

        h1,
        h3 {
            color: #ffffff;
            /* Warna judul diubah menjadi putih */
        }

        form {
            max-width: 100%;
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
        <div class="left-content">
            <h1>Selamat Datang di Kuliah Seni</h1>
            <br>
            <h3>"Seperti aliran sungai yang tak pernah berhenti, seni mengalir dari hati pencipta ke hati penikmat"</h3>
        </div>

        <div class="right-content">
            <h2 class="text-center">Login</h2>

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
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary" name="login">Login</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>