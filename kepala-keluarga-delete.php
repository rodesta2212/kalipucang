<?php

    include("config.php");
    include_once('includes/kepala-keluarga.inc.php');
    include_once('includes/user.inc.php');

    session_start();
        if (!isset($_SESSION['id_user'])) echo "<script>location.href='login.php'</script>";
    $config = new Config(); $db = $config->getConnection();

    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
    $id_user = isset($_GET['id_user']) ? $_GET['id_user'] : die('ERROR: missing ID USER.');

    $KepalaKeluarga = new KepalaKeluarga($db);
    $KepalaKeluarga->id_kk = $id;

    $User = new User($db);
    $User->id_user = $id_user;

    if($KepalaKeluarga->delete() && $User->delete()){
        echo "<script>location.href='kepala-keluarga.php';</script>";
    } else{
        echo "<script>alert('Gagal Hapus Data');location.href='kepala-keluarga.php';</script>";
    }

?>
