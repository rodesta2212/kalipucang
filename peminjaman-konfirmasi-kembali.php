<!DOCTYPE html>
<html>

<?php
    include("config.php");
	include_once('includes/transaksi.inc.php');
	include_once('includes/barang.inc.php');

	session_start();
	if (!isset($_SESSION['id_user'])) echo "<script>location.href='login.php'</script>";
    $config = new Config(); $db = $config->getConnection();

	$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
	$id_barang = isset($_GET['id_barang']) ? $_GET['id_barang'] : die('ERROR: missing ID Barang.');

	$Transaksi = new Transaksi($db);
	$Transaksi->id_transaksi = $id;
	$Transaksi->readOne();

	$Barang = new Barang($db);
	$Barang->id_barang = $id_barang;

?>

<!-- header -->
<?php include("header.php"); ?>

<body>
	<!-- head navbar -->
	<?php include("head-navbar.php"); ?>

	<!-- right sidebar -->
	<?php include("right-sidebar.php"); ?>

	<!-- left sidebar -->
    <?php include("left-sidebar.php"); ?>
    
	<div class="mobile-menu-overlay"></div>

    <?php
		if($_POST){
			// post barang
			$Transaksi->id_transaksi = $_POST["id_transaksi"];
			$Transaksi->id_barang = $_POST["id_barang"];
            $Transaksi->id_user = $_POST["id_user"];
            $Transaksi->jumlah_pinjam = $_POST["jumlah_pinjam"];
			$Transaksi->tgl_pinjam = $_POST["tgl_pinjam"];
            $Transaksi->jadwal_pinjam = $_POST["jadwal_pinjam"];
            $Transaksi->jadwal_kembali = $_POST["jadwal_kembali"];
            $Transaksi->tgl_kembali = $_POST["tgl_kembali"];
            $Transaksi->keterangan = $_POST["keterangan"];
            $Transaksi->status = $_POST["status"];
            $Transaksi->kerusakan = $_POST["kerusakan"];
            $Transaksi->catatan = $_POST["catatan"];
			$Transaksi->stok_barang = $_POST["stok_barang"];

			if ($_POST["kerusakan"] != 0) {
				$Barang->stok_barang = $_POST["stok_barang"]-$_POST["kerusakan"];
			}

			if ($_POST["kerusakan"] == 0) {
				if ($Transaksi->update()) {
					echo '<script language="javascript">';
					echo 'alert("Data Berhasil Terkirim")';
					echo '</script>';
					echo "<script>location.href='peminjaman-jadwal.php'</script>";
				} else {
					echo '<script language="javascript">';
					echo 'alert("Data Gagal Terkirim")';
					echo '</script>';
				}
			} else {
				if ($Transaksi->update() && $Barang->updateStok()) {
					echo '<script language="javascript">';
					echo 'alert("Data Berhasil Terkirim")';
					echo '</script>';
					echo "<script>location.href='peminjaman-jadwal.php'</script>";
				} else {
					echo '<script language="javascript">';
					echo 'alert("Data Gagal Terkirim")';
					echo '</script>';
				}
			}
			
		}
	?>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4"><i class="dw dw-edit-file"></i> Update Barang</h4>
						<!-- <p class="mb-0">you can find more options <a class="text-primary" href="https://datatables.net/" target="_blank">Click Here</a></p> -->
                    </div>
					<form method="POST" enctype="multipart/form-data">
					<!-- hidden -->
					<input type="hidden" name="id_transaksi" value="<?php echo $Transaksi->id_transaksi; ?>">
                    <input type="hidden" name="id_barang" value="<?php echo $Transaksi->id_barang; ?>">
                    <input type="hidden" name="id_user" value="<?php echo $Transaksi->id_user; ?>">
                    <input type="hidden" name="tgl_pinjam" value="<?php echo $Transaksi->tgl_pinjam; ?>">
                    <input type="hidden" name="jadwal_pinjam" value="<?php echo $Transaksi->jadwal_pinjam; ?>">
                    <input type="hidden" name="jadwal_kembali" value="<?php echo $Transaksi->jadwal_kembali; ?>">
                    <input type="hidden" name="tgl_kembali" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" name="keterangan" value="<?php echo $Transaksi->keterangan; ?>">
					<input type="hidden" name="stok_barang" value="<?php echo $Transaksi->stok_barang; ?>">
                    <input type="hidden" name="status" value="Selesai">
					<div style="padding-right:15px;">
                        <!-- <a href="ujian-create"> -->
                            <button type="submit" class="btn btn-success float-right">Simpan</button>
                        <!-- </a> -->
                    </div>
					<!-- horizontal Basic Forms Start -->
					<div class="pd-20 mb-30">
						<div class="form-group">
							<label>Nama Barang</label>
							<input type="text" class="form-control" name="nama_barang" value="<?php echo $Transaksi->nama_barang; ?>" readonly>
						</div>
                        <div class="form-group">
							<label>Kategori</label>
							<input type="text" class="form-control" name="kategori" value="<?php echo $Transaksi->kategori; ?>" readonly>
						</div>
                        <div class="form-group">
							<label>Jumlah Barang</label>
							<input type="text" class="form-control" name="jumlah_pinjam" value="<?php echo $Transaksi->jumlah_pinjam; ?>" readonly>
						</div>
						<div class="form-group">
							<label>Kerusakan</label>
							<input type="number" class="form-control" name="kerusakan" min="0" max="<?php echo $Transaksi->jumlah_pinjam; ?>" required>
						</div>
						<div class="form-group">
							<label>Catatan</label>
							<input type="text" class="form-control" name="catatan">
						</div>
					</div>
					</form>
				</div>
				<!-- Simple Datatable End -->
			</div>
            <!-- footer -->
            <?php include("footer.php"); ?>
		</div>
	</div>
	<!-- js -->
    <?php include("script.php"); ?>
</body>
</html>
