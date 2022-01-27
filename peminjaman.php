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
						<h4 class="text-blue h4"><i class="dw dw-invoice-1"></i> Data Peminjaman</h4>
						<!-- <p class="mb-0">you can find more options <a class="text-primary" href="https://datatables.net/" target="_blank">Click Here</a></p> -->
                    </div>
					<?php if ($_SESSION['jabatan'] == 'ketua_rt'): ?>
                    <div style="padding-right:15px;">
                        <!-- <a href="barang-create"> -->
							<button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#createModal">Export</button>
                        <!-- </a> -->
                    </div>
					<?php endif; ?>
                    <div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr class="text-center">
									<th>Peminjam</th>
									<th>Barang</th>
                                    <th>Kategori</th>
									<th>Jumlah</th>
									<th>Tanggal Pinjam</th>
									<th>Tanggal Kembali</th>
									<th>Keterangan</th>
									<th>Kerusakan</th>
									<th>Catatan</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
                                <?php $no=1; $transaksis = $Transaksi->readAll(); while ($row = $transaksis->fetch(PDO::FETCH_ASSOC)) : ?>
								<tr class="text-center">
									<td><?=$row['nama_user']?></td>
									<td><?=$row['nama_barang']?></td>
                                    <td><?=$row['kategori']?></td>
									<td><?=$row['jumlah_pinjam']?></td>
									<td><?=$row['tgl_pinjam']?></td>
									<td>
										<?php if ($row['tgl_kembali'] != null): ?>
											<?=$row['tgl_kembali']?>
										<?php else: ?>
											-
										<?php endif; ?>
									</td>
									<td><?=$row['keterangan']?></td>
									<td><?=$row['kerusakan']?></td>
									<td><?=$row['catatan']?></td>
									<td><?=$row['status']?></td>
								</tr>
                                <?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->

				<!-- Modal Create-->
                <div class="modal fade" id="createModal" role="dialog">
                    <div class="modal-dialog">
                        <form method="POST">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Cari Tanggal</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Tanggal Awal<span style="color:red;">*</span></label>
										<div class="col-sm-8">
											<input type="date" class="form-control" name="tanggal_awal" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Tanggal Akhir<span style="color:red;">*</span></label>
										<div class="col-sm-8">
											<input type="date" class="form-control" name="tanggal_akhir" required>
										</div>
									</div>
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                                    <button type="submit" class="btn btn-success">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

			</div>
            <!-- footer -->
            <?php include("footer.php"); ?>
		</div>
	</div>
	<!-- js -->
    <?php include("script.php"); ?>
</body>
</html>
