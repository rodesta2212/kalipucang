<!DOCTYPE html>
<html>

<?php
    include("config.php");
	include_once('includes/barang.inc.php');
	include_once('includes/transaksi.inc.php');

	session_start();
	if (!isset($_SESSION['id_user'])) echo "<script>location.href='login.php'</script>";
    $config = new Config(); $db = $config->getConnection();

	$Transaksi = new Transaksi($db);
	$Barang = new Barang($db);

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
			$incrementValue = $_POST["incrementValue"];
			for ($i=0; $i <= $incrementValue; $i++) { 
				// post transaksi from user
				$Transaksi->id_transaksi = $Transaksi->getNewId();
				$Transaksi->id_barang = $_POST["id_barang"][$i];
				$Transaksi->id_user = $_POST["id_user"];
				$Transaksi->jumlah_pinjam = $_POST["jumlah_pinjam"][$i];
				$Transaksi->tgl_pinjam = $_POST["tgl_pinjam"];
				$Transaksi->jadwal_pinjam = $_POST["jadwal_pinjam"];
				$Transaksi->jadwal_kembali = $_POST["jadwal_kembali"];
				$Transaksi->keterangan = $_POST["keterangan"];
				$Transaksi->status = $_POST["status"];

				if ($i == $incrementValue) {
					$Transaksi->insert();
					echo '<script language="javascript">';
					echo 'alert("Data Berhasil Terkirim")';
					echo '</script>';
					echo "<script>location.href='barang.php'</script>";
				} else {
					$Transaksi->insert();
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
						<h4 class="text-blue h4"><i class="dw dw-edit-file"></i> Peminjaman Barang</h4>
						<!-- <p class="mb-0">you can find more options <a class="text-primary" href="https://datatables.net/" target="_blank">Click Here</a></p> -->
                    </div>
					<form method="POST" enctype="multipart/form-data">
						<!-- hidden form -->
						<input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
						<input type="hidden" name="tgl_pinjam" value="<?php echo date('Y-m-d'); ?>">
						<input type="hidden" name="jadwal_pinjam" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
						<input type="hidden" name="status" value="Konfirmasi Peminjaman">
						<!-- hidden form -->
						<div style="padding-right:15px; padding-bottom:40px;">
							<!-- <a href="ujian-create"> -->
								<button type="submit" class="btn btn-success float-right">Simpan</button>
								<a href="#" onclick="incrementValue()" class="add-barang btn btn-primary float-right" style="margin-right:20px;">Tambah Barang</a>
							<!-- </a> -->
						</div>
						<!-- horizontal Basic Forms Start -->
						<input type="hidden" id="number" name="incrementValue" value="0"/>
						<div id="card-barang"class="pd-20 mb-30 row">
							<div class="form-group col-6">
								<label>Tanggal Kembali <span style="color: red;">*</span></label>
								<input type="date" class="form-control" name="jadwal_kembali" required>
							</div>
							<div class="form-group col-6">
								<label>Keterangan <span style="color: red;">*</span></label>
								<input type="text" class="form-control" name="keterangan" required>
							</div>
						</div>

						<template id="form-add-barang">
							<div class="form-group col-6">
								<label>Barang <span style="color: red;">*</span></label>
								<select class="form-control" name="id_barang[]" required>
									<option selected disabled>Pilih...</option>
									<?php $barangs = $Barang->readAllReady(); while ($row = $barangs->fetch(PDO::FETCH_ASSOC)) : ?>
										<option value="<?=$row['id_barang']?>"><?=$row['nama_barang']?> (<?=$row['kategori']?>), Sisa Barang : <?=$row['sisa_barang']?></option>
									<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group col-6">
								<label>Jumlah Pinjam <span style="color: red;">*</span></label>
								<input type="number" class="form-control" name="jumlah_pinjam[]" min="0" required>
							</div>
						</template>

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
