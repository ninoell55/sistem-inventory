<?php
include "../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Cek apakah username sudah ada
    $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($checkUser) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php?success=registered");
            exit();
        } else {
            $error = "Registrasi gagal!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="p-8 bg-white rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-center text-gray-800">Registrasi</h2>
        <?php if (isset($error)) : ?>
            <p class="text-sm text-center text-red-500"><?= $error ?></p>
        <?php endif; ?>
        <form method="POST" class="mt-4">
            <input type="text" name="username" placeholder="Username" required
                class="w-full p-2 mb-3 border rounded">
            <input type="password" name="password" placeholder="Password" required
                class="w-full p-2 mb-3 border rounded">
            <button type="submit" class="w-full p-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                Register
            </button>
        </form>
        <p class="mt-3 text-sm text-center">Sudah punya akun?
            <a href="login.php" class="text-blue-500 hover:underline">Login di sini</a>
        </p>
    </div>
</body>

</html>