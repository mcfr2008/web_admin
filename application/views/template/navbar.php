            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand border-bottom-0 navbar-dark">
            	<!-- Left navbar links -->
            	<ul class="navbar-nav">
            		<li class="nav-item">
            			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
            					class="fas fa-bars"></i></a>
            		</li>
            		<!-- <li class="nav-item d-none d-sm-inline-block">
            			<a href="<?= base_url('/')?>" class="nav-link">Dashboard</a>
            		</li> -->
            	</ul>


            	<?php  if ($this->session->userdata('people_login') and $this->session->userdata('people_login') == 1) {?>
            	<!-- Right navbar links -->
            	<ul class="navbar-nav ml-auto">
            		<li class="nav-item">
            			<a class="nav-link" data-widget="fullscreen" href="#" role="button">
            				<i class="fas fa-expand-arrows-alt"></i>
            			</a>
            		</li>
            		<li class="nav-item">
            			<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"
            				id="btnLogout"><i class="fas fa-sign-out-alt"></i> </a>
            		</li>
            	</ul>
            	<?php } ?>

            </nav>
            <!-- /.navbar -->
