<?php
include "../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        header("Location: ../pages/dashboard.php");
        exit();
    } else {
        $error = "Login gagal! Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="p-8 bg-white rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-center text-gray-800">Login</h2>
        <?php if (isset($error)) : ?>
            <p class="text-sm text-center text-red-500"><?= $error ?></p>
        <?php endif; ?>
        <form method="POST" class="mt-4">
            <input type="text" name="username" placeholder="Username" required
                class="w-full p-2 mb-3 border rounded">
            <input type="password" name="password" placeholder="Password" required
                class="w-full p-2 mb-3 border rounded">
            <button type="submit" class="w-full p-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                Login
            </button>
        </form>
        <p class="mt-3 text-sm text-center">Belum punya akun?
            <a href="register.php" class="text-blue-500 hover:underline">Daftar di sini</a>
        </p>
    </div>
</body>

</html>