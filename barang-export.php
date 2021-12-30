<!DOCTYPE html>
<html>

<?php
    include("config.php");
    include_once('includes/barang.inc.php');

	session_start();
	if (!isset($_SESSION['id_user'])) echo "<script>location.href='login.php'</script>";
    $config = new Config(); $db = $config->getConnection();

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

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4"><i class="dw dw-box"></i> Data Barang</h4>
						<!-- <p class="mb-0">you can find more options <a class="text-primary" href="https://datatables.net/" target="_blank">Click Here</a></p> -->
                    </div>
                    <div class="pb-20">
						<table class="table stripe hover multiple-select-row data-table-export nowrap">
							<thead>
								<tr class="text-center">
									<th>Nama Barang</th>
                                    <th>Kategori</th>
									<th>Tahun Input</th>
									<th>Stok Barang</th>
									<th>Barang Dipinjam</th>
									<th>Barang Tersedia</th>
								</tr>
							</thead>
							<tbody>
                                <?php $no=1; $barangs = $Barang->readAllReady(); while ($row = $barangs->fetch(PDO::FETCH_ASSOC)) : ?>
								<tr class="text-center">
									<td><?=$row['nama_barang']?></td>
                                    <td><?=$row['kategori']?></td>
									<td><?=$row['tahun_input']?></td>
									<td><?=$row['stok_barang']?></td>
									<td><?=$row['total_pinjam']?></td>
									<td><?=$row['sisa_barang']?></td>
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
