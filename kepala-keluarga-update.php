<!DOCTYPE html>
<html>

<?php
    include("config.php");
	include_once('includes/kepala-keluarga.inc.php');
	include_once('includes/user.inc.php');

	session_start();
	if (!isset($_SESSION['id_user'])) echo "<script>location.href='login.php'</script>";
    $config = new Config(); $db = $config->getConnection();

	$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
	$id_user = isset($_GET['id_user']) ? $_GET['id_user'] : die('ERROR: missing ID.');

	$KepalaKeluarga = new KepalaKeluarga($db);
	$KepalaKeluarga->id_kk = $id;
	$KepalaKeluarga->readOne();

	$User = new User($db);
	$User->id_user = $id_user;
	$User->readOne();
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

			// update user
			$User->id_user = $_POST["id_user"];
			$User->nama = $_POST["nama"];
			$User->username = $_POST["username"];
			$User->password = $_POST["password"];
			$User->jabatan = $_POST["jabatan"];

			if ($KepalaKeluarga->update() && $User->update()) {
				echo '<script language="javascript">';
                echo 'alert("Data Berhasil Terkirim")';
				echo '</script>';
				echo "<script>location.href='kepala-keluarga.php'</script>";
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
					<input type="hidden" name="id_kk" value="<?php echo $KepalaKeluarga->id_kk; ?>">
					<input type="hidden" name="id_user" value="<?php echo $User->id_user; ?>">
					<input type="hidden" name="jabatan" value="<?php echo $User->jabatan; ?>">
					<div style="padding-right:15px;">
                        <!-- <a href="ujian-create"> -->
                            <button type="submit" class="btn btn-success float-right">Simpan</button>
                        <!-- </a> -->
                    </div>
					<!-- horizontal Basic Forms Start -->
					<div class="pd-20 mb-30">
						<div class="form-group">
							<label>No KK</label>
							<input type="number" class="form-control" name="no_kk" value="<?php echo $KepalaKeluarga->no_kk; ?>">
						</div>
						<div class="form-group">
							<label>Nama</label>
							<input type="text" class="form-control" name="nama" value="<?php echo $User->nama; ?>">
						</div>
						<div class="form-group">
							<label>Alamat</label>
							<input type="text" class="form-control" name="alamat" value="<?php echo $KepalaKeluarga->alamat; ?>">
						</div>
						<div class="form-group">
							<label>No Telpon</label>
							<input type="number" class="form-control" name="no_telp" value="<?php echo $KepalaKeluarga->no_telp; ?>">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="email" value="<?php echo $KepalaKeluarga->email; ?>">
						</div>
						<div class="form-group">
							<label>Username</label>
							<input type="text" class="form-control" name="username" value="<?php echo $User->username; ?>">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="text" class="form-control" name="password" value="<?php echo $User->password; ?>">
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
