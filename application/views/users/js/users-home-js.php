<?php $check_user_access = $this->Main_model->check_user_access(); ?>

<script>

    $(document).ready(function () {
	
		action_function();

		get_users_confirm_status();

		get_access_all();

		search_function_1();
      
    });

	function search_function_1() 
	{
		var search_text = '';
		var search_confirm = '';
		search_text = $('#search_text').val();
		search_confirm = $('#search_confirm').val();
		get_users(search_text,search_confirm);
	};

	function search_function_2() 
	{
		var search_text = '';
		var search_confirm = '';
		search_text = $('#search_text').val();
		search_confirm = $('#search_confirm').val();
		$('#pageNumber').val(0);
		get_users(search_text,search_confirm);
	};

	function action_function() 
	{ 

		// list
			
			$('#search_text').keyup(function (e) { 
				e.preventDefault();
				search_function_1();
			});

			$('#search_confirm').change(function (e) { 
				e.preventDefault();
				search_function_1();
			});

			$(document).on('click','.pageNumber',function(){
				var search_text = '';
				var search_confirm = '';
				search_text = $('#search_text').val();
				search_confirm = $('#search_confirm').val();
				$('#pageNumber').val($(this).text()-1);
				get_users(search_text,search_confirm);
			});

		// END list

		$('#btn_add').click(function () {
			clear_data_manage();
		
			$('#manageModal').modal('show');
			$('#users_title').text('Add');
			$('#users_type').val('add');
		});

		$('#data_users').on('click','.btn_edit',function(){ 
			
			clear_data_manage();
			$('#manageModal').modal('show');
			$('#users_title').text('Edit');
			$('#users_type').val('edit');

			var id = $(this).closest('tr').find('.id').text();
			
			get_users_byid(id,'manage');
		});

		$('#manage_submit').click(function () { 
			

			var validate = validate_manage();

			if(validate == 'true' ){

				Swal.fire({
					title: 'คุณแน่ใจไหม',
					text: "บันทึกข้อมูล",
					showClass: {
						icon: 'animated heartBeat delay-1s'
					},
					backdrop: `rgba(49,53,56, 0.8)`,
					icon: 'question',
					allowOutsideClick: false,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'ใช่ ,ฉัน ตกลง',
					cancelButtonText: 'ปิด',
				}).then((result) => {
					if (result.isConfirmed) {
						users_manage();
					}
				})

			}

		});

		$('#data_users').on('click','.btn_del',function(){ 

			var id = $(this).closest('tr').find('.id').text();

			Swal.fire({
				title: 'คุณแน่ใจไหม',
				text: "ลบข้อมูล",
				showClass: {
					icon: 'animated heartBeat delay-1s'
				},
				backdrop: `rgba(49,53,56, 0.8)`,
				icon: 'question',
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'ใช่ ,ฉัน ตกลง',
				cancelButtonText: 'ปิด',
			}).then((result) => {
				if (result.isConfirmed) {

					delete_users(id);

				}
			})
			
		});

		$('#data_users').on('click','.btn_confirm',function(){ 
			
			clear_data_confirm();
			$('#confirmModal').modal('show');
			var id = $(this).closest('tr').find('.id').text();
			
			get_users_byid(id,'confirm');
		});

		$('#confirm_submit').click(function () { 

			Swal.fire({
				title: 'คุณแน่ใจไหม',
				text: "บันทึกข้อมูล",
				showClass: {
					icon: 'animated heartBeat delay-1s'
				},
				backdrop: `rgba(49,53,56, 0.8)`,
				icon: 'question',
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'ใช่ ,ฉัน ตกลง',
				cancelButtonText: 'ปิด',
			}).then((result) => {
				if (result.isConfirmed) {
					put_users_confirm();
				}
			})

		});

	};

	function clear_data_manage()
	{ 
		$('#users_type').val('');
		$('#users_id').val('');

		
		$('#name').val('').removeClass( "is-warning is-valid" );
		$('#username').val('').removeClass( "is-warning is-valid" );
		$('#password').val('').removeClass( "is-warning is-valid" );
		$('#email').val('').removeClass( "is-warning is-valid" );

		$('#employee_id').val('').trigger('change').removeClass( "is-warning is-valid" );
		$('#roles_id').val('').trigger('change').removeClass( "is-warning is-valid" );

	};

	function clear_data_confirm()
	{ 
	
		$('#confirm_users_id').val('');
		
		$('#confirm_name').text('');
		$('#confirm_username').text('');
		$('#confirm_email').text('');

	};

	function validate_manage() 
	{
		var validate = 'true';

		if($("#name").val() == '' ){
			$( "#name" ).removeClass( "is-valid" ).addClass( "is-warning" );
			validate = 'false';
		}else if($('#name').val() != '' ){
			$( "#name" ).removeClass( "is-warning" ).addClass( "is-valid" );
		}

		if($('#username').val() == '' ){
			$( "#username" ).removeClass( "is-valid" ).addClass( "is-warning" );
			validate = 'false';
		}else if($('#username').val() != '' ){
			$( "#username" ).removeClass( "is-warning" ).addClass( "is-valid" );
		}

		if($('#password').val() == '' ){
			$( "#password" ).removeClass( "is-valid" ).addClass( "is-warning" );
			validate = 'false';
		}else if($('#password').val() != '' ){
			$( "#password" ).removeClass( "is-warning" ).addClass( "is-valid" );
		}
	
		if($('#roles_id').val() == '' ){
			$( "#roles_id" ).removeClass( "is-valid" ).addClass( "is-warning" );
			validate = 'false';
		}else if($('#roles_id').val() != '' ){
			$( "#roles_id" ).removeClass( "is-warning" ).addClass( "is-valid" );
		}

        return validate;
		
	};

	function get_users(search_text,search_confirm) 
	{ 

		var PerPage = parseInt($('#PerPage').val());
		var pageNumber = $('#pageNumber').val();

		$.ajax({
		type: "POST",
		url: "<?= site_url('users/get_users')?>",
		data : {
			pageNumber : pageNumber ,
			PerPage : PerPage,
			search_text : search_text,
			search_confirm : search_confirm,
		},
		dataType: "JSON",
		success: function (data) {
		
			$('#data_users').empty();
			$.each(data['users'], function (id, value) { 

				var btn_edit = '';
				var btn_del = '';
				var btn_confirm = '';
			
				<?php if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/edit"])) :?>
				btn_edit = '<button class="btn btn-info btn-sm btn_edit"> <i class="fas fa-edit"></i> Edit</button> ';
				<?php endif; ?>

				<?php if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/del"])) :?>
				btn_del = '<button class="btn btn-danger btn-sm btn_del" ><i class="fa fa-trash"></i> Delete</button> ';
				<?php endif; ?>
				
				<?php if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/confirm"])) :?>
				if(value['fld_confirm_status'] == 0){
					btn_confirm = '<button class="btn btn-primary btn-sm btn_confirm" ><i class="fa fa-user-check"></i> Confirm</button> ';
				}
				<?php endif; ?>

				
				$('#data_users').append(
				'<tr>'+
					'<td class="text-center id">' + value['fld_id'] + '</td>'+
					'<td class="text-left">' + value['fld_name'] + '</td>'+
					'<td class="text-left">' + value['fld_username'] + '</td>'+
					'<td class="text-left">' + checknull(value['fld_email']) + '</td>'+
					'<td class="text-left">' + value['html_confirm_status'] + '</td>'+
					'<td class="text-left">'+ btn_edit + btn_del + btn_confirm +'</td>'+
				'</tr>'
				);

			});

			// pagination
				var total = (Math.ceil(parseInt(data['total']) / parseInt(PerPage)));
				<?php $this->load->view('tools/pagination-1-js'); ?>
			// END pagination


		}
		});

	};

	function get_access_all() 
	{ 

		$.ajax({
		type: "POST",
		url: "<?= site_url('roles/get_access_all')?>",
		dataType: "JSON",
		success: function (data) {

			$( "#roles_id" ).select2({
				theme: "bootstrap4"
			}); 

			$('#roles_id').empty();
			$('#roles_id').append('<option value="">select</option>');
			$.each(data['roles'],function(id,value){
				$('#roles_id').append(
					'<option value="'+value['fld_id']+'">'+value['fld_name']+'</option>'
				);
			});

		}
		});

	};

	function get_users_confirm_status() 
	{ 

		$.ajax({
		type: "POST",
		url: "<?= site_url('users/get_users_confirm_status')?>",
		dataType: "JSON",
		success: function (data) {
		
			$( "#search_confirm" ).select2({
				theme: "bootstrap4"
			}); 

			$('#search_confirm').empty();
			$('#search_confirm').append('<option value="">select</option>');
			$.each(data,function(id,value){
				$('#search_confirm').append(
					'<option value="'+value['id']+'">'+value['name']+'</option>'
				);
			});

		}
		});

	};

	function get_users_byid(id,type) 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('users/get_users_byid')?>",
			dataType:'JSON',
			data:{
				fld_id : id
			},
		}).done(function(data){

			// console.log(data);

			if(type == 'manage'){

				$('#users_id').val(id);
				$('#name').val(data['data']['fld_name']);
				$('#username').val(data['data']['fld_username']);
				$('#password').val(data['data']['fld_password']);
				$('#email').val(data['data']['fld_email']);
				$('#employee_id').val(data['data']['fld_employee_id']).trigger('change');
				$('#roles_id').val(data['data']['role_id']).trigger('change');
		

			}

			if(type == 'confirm'){

				$('#confirm_users_id').val(id);
				$('#confirm_name').text(data['data']['fld_name']);
				$('#confirm_username').text(data['data']['fld_username']);
				$('#confirm_email').text(checknull(data['data']['fld_email']));

			}
			

		
		
		}).fail(function(data){
		
			Swal.fire({
				icon: 'error',
				title: 'ผิดพลาด',
				text: 'อะไรบางอย่างผิดปกติ',
				backdrop: `rgba(49,53,56, 0.8)`,
				allowOutsideClick: false,
				confirmButtonText: 'ปิด',
				confirmButtonColor: '#3085d6'
			});
		
		});

	};

	function delete_users(id) 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('users/delete_users')?>",
			dataType:'JSON',
			data:{
				fld_id : id
			},
		}).done(function(data){

			if(data == 'usedata'){

				Swal.fire({
					icon: 'warning',
					title: 'เตือน',
					text: 'ข้อมูลถูกนำไปใช้งาน',
					backdrop: `rgba(49,53,56, 0.8)`,
					showClass: {
						icon: 'animated heartBeat delay-1s'
					},
					allowOutsideClick: false,
					confirmButtonText: 'ปิด',
					confirmButtonColor: '#3085d6'
				});

			}else{
				Swal.fire({
					title: 'สำเร็จ',
					text: "ลบข้อมูล",
					backdrop: `rgba(49,53,56, 0.8)`,
					icon: 'success',
					allowOutsideClick: false,
					confirmButtonColor: '#3085d6',
				}).then((result) => {
					if (result.isConfirmed) {

						search_function_1();
						
					}
				})
			}

			
		
		}).fail(function(data){
		
			Swal.fire({
				icon: 'error',
				title: 'ผิดพลาด',
				text: 'อะไรบางอย่างผิดปกติ',
				backdrop: `rgba(49,53,56, 0.8)`,
				allowOutsideClick: false,
				confirmButtonText: 'ปิด',
				confirmButtonColor: '#3085d6'
			});
		
		});

	};

	function users_manage() 
	{ 
	
		if($('#users_type').val() == 'add'){
			var url = '<?= site_url('users/post_users')?>';
		}else if($('#users_type').val() == 'edit'){
			var url = '<?= site_url('users/put_users')?>';
		}

		$('#manageModal').modal('hide');
	
		$.ajax({
			type:'POST',
			url: url,
			dataType:'JSON',
			data:{
				fld_id : $('#users_id').val(),
				fld_name : $('#name').val(),
				fld_username : $('#username').val(),
				fld_password : $('#password').val(),
				fld_email : $('#email').val(),
				fld_employee_id : $('#employee_id').val(),
				roles_id : $('#roles_id').val(),
			},
		}).done(function(data){

			Swal.fire({
				title: 'สำเร็จ',
				text: "บันทึกข้อมูล",
				backdrop: `rgba(49,53,56, 0.8)`,
				icon: 'success',
				allowOutsideClick: false,
				confirmButtonColor: '#3085d6',
			}).then((result) => {
				if (result.isConfirmed) {

					search_function_1();

			    	clear_data_manage();
				}
			})
		
		}).fail(function(data){
		
			Swal.fire({
				icon: 'error',
				title: 'ผิดพลาด',
				text: 'อะไรบางอย่างผิดปกติ',
				backdrop: `rgba(49,53,56, 0.8)`,
				allowOutsideClick: false,
				confirmButtonText: 'ปิด',
				confirmButtonColor: '#3085d6'
			});
		
		});

	};

	function put_users_confirm() 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('users/put_users_confirm')?>",
			dataType:'JSON',
			data:{
				fld_id : $('#confirm_users_id').val(),
				fld_confirm_status : 1,
			},
		}).done(function(data){

			$('#confirmModal').modal('hide');
			
			Swal.fire({
				title: 'สำเร็จ',
				text: "บันทึกข้อมูล",
				backdrop: `rgba(49,53,56, 0.8)`,
				icon: 'success',
				allowOutsideClick: false,
				confirmButtonColor: '#3085d6',
			}).then((result) => {
				if (result.isConfirmed) {

					search_function_1();
					
				}
			})
		
		}).fail(function(data){

			$('#confirmModal').modal('hide');
		
			Swal.fire({
				icon: 'error',
				title: 'ผิดพลาด',
				text: 'อะไรบางอย่างผิดปกติ',
				backdrop: `rgba(49,53,56, 0.8)`,
				allowOutsideClick: false,
				confirmButtonText: 'ปิด',
				confirmButtonColor: '#3085d6'
			});
		
		});

	};


</script>
