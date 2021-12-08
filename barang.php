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

    <?php
		if($_POST){
			// post barang
			$Barang->id_barang = $_POST["id_barang"];
			$Barang->nama_barang = $_POST["nama_barang"];
            $Barang->kategori = $_POST["kategori"];
            $Barang->stok_barang = $_POST["stok_barang"];
			$Barang->tahun_input = $_POST["tahun_input"];

			if($Barang->insert()){
				echo '<script language="javascript">';
                echo 'alert("Data Berhasil Terkirim")';
                echo '</script>';
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
						<h4 class="text-blue h4"><i class="dw dw-pencil"></i> Data Barang</h4>
						<!-- <p class="mb-0">you can find more options <a class="text-primary" href="https://datatables.net/" target="_blank">Click Here</a></p> -->
                    </div>
                    <div style="padding-right:15px;">
                        <!-- <a href="barang-create"> -->
                            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#createModal">Tambah</button>
                        <!-- </a> -->
                    </div>
                    <div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr class="text-center">
									<th>Nama Barang</th>
                                    <th>Stok Barang</th>
                                    <th>Kategori</th>
									<th>Tahun Input</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
                                <?php $no=1; $barangs = $Barang->readAll(); while ($row = $barangs->fetch(PDO::FETCH_ASSOC)) : ?>
								<tr class="text-center">
									<td><?=$row['nama_barang']?></td>
                                    <td><?=$row['stok_barang']?></td>
                                    <td><?=$row['kategori']?></td>
									<td><?=$row['tahun_input']?></td>
									<td>
                                        <!-- <a class="dropdown-item link-action" href="barang-detail.php?id=<?php echo $row['id_barang']; ?>"><i class="dw dw-eye"></i> Detail</a> |  -->
										<a class="dropdown-item link-action" href="barang-update.php?id=<?php echo $row['id_barang']; ?>"><i class="dw dw-edit-1"></i> Edit</a> | 
										<a class="dropdown-item link-action" href="barang-delete.php?id=<?php echo $row['id_barang']; ?>"><i class="dw dw-delete-3"></i> Delete</a>
									</td>
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
                                    <h4 class="modal-title">Tambah Data Barang</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <!-- hidden form -->
									<input type="hidden" name="id_barang" value="<?php echo $Barang->getNewId(); ?>">
									<!-- hidden form -->
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Nama Barang<span style="color:red;">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="nama_barang" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Kategori<span style="color:red;">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="kategori" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Stok Barang<span style="color:red;">*</span></label>
										<div class="col-sm-8">
											<input type="number" class="form-control" min="0" name="stok_barang" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Tahun Barang<span style="color:red;">*</span></label>
										<div class="col-sm-8">
											<input type="number" class="form-control" min="0" name="tahun_input" required>
										</div>
									</div>
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                                    <button type="submit" class="btn btn-success">Simpan</button>
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
