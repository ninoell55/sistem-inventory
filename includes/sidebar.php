<?php
if (!isset($base_url)) {
    include __DIR__ . '../../config/config.php'; // Pastikan path benar
}
?>

<div class="flex flex-col w-64 h-screen p-5 text-white bg-blue-600">
    <a href="<?= $base_url ?>pages/dashboard.php" class="mb-5 text-xl font-bold">Sistem Inventory</a>
    <ul class="flex-1">
        <li class="flex items-center mb-3"><span class="mr-2">📦</span>
            <a href="<?= $base_url ?>pages/pemasok/index.php" class="block p-2 rounded hover:bg-blue-700">Data Pemasok</a>
        </li>
        <li class="flex items-center mb-3"><span class="mr-2">📋</span>
            <a href="<?= $base_url ?>pages/barang/index.php" class="block p-2 rounded hover:bg-blue-700">Data Barang</a>
        </li>
        <li class="flex items-center mb-3"><span class="mr-2">📋</span>
            <a href="<?= $base_url ?>pages/konsumen/index.php" class="block p-2 rounded hover:bg-blue-700">Data Konsumen</a>
        </li>
        <li class="flex items-center mb-3"><span class="mr-2">🏢</span>
            <a href="<?= $base_url ?>pages/gudang/gudang.php" class="block p-2 rounded hover:bg-blue-700">Laporan Gudang</a>
        </li>
        <li class="flex items-center mb-3"><span class="mr-2">🛒</span>
            <a href="<?= $base_url ?>pages/pembelian/form.php" class="block p-2 rounded hover:bg-blue-700">Pembelian</a>
        </li>
        <li class="flex items-center mb-3"><span class="mr-2">📊</span>
            <a href="<?= $base_url ?>pages/pembelian/laporan.php" class="block p-2 rounded hover:bg-blue-700">Laporan Pembelian</a>
        </li>
        <li class="flex items-center mb-3"><span class="mr-2">💰</span>
            <a href="<?= $base_url ?>pages/penjualan/form.php" class="block p-2 rounded hover:bg-blue-700">Penjualan</a>
        </li>
        <li class="flex items-center mb-3"><span class="mr-2">📈</span>
            <a href="<?= $base_url ?>pages/penjualan/laporan.php" class="block p-2 rounded hover:bg-blue-700">Laporan Penjualan</a>
        </li>
    </ul>
    <a href="<?= $base_url ?>auth/logout.php" class="block p-2 text-center bg-red-500 rounded hover:bg-red-600">Logout</a>
</div>