<!DOCTYPE html>
<html>

<?php
    include("config.php");
	include_once('includes/transaksi.inc.php');
    include_once('includes/barang.inc.php');
	include_once('includes/user.inc.php');

	session_start();
	if (!isset($_SESSION['id_user'])) echo "<script>location.href='login.php'</script>";
    $config = new Config(); $db = $config->getConnection();

	$Transaksi = new Transaksi($db);
    $Barang = new Barang($db);
	$User = new User($db);
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
			$tanggal_awal = $_POST["tanggal_awal"];
			$tanggal_akhir = $_POST["tanggal_akhir"];

			echo "<script>location.href='peminjaman-export.php?tanggal_awal=$tanggal_awal&&tanggal_akhir=$tanggal_akhir';</script>";
		}
	?>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4"><i class="dw dw-calendar-1"></i> Jadwal</h4>
						<!-- <p class="mb-0">you can find more options <a class="text-primary" href="https://datatables.net/" target="_blank">Click Here</a></p> -->
                    </div>
                    <div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr class="text-center">
									<th>Peminjam</th>
									<th>Barang</th>
                                    <th>Kategori</th>
									<th>Jumlah</th>
									<th>Tanggal</th>
									<th>Keterangan</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
                                <?php $no=1; $transaksis = $Transaksi->readAllJadwal(); while ($row = $transaksis->fetch(PDO::FETCH_ASSOC)) : ?>
								<tr class="text-center">
									<td><?=$row['nama_user']?></td>
									<td><?=$row['nama_barang']?></td>
                                    <td><?=$row['kategori']?></td>
									<td><?=$row['jumlah_pinjam']?></td>
									<td>
										<?php if ($row['status'] == 'Konfirmasi Peminjaman'): ?>
											<?=$row['jadwal_pinjam']?>
										<?php else: ?>
											<?=$row['jadwal_kembali']?>
										<?php endif; ?>
									</td>
									<td><?=$row['keterangan']?></td>
									<td>
										<?php if ($row['status'] == 'Konfirmasi Peminjaman'): ?>
											<a class="dropdown-item link-action" href="peminjaman-konfirmasi-pinjam.php?id=<?php echo $row['id_transaksi']; ?>"><i class="dw dw-checked"></i> <?=$row['status']?></a>
										<?php else: ?>
											<a class="dropdown-item link-action" href="peminjaman-konfirmasi-kembali.php?id=<?php echo $row['id_transaksi']; ?>"><i class="dw dw-checked"></i> <?=$row['status']?></a>
										<?php endif; ?>
									</td>
								</tr>
                                <?php endwhile; ?>
							</tbody>
						</table>
					</div>
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
