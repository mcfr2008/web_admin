<!-- <section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="login-box">
					<div class="login-logo">
						 สวัสดี
					</div>
					<div class="card shadow">
						<div class="card-body login-card-body">
							<p class="login-box-msg">เข้าสู่ระบบพื่อเริ่มต้นใช้งานโปรแกรม</p>


							<div class="alert alert-warning alert-dismissible hidden row_validate">
								<h5><i class="icon fas fa-exclamation-triangle"></i> เตือน!</h5>
								<span id="validate"></span>
							</div>

							<form method="post" id="loginForm" action="<?= site_url('/Main/login') ?>">
								<div class="input-group mb-3">
									<input type="text" class="form-control" placeholder="รหัสผู้ใช้งาน" name="username"
										id="username">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-user"></span>
										</div>
									</div>
								</div>
								<div class="input-group mb-3">
									<input type="password" class="form-control" placeholder="รหัสผ่าน" name="password"
										id="password">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-lock"></span>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-12">
										<div class="form-group">
											<select class="form-control" name="database" id="database">
												<option value="">เลือกแหล่งข้อมูล</option>
												<option value="people">บุคคล1</option>
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-7">
									</div>
									<div class="col-5">
										<button type="submit" class="btn btn-primary btn-block"><i
												class="fas fa-sign-in-alt"></i> </button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MAIN-Manage</title>

</head>


<body class="login-page Kanit-Regular" style="min-height: 466px;">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="<?= base_url('/')?>" class="h1">สวัสดี</a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">เข้าสู่ระบบพื่อเริ่มต้นใช้งานโปรแกรม</p>

				<div class="alert alert-primary alert-dismissible hidden row_validate">
					<h5><i class="icon fas fa-exclamation-triangle"></i> เตือน !</h5>
					<span id="validate"></span>
				</div>

				<form method="post" id="loginForm" action="<?= site_url('/Main/login') ?>">
					<div class="input-group mb-3">
						<input type="text" class="form-control" placeholder="รหัสผู้ใช้งาน" name="username"
							id="username">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" placeholder="รหัสผ่าน" name="password"
							id="password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<select class="form-control" name="database" id="database">
									<option value="">เลือกแหล่งข้อมูล</option>
									<option value="people">บุคคล1</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-7">
						</div>
						<div class="col-5">
							<button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ
							</button>
						</div>
					</div>
				</form>

			</div>

		</div>

	</div>



</body>
