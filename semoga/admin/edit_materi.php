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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_materi"])) {
    $materiId = $_POST["materi_id"];
    $newJudul = $_POST["new_judul"];
    $newIsi = $_POST["new_isi"];

    $result = editMateri($materiId, $newJudul, $newIsi);

    if ($result === true) {
        $success_message = "Materi edited successfully.";
    } else {
        $error_message = "Failed to edit materi. Error: $result";
    }
}

// Ambil informasi materi dari ID yang diberikan
if (isset($_GET['id'])) {
    $materiId = $_GET['id'];
    $materiInfo = getMateriById($materiId);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Materi</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
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
            max-width: 600px;
            margin: auto;
        }

        label {
            margin-top: 10px;
        }

        select,
        input,
        textarea {
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
        <h1 class="text-center">Edit Materi</h1>

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

        <!-- Form Edit Materi -->
        <form method="post" action="">
            <input type="hidden" name="materi_id" value="<?php echo $materiId; ?>">
            <div class="form-group">
                <label for="new_judul">Judul:</label>
                <input type="text" class="form-control" name="new_judul" value="<?php echo $materiInfo['judul']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="new_isi">Isi:</label>
                <textarea class="form-control" name="new_isi" rows="4"
                    required><?php echo $materiInfo['isi']; ?></textarea>
            </div>
            <a href='materi_admin.php' class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary" name="edit_materi">Edit Materi</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>