<?php

    include("config.php");
    include_once('includes/transaksi.inc.php');

    session_start();
        if (!isset($_SESSION['id_user'])) echo "<script>location.href='login.php'</script>";
    $config = new Config(); $db = $config->getConnection();

    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
    $id_user = $_SESSION['id_user'];

    $Transaksi = new Transaksi($db);
    $Transaksi->id_transaksi = $id;

    if($Transaksi->updateKonfirmasiPeminjaman()){
        echo "<script>alert('Data Berhasil Terkirim');</script>";
        echo "<script>location.href='peminjaman-jadwal.php?id=$id_user';</script>";
    } else{
        echo "<script>alert('Data Gagal Terkirim');location.href='peminjaman-jadwal.php';</script>";
    }

?>
