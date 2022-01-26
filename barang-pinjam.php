<!DOCTYPE html>
<html>

<?php
    include("config.php");
	include_once('includes/barang.inc.php');
	include_once('includes/transaksi.inc.php');

	session_start();
	if (!isset($_SESSION['id_user'])) echo "<script>location.href='login.php'</script>";
    $config = new Config(); $db = $config->getConnection();

	$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
	$sisa_barang = isset($_GET['sisa_barang']) ? $_GET['sisa_barang'] : die('ERROR: missing sisa barang.');

	$Transaksi = new Transaksi($db);

	$Barang = new Barang($db);
	$Barang->id_barang = $id;
	$Barang->readOne();

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
			// post transaksi from user
			$Transaksi->id_transaksi = $_POST["id_transaksi"];
			$Transaksi->id_barang = $_POST["id_barang"];
			$Transaksi->id_user = $_POST["id_user"];
			$Transaksi->jumlah_pinjam = $_POST["jumlah_pinjam"];
			$Transaksi->tgl_pinjam = $_POST["tgl_pinjam"];
			$Transaksi->jadwal_pinjam = $_POST["jadwal_pinjam"];
			$Transaksi->jadwal_kembali = $_POST["jadwal_kembali"];
			$Transaksi->keterangan = $_POST["keterangan"];
			$Transaksi->status = $_POST["status"];

			if ($Transaksi->insert()) {
				echo '<script language="javascript">';
                echo 'alert("Data Berhasil Terkirim")';
				echo '</script>';
				echo "<script>location.href='barang.php'</script>";
			} else {
				echo '<script language="javascript">';
                echo 'alert("Data Gagal Terkirim")';
                echo '</script>';
			}
		}
	?>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4"><i class="dw dw-edit-file"></i> Peminjaman Barang</h4>
						<!-- <p class="mb-0">you can find more options <a class="text-primary" href="https://datatables.net/" target="_blank">Click Here</a></p> -->
                    </div>
					<form method="POST" enctype="multipart/form-data">
					<!-- hidden form -->
					<input type="hidden" name="id_transaksi" value="<?php echo $Transaksi->getNewId(); ?>">
					<input type="hidden" name="id_barang" value="<?php echo $id; ?>">
					<input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
					<input type="hidden" name="tgl_pinjam" value="<?php echo date('Y-m-d'); ?>">
					<input type="hidden" name="jadwal_pinjam" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
					<input type="hidden" name="status" value="Konfirmasi Peminjaman">
					<!-- hidden form -->
					<div style="padding-right:15px;">
                        <!-- <a href="ujian-create"> -->
                            <button type="submit" class="btn btn-success float-right">Simpan</button>
                        <!-- </a> -->
                    </div>
					<!-- horizontal Basic Forms Start -->
					<div class="pd-20 mb-30">
						<div class="form-group">
							<label>Nama Barang</label>
							<input type="text" class="form-control" value="<?php echo $Barang->nama_barang; ?>" readonly>
						</div>
						<div class="form-group">
							<label>Kategori</label>
							<input type="text" class="form-control" value="<?php echo $Barang->kategori; ?>" readonly>
						</div>
						<div class="form-group">
							<label>Jumlah Pinjam <span style="color: red;">*maximal <?php echo $sisa_barang; ?></span></label>
							<input type="number" class="form-control" name="jumlah_pinjam" min="0" max="<?php echo $sisa_barang; ?>" required>
						</div>
						<div class="form-group">
							<label>Tanggal Kembali</label>
							<input type="date" class="form-control" name="jadwal_kembali" required>
						</div>
						<div class="form-group">
							<label>Keterangan</label>
							<input type="text" class="form-control" name="keterangan" required>
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
