<?php $check_user_access = $this->Main_model->check_user_access(); ?>
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
				<?php if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/add"])) :?>
				<div class="form-group text-right">
					<button class="btn btn-info btn-sm " id="btn_add"><i class="fas fa-plus"></i> Add new</button>
				</div>
				<?php endif; ?>
			</div>

			<div class="col-md-12">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search" id="search_text">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-secondary shadow">
					<div class="card-header">
						<h3 class="card-title"><i class="fas fa-list"></i> List</h3>
					</div>
					<div class="card-body p-0 table-responsive">
						<input type="hidden" id="pageNumber" value="0">
						<input type="hidden" id="PerPage" value="10">

						<table class="table table-hover" show-filter="true">
							<thead class="">
								<tr>
									<th class="text-center">ID</th>
									<th class="text-left">Function name</th>
									<th class="text-left">URL</th>
									<th class="text-left">Action</th>
								</tr>
							</thead>
							<tbody id="data_function">

							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<ul class="pagination pagination-sm m-0 float-left">

				</ul>
			</div>
		</div>

	</div>
</section>

<div class="modal fade" id="manageModal" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content ">
			<div class="modal-header bg-light">
				<h4 class="modal-title"><b id="function_title"></b></h4>
			</div>
			<div class="modal-body">

				<input type="hidden" id="function_type">
				<input type="hidden" id="function_id">

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label><span class="badge badge-secondary ">1</span> Function name </label>
							<input type="text" class="form-control" id="name"
								placeholder="Please fill in your information ">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label><span class="badge badge-secondary ">2</span> URL </label>
							<input type="text" class="form-control" id="url"
								placeholder="Please fill in your information">
							<small class="help-block"> URL ไม่ต้องใส่ / ด้านหน้า </small>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label><span class="badge badge-secondary ">3</span> Application </label>
							<select class="form-control" id="application_id"></select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label><span class="badge badge-secondary ">4</span> Class </label>
							<select class="form-control" id="class_id"></select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer bg-light">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"
					onclick="javascript:clear_data_manage()"><i class="fas fa-sign-out-alt"></i>
					Close</button>
				<button type="submit" class="btn btn-info" id="manage_submit"><i class="fas fa-save"></i> Save</button>
			</div>
		</div>
	</div>
</div>


