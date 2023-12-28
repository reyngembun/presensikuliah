<?php

include("db.php");


// Hanya deklarasikan loginUser() jika belum dideklarasikan sebelumnya


// Mendeklarasikan fungsi isAdmin
function isAdmin()
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        return true;
    } else {
        return false;
    }
}
// Mendeklarasikan fungsi isMentor
function isMentor()
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'mentor') {
        return true;
    } else {
        return false;
    }
}

// Mendeklarasikan fungsi isSiswa
function isSiswa()
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'siswa') {
        return true;
    } else {
        return false;
    }
}
// functions.php

function deleteUser($userIdToDelete)
{
    global $conn;

    // Gunakan prepared statement untuk mencegah SQL injection
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userIdToDelete);

    // Eksekusi prepared statement
    $result = $stmt->execute();

    // Pemecahan masalah: Tambahkan pernyataan echo atau var_dump
    echo "Deleted rows: " . $stmt->affected_rows;

    // Tutup statement
    $stmt->close();

    return $result;
}



function getUsers()
{
    global $conn;

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $users = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}

function editUser($userId, $newUsername, $newRole)
{
    global $conn;

    $sql = "UPDATE users SET username = '$newUsername', role = '$newRole' WHERE user_id = $userId";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function getUserById($userId)
{
    global $conn;

    $sql = "SELECT * FROM users WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null;
    }
}
// Fungsi untuk mendaftarkan pengguna baru
// Fungsi untuk mendaftarkan pengguna baru
function registerUser($nama, $alamat, $no, $username, $password, $role)
{
    global $conn;

    // Escape special characters to prevent SQL injection
    $nama = mysqli_real_escape_string($conn, $nama);
    $alamat = mysqli_real_escape_string($conn, $alamat);
    $no = mysqli_real_escape_string($conn, $no);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);

    // Query SQL untuk menambahkan pengguna baru
    $sql = "INSERT INTO users (nama, alamat, no, username, password, role) VALUES ('$nama', '$alamat', '$no', '$username', '$password', '$role')";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        return true; // Registrasi berhasil
    } else {
        return false; // Registrasi gagal
    }
}


function updateUser($userId, $newUsername, $newRole)
{
    global $conn;

    $sql = "UPDATE users SET username = '$newUsername', role = '$newRole' WHERE user_id = $userId";

    if ($conn->query($sql) === TRUE) {
        return true; // Update berhasil
    } else {
        return false; // Update gagal
    }
}

function updateUserWithPassword($userId, $newUsername, $newRole, $newPassword)
{
    global $conn;

    // Escape special characters to prevent SQL injection
    $newUsername = mysqli_real_escape_string($conn, $newUsername);
    $newRole = mysqli_real_escape_string($conn, $newRole);
    $newPassword = mysqli_real_escape_string($conn, $newPassword);

    // Update query without hashing password
    $sql = "UPDATE users SET username = '$newUsername', role = '$newRole', password = '$newPassword' WHERE user_id = $userId";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }


}

function addMateri($userId, $judul, $isi)
{
    global $conn;

    // Escape inputs to prevent SQL injection
    $judul = mysqli_real_escape_string($conn, $judul);
    $isi = mysqli_real_escape_string($conn, $isi);

    // Query to insert materi with the current timestamp
    $sql = "INSERT INTO materi (user_id, judul, isi, tanggal_upload) VALUES ('$userId', '$judul', '$isi', CURRENT_TIMESTAMP)";

    if ($conn->query($sql) === TRUE) {
        // Jika materi berhasil diunggah, dapatkan ID materi yang baru saja diunggah
        $materiId = mysqli_insert_id($conn);

        // Jangan panggil presensi di sini
        // presensi($siswaId, $materiId, $hadir); // <-- Hapus baris ini

        return true;
    } else {
        return $conn->error;
    }
}





// functions.php

// Fungsi untuk menambahkan materi baru


// Fungsi untuk mendapatkan daftar materi
function getMateri($sortBy = 'tanggal_upload')
{
    global $conn;

    // Pastikan nilai sortBy adalah yang valid
    $validSortBy = ['judul', 'tanggal_upload'];
    if (!in_array($sortBy, $validSortBy)) {
        $sortBy = 'tanggal_upload';
    }

    $sql = "SELECT m.materi_id, m.judul, m.isi, m.tanggal_upload, u.nama FROM materi m JOIN users u ON m.user_id = u.user_id ORDER BY $sortBy DESC";
    $result = $conn->query($sql);

    $materiList = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $materiList[] = $row;
        }
    }

    return $materiList;
}

// Fungsi untuk mendapatkan detail materi berdasarkan ID
function getMateriById($materiId)
{
    global $conn;

    $sql = "SELECT materi.*, users.nama FROM materi JOIN users ON materi.user_id = users.user_id WHERE materi_id = $materiId";
    $result = $conn->query($sql);

    return $result->fetch_assoc();
}

// Fungsi untuk menghapus materi berdasarkan ID
function deleteMateri($materiId)
{
    global $conn;

    $sql = "DELETE FROM materi WHERE materi_id = $materiId";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return $conn->error;
    }
}

// Fungsi untuk mendapatkan daftar pengguna berdasarkan peran (role)
// Fungsi untuk mendapatkan daftar pengguna berdasarkan peran (role)
// Fungsi untuk mendapatkan daftar pengguna berdasarkan peran (role)
function getUsersByRole($role = null)
{
    global $conn;

    // Inisialisasi array untuk menyimpan kondisi query
    $conditions = array();

    // Escape special characters to prevent SQL injection
    if ($role !== null && $role !== 'all') {
        $conditions[] = "role = ?";
    }

    // Bangun query dengan kondisi jika ada
    $sql = "SELECT * FROM users";
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    // Gunakan prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameter jika role diberikan
    if ($role !== null && $role !== 'all') {
        $stmt->bind_param("s", $role);
    }

    // Eksekusi query
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();

    // Ambil data pengguna
    $users = array();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    // Tutup statement
    $stmt->close();

    return $users;
}

function getSiswaList()
{
    global $conn;
    $sql = "SELECT * FROM users WHERE role = 'siswa'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $siswaList = array();
        while ($row = $result->fetch_assoc()) {
            $siswaList[] = $row;
        }
        return $siswaList;
    } else {
        return null;
    }
}

function getMentorList()
{
    global $conn;
    $sql = "SELECT * FROM users WHERE role = 'mentor'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $mentorList = array();
        while ($row = $result->fetch_assoc()) {
            $mentorList[] = $row;
        }
        return $mentorList;
    } else {
        return null;
    }
}

// Fungsi untuk mendapatkan daftar materi


// Fungsi untuk mendapatkan daftar presensi berdasarkan materi
function getPresensiList($materiId)
{
    global $conn;
    $sql = "SELECT siswa_id FROM presensi WHERE materi_id = $materiId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $presensiList = array();
        while ($row = $result->fetch_assoc()) {
            $presensiList[] = $row['siswa_id'];
        }
        return $presensiList;
    } else {
        return array();
    }
}

// Fungsi untuk mengecek apakah siswa hadir pada materi tertentu
function isSiswaHadir($siswaId, $materiId)
{
    $presensiList = getPresensiList($materiId);
    return in_array($siswaId, $presensiList);
}

// Fungsi untuk menyimpan data presensi
// Fungsi untuk menyimpan data presensi
function presensi($siswaId, $materiId, $hadir)
{
    global $conn;

    // Gunakan prepared statement untuk mencegah SQL injection
    $stmt = $conn->prepare("INSERT INTO presensi (siswa_id, materi_id, tanggal_presensi, hadir) VALUES (?, ?, CURRENT_DATE, ?) ON DUPLICATE KEY UPDATE hadir = ?");
    $stmt->bind_param("iiii", $siswaId, $materiId, $hadir, $hadir);

    // Eksekusi prepared statement
    $result = $stmt->execute();

    // Tutup statement
    $stmt->close();

    // Kembalikan hasil eksekusi
    return $result;
}

function registerSiswa($name, $alamat, $no, $username, $password, $role)
{
    // Pengecekan hanya membuat user dengan peran "siswa"
    if ($role !== 'siswa') {
        return false; // Keluar dari fungsi jika peran bukan "siswa"
    }

    global $conn;

    // Lakukan sanitasi parameter untuk mencegah SQL injection
    $name = mysqli_real_escape_string($conn, $name);
    $alamat = mysqli_real_escape_string($conn, $alamat);
    $no = mysqli_real_escape_string($conn, $no);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash password sebelum disimpan


    // Query untuk menambahkan user ke database
    $sql = "INSERT INTO users (nama, alamat, no, username, password, role) VALUES ('$name', '$alamat', '$no', '$username', '$password', '$role')";

    if (mysqli_query($conn, $sql)) {
        return true; // Registrasi berhasil
    } else {
        return false; // Registrasi gagal
    }
}
// functions.php

// Fungsi untuk mengedit materi
function editMateri($materiId, $newJudul, $newIsi)
{
    // Panggil koneksi database atau fungsi yang diperlukan
    include("db.php");

    // Lakukan validasi data jika diperlukan

    // Hindari SQL Injection dengan menggunakan prepared statement
    $stmt = $conn->prepare("UPDATE materi SET judul = ?, isi = ? WHERE materi_id = ?");
    $stmt->bind_param("ssi", $newJudul, $newIsi, $materiId);

    if ($stmt->execute()) {
        // Edit materi berhasil
        $stmt->close();
        $conn->close();
        return true;
    } else {
        // Gagal melakukan edit materi
        $stmt->close();
        $conn->close();
        return "Error: " . $stmt->error;
    }
}

// Fungsi untuk mendapatkan detail pengguna berdasarkan ID
function getUserDetails($userId)
{
    global $pdo; // Assuming $pdo is your database connection object

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        return $userDetails;
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

// Fungsi untuk memperbarui profil pengguna
function updateProfile($userId, $newName, $newAddress, $newPhoneNumber, $newUsername, $newPassword)
{
    global $pdo; // Assuming $pdo is your database connection object

    try {
        // Check if the new username is already taken
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :new_username AND user_id != :user_id");
        $stmt->bindParam(':new_username', $newUsername, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Username already taken. Please choose a different one.";
        }

        // Update user profile
        $updateStmt = $pdo->prepare("UPDATE users SET 
            name = :new_name, 
            address = :new_address, 
            phone_number = :new_phone_number, 
            username = :new_username, 
            password = :new_password 
            WHERE user_id = :user_id");

        $updateStmt->bindParam(':new_name', $newName, PDO::PARAM_STR);
        $updateStmt->bindParam(':new_address', $newAddress, PDO::PARAM_STR);
        $updateStmt->bindParam(':new_phone_number', $newPhoneNumber, PDO::PARAM_STR);
        $updateStmt->bindParam(':new_username', $newUsername, PDO::PARAM_STR);
        $updateStmt->bindParam(':new_password', $newPassword, PDO::PARAM_STR); // Note: No hashing here

        $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $updateStmt->execute();

        return true;
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}
?>