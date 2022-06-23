<?php $check_user_access = $this->Main_model->check_user_access();?>


<section class="content-header">



	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1><?=  $this->router->fetch_method(); ?></h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url('/')?>">Home</a> </li>
					<li class="breadcrumb-item active"><?= $this->router->fetch_class(); ?></li>
					<li class="breadcrumb-item active"><?=  $this->router->fetch_method(); ?></li>
				</ol>
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="container-fluid">

		<div class="row ">
			<div class="col-md-9">
				<div class="form-group">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group text-right">
					<button class="btn btn-info btn-sm " id="btn_roles_manage"><i class="fas fa-user-edit"></i> Manage
						roles</button>
				</div>
			</div>
		</div>

		<div class="row ">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header">
						<h3 class="card-title"><span class="badge badge-secondary ">1</span> Roles</h3>
						<div class="card-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" id="search_roles" class="form-control float-right"
									placeholder="Search">

								<div class="input-group-append">
									<button type="submit" class="btn btn-default">
										<i class="fas fa-search"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body table-responsive p-0" style="height: 300px;">
						<table class="table table-hover table-head-fixed ">

							<tbody id="data_roles">

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="row ">
			<div class="col-md-4">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title"><span class="badge badge-secondary ">2</span> Application</h3>
						<div class="card-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" id="search_application" class="form-control float-right"
									placeholder="Search">

								<div class="input-group-append">
									<button type="submit" class="btn btn-default">
										<i class="fas fa-search"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body table-responsive p-0" style="height: 300px;">
						<table class="table table-hover table-head-fixed ">

							<tbody id="data_application">

							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title"><span class="badge badge-secondary ">3</span> Class</h3>
						<div class="card-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" id="search_class" class="form-control float-right"
									placeholder="Search">

								<div class="input-group-append">
									<button type="submit" class="btn btn-default">
										<i class="fas fa-search"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body table-responsive p-0" style="height: 300px;">
						<table class="table table-hover table-head-fixed ">

							<tbody id="data_class">

							</tbody>
						</table>
					</div>
				</div>
			</div>


			<div class="col-md-4">
				<div class="card card-primary card-outline">
					<div class="card-header ">
						<h3 class="card-title"><span class="badge badge-secondary ">4</span> Function</h3>
						<div class="card-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" id="search_function" class="form-control float-right"
									placeholder="Search">

								<div class="input-group-append">
									<button type="submit" class="btn btn-default">
										<i class="fas fa-search"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body table-responsive p-0" style="height: 300px;">
						<table class="table table-hover table-head-fixed ">

							<tbody id="data_function">

							</tbody>
						</table>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-secondary" id="btn_function_select_all">Select all</button>
						<button type="submit" class="btn btn-info float-right" id="function_submit"><i
								class="fas fa-save"></i> Save</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>

<div class="modal fade" id="copyModal" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content ">
			<div class="modal-header bg-light">
				<h4 class="modal-title"><b id="">Copy</b></h4>
			</div>
			<div class="modal-body">

				<input type="hidden" id="copy_roles_id">

				<div class="row">
					<div class="col-md-12">
						<div class="info-box">
							<span class="info-box-icon bg-primary"><i class="far fa-copy"></i></span>

							<div class="info-box-content">
								<span class="info-box-text" id="copy_roles_name"></span>
								<span class="info-box-number">Copy to </span>
							</div>

						</div>

					</div>
					<div class="col-md-12">
						<select class="form-control" id="copy_to_roles_id"></select>
						<small>หมายเหตุ การคัดลอกสิทธิ์จะใช้สิทธิ์ต้นทางทั้งหมด</small>
					</div>
				</div>

			</div>
			<div class="modal-footer bg-light">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"
					onclick="javascript:clear_data_copy()"><i class="fas fa-sign-out-alt"></i>
					Close</button>
				<button type="submit" class="btn btn-info" id="copy_submit"><i class="fas fa-save"></i> Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="rolesModal" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content ">
			<div class="modal-header bg-light">
				<h4 class="modal-title"><b id="">Roles</b></h4>
			</div>
			<div class="modal-body">

				<div class="row ">
					<div class="col-md-8">
						<div class="card ">
							<div class="card-header">
								<h3 class="card-title"><i class="fas fa-list"></i> List</h3>
								<div class="card-tools">
									<div class="input-group input-group-sm" style="width: 150px;">
										<input type="text" id="search_manage_roles" class="form-control float-right"
											placeholder="Search">

										<div class="input-group-append">
											<button type="submit" class="btn btn-default">
												<i class="fas fa-search"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body table-responsive p-0" style="height: 300px;">
								<table class="table table-hover table-head-fixed ">
									<tbody id="data_manage_roles">

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card card-primary card-outline">
							<div class="card-header">
								<h3 class="card-title">Manage</h3>
							</div>
							<div class="card-body ">

								<input type="hidden" id="roles_id">
								<div class="row">
									<div class="col-md-12">
										<input type="text" id="roles_name" class="form-control "
											placeholder="Please fill in your information ">
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-secondary" id="btn_roles_reset">Reset</button>
								<button type="submit" class="btn btn-info float-right" id="roles_submit"><i
										class="fas fa-save"></i> Save</button>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer bg-light">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"
					onclick="javascript:location.reload()"><i class="fas fa-sign-out-alt"></i>
					Close</button>
			</div>
		</div>
	</div>
</div>
