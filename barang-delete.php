<?php

    include("config.php");
    include_once('includes/barang.inc.php');

    session_start();
        if (!isset($_SESSION['id_user'])) echo "<script>location.href='login.php'</script>";
    $config = new Config(); $db = $config->getConnection();

    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

    $Barang = new Barang($db);
    $Barang->id_barang = $id;

    if($Barang->delete()){
        echo "<script>location.href='barang.php';</script>";
    } else{
        echo "<script>alert('Gagal Hapus Data');location.href='barang.php';</script>";
    }

?>
