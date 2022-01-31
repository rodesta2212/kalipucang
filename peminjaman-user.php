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

	$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

	$Transaksi = new Transaksi($db);
	$Transaksi->id_user= $id;
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
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr class="text-center">
									<th>Barang</th>
                                    <th>Kategori</th>
									<th>Jumlah</th>
									<th>Tanggal Pinjam</th>
									<th>Jadwal Kembali</th>
									<th>Tanggal Kembali</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
                                <?php $no=1; $transaksis = $Transaksi->readAllUser(); while ($row = $transaksis->fetch(PDO::FETCH_ASSOC)) : ?>
								<tr class="text-center">
									<td><?=$row['nama_barang']?></td>
                                    <td><?=$row['kategori']?></td>
									<td><?=$row['jumlah_pinjam']?></td>
									<td><?=$row['tgl_pinjam']?></td>
									<td>
										<?php if ($row['jadwal_kembali'] != null || $row['jadwal_kembali'] != '0000-00-00'): ?>
											<?=$row['jadwal_kembali']?>
										<?php else: ?>
											-
										<?php endif; ?>
									</td>
									<td>
										<?php if ($row['tgl_kembali'] != null || $row['tgl_kembali'] != '0000-00-00'): ?>
											<?=$row['tgl_kembali']?>
										<?php else: ?>
											Belum Kembali
										<?php endif; ?>
									</td>
									<td><?=$row['status']?></td>
									<td>
										<?php if ($row['status'] == 'Dipinjam'): ?>
											<a class="dropdown-item link-action" href="peminjaman-kembali.php?id=<?php echo $row['id_transaksi']; ?>"><i class="dw dw-inbox"></i> Pengembalian</a>
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
