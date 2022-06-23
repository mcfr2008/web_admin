
<?php

	$application_name = $this->Main_model->application_name();

	if (isset($_SESSION['people_login'])) {

		$menu = $this->Main_model->menu();

	}
  
?>



<aside class="main-sidebar elevation-2 sidebar-light-danger">

	<a href="<?= base_url('/')?>" class="brand-link">
		<img src="<?= base_url('assets/images/_logo_1.png') ?>" alt="" class="brand-image img-circle elevation-0"
			style="opacity: .8">
		<span class="brand-text font-weight-light Kanit-Regular"><?= $application_name ?></span>
	</a>

	<div class="sidebar">
		<?php if ($this->session->userdata('people_login') and $this->session->userdata('people_login') == 1) { ?>
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
				data-accordion="false">

				<?php foreach ($menu as $item){ ?>
				
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link ">
						<i class="nav-icon fas <?= $item['icon'] ?>"></i>
						<p>
							<?= $item['name'] ?>
							<?php if (isset($item['menusub'])) { ?>
							<i class="fas fa-angle-left right"></i>
							<?php } ?>
						</p>
					</a>
					<?php if (isset($item['menusub'])) { ?>
					<ul class="nav nav-treeview">
						<?php foreach ($item['menusub'] as $menusub) { ?>
						
						<li class="nav-item">
							<a href="<?= base_url('/')?><?= $menusub['url'] ?>" class="nav-link">
								<i class="nav-icon far <?= $menusub['icon'] ?> "></i>
								<p><?= $menusub['title'] ?></p>
							</a>

						</li>
					
						<?php } ?>
					</ul>
					<?php } ?>
				</li>
				
				<?php }; ?>
			</ul>
		</nav>
		<?php }; ?>
	</div>
	
</aside>

<!--  เพิ่มมาใหม่ เนื่องจากต้องการแสดงข้อมูลทั้งหมด -->
<div class="content-wrapper">
	<!--  เพิ่มมาใหม่ เนื่องจากต้องการแสดงข้อมูลทั้งหมด -->
