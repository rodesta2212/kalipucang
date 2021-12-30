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

	$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : die('ERROR: missing Tanggal Awal.');
	$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : die('ERROR: missing Tanggal Akhir.');

	$Transaksi = new Transaksi($db);
	$Transaksi->tanggal_awal = $tanggal_awal;
	$Transaksi->tanggal_akhir = $tanggal_akhir;

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

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4"><i class="dw dw-invoice-1"></i> Data Peminjaman</h4>
						<!-- <p class="mb-0">you can find more options <a class="text-primary" href="https://datatables.net/" target="_blank">Click Here</a></p> -->
                    </div>
                    <div class="pb-20">
						<table class="table stripe hover multiple-select-row data-table-export nowrap">
							<thead>
								<tr class="text-center">
									<th>Nama Peminjam</th>
									<th>Barang</th>
                                    <th>Kategori</th>
									<th>Jumlah</th>
									<th>Tanggal Pinjam</th>
									<th>Jadwal Kembali</th>
									<th>Tanggal Kembali</th>
									<th>Keterangan</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
                                <?php $no=1; $transaksis = $Transaksi->readAllSearch(); while ($row = $transaksis->fetch(PDO::FETCH_ASSOC)) : ?>
								<tr class="text-center">
									<td><?=$row['nama_user']?></td>
									<td><?=$row['nama_barang']?></td>
                                    <td><?=$row['kategori']?></td>
									<td><?=$row['jumlah_pinjam']?></td>
									<td><?=$row['tgl_pinjam']?></td>
									<td><?=$row['jadwal_kembali']?></td>
									<td>
										<?php if ($row['tgl_kembali'] != null): ?>
											<?=$row['tgl_kembali']?>
										<?php else: ?>
											-
										<?php endif; ?>
									</td>
									<td><?=$row['keterangan']?></td>
									<td>
										<?php if ($row['status'] == 'Selesai'): ?>
											Sudah Kembali
										<?php else: ?>
											Belum Kembali
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
