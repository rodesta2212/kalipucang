<!DOCTYPE html>
<html>

<?php
    include("config.php");
	include_once('includes/barang.inc.php');

	session_start();
	if (!isset($_SESSION['id_user'])) echo "<script>location.href='login.php'</script>";
    $config = new Config(); $db = $config->getConnection();

	$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

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
			// post barang
			$Barang->id_barang = $_POST["id_barang"];
			$Barang->nama_barang = $_POST["nama_barang"];
            $Barang->kategori = $_POST["kategori"];
            $Barang->stok_barang = $_POST["stok_barang"];
			$Barang->tahun_input = $_POST["tahun_input"];

			if ($Barang->update()) {
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
						<h4 class="text-blue h4"><i class="dw dw-edit-file"></i> Update Kepala Keluarga</h4>
						<!-- <p class="mb-0">you can find more options <a class="text-primary" href="https://datatables.net/" target="_blank">Click Here</a></p> -->
                    </div>
					<form method="POST" enctype="multipart/form-data">
					<!-- hidden -->
					<input type="hidden" name="id_barang" value="<?php echo $Barang->id_barang; ?>">
					<div style="padding-right:15px;">
                        <!-- <a href="ujian-create"> -->
                            <button type="submit" class="btn btn-success float-right">Simpan</button>
                        <!-- </a> -->
                    </div>
					<!-- horizontal Basic Forms Start -->
					<div class="pd-20 mb-30">
						<div class="form-group">
							<label>Nama Barang</label>
							<input type="text" class="form-control" name="nama_barang" value="<?php echo $Barang->nama_barang; ?>">
						</div>
						<div class="form-group">
							<label>Kategori</label>
							<input type="text" class="form-control" name="kategori" value="<?php echo $Barang->kategori; ?>">
						</div>
						<div class="form-group">
							<label>Stok Barang</label>
							<input type="number" class="form-control" name="stok_barang" min="0" value="<?php echo $Barang->stok_barang; ?>">
						</div>
						<div class="form-group">
							<label>Tahun Input</label>
							<input type="number" class="form-control" name="tahun_input" min="0" value="<?php echo $Barang->tahun_input; ?>">
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
