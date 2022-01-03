    <div class="left-side-bar">
		<div class="brand-logo">
			<a href="index.php">
				<!-- <img src="vendors/images/deskapp-logo.svg" alt="" class="dark-logo"> -->
				<!-- <img src="vendors/images/deskapp-logo-white.svg" alt="" class="light-logo"> -->
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<li>
						<a href="index.php" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-home"></span><span class="mtext">Home</span>
						</a>
					</li>
					<?php if ($_SESSION['jabatan'] == 'sekretaris'): ?>
						<!-- Sekretaris -->
						<li>
							<a href="kepala-keluarga.php" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-user1"></span><span class="mtext">Kepala Keluarga</span>
							</a>
						</li>
						<li>
							<a href="barang.php" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-box"></span><span class="mtext">Barang</span>
							</a>
						</li>
						<li>
							<a href="peminjaman.php" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-invoice-1"></span><span class="mtext">Peminjaman</span>
							</a>
						</li>
					<?php elseif ($_SESSION['jabatan'] == 'ketua_rt'): ?>
						<!-- Ketua RT -->
						<li>
							<a href="barang-export.php" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-box"></span><span class="mtext">Laporan Barang</span>
							</a>
						</li>
						<li>
							<a href="peminjaman.php" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-invoice-1"></span><span class="mtext">Laporan Peminjaman</span>
							</a>
						</li>
					<?php else: ?>
						<!-- Kepala Keluarga -->
						<li>
							<a href="barang.php" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-box"></span><span class="mtext">Barang</span>
							</a>
						</li>
						<li>
							<a href="peminjaman-user.php?id=<?php echo $_SESSION['id_user']; ?>" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-invoice-1"></span><span class="mtext">Peminjaman</span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>