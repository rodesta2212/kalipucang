    <div class="left-side-bar">
		<div class="brand-logo">
			<a href="index.php">
				<img src="vendors/images/deskapp-logo.svg" alt="" class="dark-logo">
				<img src="vendors/images/deskapp-logo-white.svg" alt="" class="light-logo">
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
								<span class="micon dw dw-pencil"></span><span class="mtext">Kepala Keluarga</span>
							</a>
						</li>
						<li>
							<a href="barang.php" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-pencil"></span><span class="mtext">Barang</span>
							</a>
						</li>
					<?php elseif ($_SESSION['jabatan'] == 'ketua'): ?>
						<!-- Ketua RT -->
						<li>
							<a href="#" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-analytics-11"></span><span class="mtext">Laporan</span>
							</a>
						</li>
					<?php else: ?>
						<!-- Kepala Keluarga -->
						<li>
							<a href="#" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-pencil"></span><span class="mtext">Barang</span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>