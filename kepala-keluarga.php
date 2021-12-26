<!DOCTYPE html>
<html>

<?php
    include("config.php");
    include_once('includes/kepala-keluarga.inc.php');
    include_once("includes/user.inc.php");

	session_start();
	if (!isset($_SESSION['id_user'])) echo "<script>location.href='login.php'</script>";
    $config = new Config(); $db = $config->getConnection();

    $KepalaKeluarga = new KepalaKeluarga($db);
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
			// post kepala keluarga
			$KepalaKeluarga->id_kk = $_POST["id_kk"];
			$KepalaKeluarga->no_kk = $_POST["no_kk"];
            $KepalaKeluarga->no_telp = $_POST["no_telp"];
            $KepalaKeluarga->alamat = $_POST["alamat"];
			$KepalaKeluarga->email = $_POST["email"];
			$KepalaKeluarga->id_user = $_POST["id_user"];

			// post user
			$User->id_user = $_POST["id_user"];
			$User->nama = $_POST["nama"];
			$User->username = $_POST["username"];
			$User->password = $_POST["password"];
			$User->jabatan = $_POST["jabatan"];

			if($User->insert() && $KepalaKeluarga->insert()){
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
						<h4 class="text-blue h4"><i class="dw dw-user1"></i> Data Kepala Keluarga</h4>
						<!-- <p class="mb-0">you can find more options <a class="text-primary" href="https://datatables.net/" target="_blank">Click Here</a></p> -->
                    </div>
                    <div style="padding-right:15px;">
                        <!-- <a href="kepala-keluarga-create"> -->
                            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#createModal">Tambah</button>
                        <!-- </a> -->
                    </div>
                    <div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr class="text-center">
									<th>No KK</th>
									<th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No Telp</th>
									<th>Email</th>
                                    <th>Username</th>
                                    <th>Password</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
                                <?php $no=1; $kepalaKeluargas = $KepalaKeluarga->readAll(); while ($row = $kepalaKeluargas->fetch(PDO::FETCH_ASSOC)) : ?>
								<tr class="text-center">
									<td><?=$row['no_kk']?></td>
									<td><?=$row['nama']?></td>
                                    <td><?=$row['alamat']?></td>
                                    <td><?=$row['no_telp']?></td>
									<td><?=$row['email']?></td>
                                    <td><?=$row['username']?></td>
                                    <td><?=$row['password']?></td>
									<td>
                                        <!-- <a class="dropdown-item link-action" href="kepala-keluarga-detail.php?id=<?php echo $row['id_kk']; ?>&&id_user=<?php echo $row['id_user']; ?>"><i class="dw dw-eye"></i> Detail</a> |  -->
										<a class="dropdown-item link-action" href="kepala-keluarga-update.php?id=<?php echo $row['id_kk']; ?>&&id_user=<?php echo $row['id_user']; ?>"><i class="dw dw-edit-1"></i> Edit</a> | 
										<a class="dropdown-item link-action" href="kepala-keluarga-delete.php?id=<?php echo $row['id_kk']; ?>&&id_user=<?php echo $row['id_user']; ?>"><i class="dw dw-delete-3"></i> Delete</a>
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
                                    <h4 class="modal-title">Tambah Data Kepala Keluarga</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <!-- hidden form -->
									<input type="hidden" name="id_user" value="<?php echo $User->getNewId(); ?>">
									<input type="hidden" name="id_kk" value="<?php echo $KepalaKeluarga->getNewId(); ?>">
									<input type="hidden" name="jabatan" value="kepala_keluarga">
									<!-- hidden form -->
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">No KK<span style="color:red;">*</span></label>
										<div class="col-sm-8">
											<input type="number" class="form-control" name="no_kk" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Nama Lengkap<span style="color:red;">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="nama" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Username<span style="color:red;">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="username" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Password<span style="color:red;">*</span></label>
										<div class="col-sm-8">
											<input type="password" class="form-control" name="password" required>
										</div>
									</div>
                                    <div class="form-group row">
										<label class="col-sm-4 col-form-label">No Telpon<span style="color:red;">*</span></label>
										<div class="col-2" style="padding-right:5px;">
											<input class="form-control" type="text" value="62" readonly>
										</div>
										<div class="col-6" style="padding-left:0px;">
											<input class="form-control" type="number" min="0" name="no_telp" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Email<span style="color:red;">*</span></label>
										<div class="col-sm-8">
											<input type="email" class="form-control" name="email" required>
										</div>
									</div>
                                    <div class="form-group row">
										<label class="col-sm-12 col-form-label">Alamat<span style="color:red;">*</span></label>
										<div class="col-sm-12">
											<textarea class="form-control" name="alamat" required style="height:100px;"></textarea>
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
