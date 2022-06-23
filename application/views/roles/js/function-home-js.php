<?php $check_user_access = $this->Main_model->check_user_access(); ?>

<script>

    $(document).ready(function () {
	
		action_function();

		// get_application_all();

		search_function_1();
      
    });

	function search_function_1() 
	{
		var search_text = '';
		search_text = $('#search_text').val();
		get_function(search_text);
	};

	function search_function_2() 
	{
		var search_text = '';
		search_text = $('#search_text').val();
		$('#pageNumber').val(0);
		get_function(search_text);
	};

	function action_function() 
	{ 

		// list
			
			$('#search_text').keyup(function (e) { 
				e.preventDefault();
				search_function_1();
			});

			$(document).on('click','.pageNumber',function(){
				var search_text = '';
				search_text = $('#search_text').val();
				$('#pageNumber').val($(this).text()-1);
				get_function(search_text);
			});

		// END list

		$('#btn_add').click(function () {
			clear_data_manage();
			$('#manageModal').modal('show');
			$('#function_title').text('Add');
			$('#function_type').val('add');

			get_application_all();
		});

		$('#data_function').on('click','.btn_edit',function(){ 
			
			clear_data_manage();
			$('#manageModal').modal('show');
			$('#function_title').text('Edit');
			$('#function_type').val('edit');

			var id = $(this).closest('tr').find('.id').text();
			var application_id = $(this).closest('tr').find('.application_id').text();
			
			// get_class_byapplication(application_id);

			get_application_all();
			
			setTimeout(function() { 
				get_function_byid(id);
			}, 2000);
			
			

		});

		$('#application_id').change(function (e) { 
			e.preventDefault();
			var id = $('#application_id').val();
			get_class_byapplication(id);
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
						function_manage();
					}
				})

			}

		});

		$('#data_function').on('click','.btn_del',function(){ 

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

					delete_function(id);

				}
			})
			
		});

	};

	function clear_data_manage()
	{ 
		$('#function_type').val('');
		$('#function_id').val('');

		$('#url').val('').removeClass( "is-warning is-valid" );
		$('#name').val('').removeClass( "is-warning is-valid" );
		$('#application_id').val('').trigger('change').removeClass( "is-warning is-valid" );
		$('#class_id').val('').trigger('change').removeClass( "is-warning is-valid" );
		

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

		if($('#url').val() == '' ){
			$( "#url" ).removeClass( "is-valid" ).addClass( "is-warning" );
			validate = 'false';
		}else if($('#url').val() != '' ){
			$( "#url" ).removeClass( "is-warning" ).addClass( "is-valid" );
		}

		if($('#application_id').val() == '' ){
			$( "#application_id" ).removeClass( "is-valid" ).addClass( "is-warning" );
			validate = 'false';
		}else if($('#application_id').val() != '' ){
			$( "#application_id" ).removeClass( "is-warning" ).addClass( "is-valid" );
		}

		if($('#class_id').val() == '' ){
			$( "#class_id" ).removeClass( "is-valid" ).addClass( "is-warning" );
			validate = 'false';
		}else if($('#class_id').val() != '' ){
			$( "#class_id" ).removeClass( "is-warning" ).addClass( "is-valid" );
		}

        return validate;
		
	};

	function get_function(search_text) 
	{ 

		var PerPage = parseInt($('#PerPage').val());
		var pageNumber = $('#pageNumber').val();

		$.ajax({
		type: "POST",
		url: "<?= site_url('roles/get_function')?>",
		data : {
			pageNumber : pageNumber ,
			PerPage : PerPage,
			search_text : search_text
		},
		dataType: "JSON",
		success: function (data) {
		
			$('#data_function').empty();
			$.each(data['function'], function (id, value) { 

				var btn_edit = '';
				var btn_del = '';
			
				<?php if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/edit"])) :?>
				btn_edit = '<button class="btn btn-info btn-sm btn_edit"> <i class="fas fa-edit"></i> Edit</button> ';
				<?php endif; ?>

				<?php if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/del"])) :?>
				btn_del = '<button class="btn btn-danger btn-sm btn_del" ><i class="fa fa-trash"></i> Delete</button> ';
				<?php endif; ?>
							
				$('#data_function').append(
				'<tr>'+
					'<td class="text-center id">' + value['fld_id'] + '</td>'+
					'<td class="text-center application_id">' + value['fld_application_id'] + '</td>'+
					'<td class="text-left">' + 
						'' + value['fld_name'] + '' + 
						'<br>' +
						'<small>' + value['class_name'] + '</small>' + 
						'<br>' +
						'<small>' + value['application_name'] + '</small>' + 
					'</td>'+
					'<td class="text-left">' + value['fld_url'] + '</td>'+
					'<td class="text-left">'+ btn_edit + btn_del +'</td>'+
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

	function get_application_all() 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/get_application_all')?>",
			dataType:'JSON',
		}).done(function(data){

			$( "#application_id" ).select2({
				theme: "bootstrap4"
			}); 

			$('#application_id').empty();
			$('#application_id').append('<option value="">select</option>');
			$.each(data['application'],function(id,val){
				$('#application_id').append(
					'<option value="'+val['fld_id']+'">'+val['fld_name']+'</option>'
				);
			});
		
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

	function get_class_byapplication(id) 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/get_class_byapplication')?>",
			dataType:'JSON',
			data : {
				fld_application_id : id
			},
		}).done(function(data){

			console.log(data)

			$( "#class_id" ).select2({
				theme: "bootstrap4"
			}); 

			$('#class_id').empty();
			$('#class_id').append('<option value="">select</option>');
			$.each(data['class'],function(id,val){
				$('#class_id').append(
					'<option value="'+val['fld_id']+'">'+val['fld_name']+'</option>'
				);
			});
		
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

	function get_function_byid(id) 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/get_function_byid')?>",
			dataType:'JSON',
			data:{
				fld_id : id
			},
		}).done(function(data){

			console.log(data);

			$('#function_id').val(id);
			$('#name').val(data['data']['fld_name']);
			$('#application_id').val(data['data']['fld_application_id']).trigger('change');
			$('#url').val(data['data']['fld_url']);
			
			
			setTimeout(function() { 
				$('#class_id').val(data['data']['fld_class_id']).trigger('change');
			}, 3000);
			
		
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

	function delete_function(id) 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/delete_function')?>",
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

	function function_manage() 
	{ 
	
		if($('#function_type').val() == 'add'){
			var url = '<?= site_url('roles/post_function')?>';
		}else if($('#function_type').val() == 'edit'){
			var url = '<?= site_url('roles/put_function')?>';
		}

		$('#manageModal').modal('hide');
	
		$.ajax({
			type:'POST',
			url: url,
			dataType:'JSON',
			data:{
				fld_id : $('#function_id').val(),
				fld_name : $('#name').val(),
				fld_application_id : $('#application_id').val(),
				fld_class_id : $('#class_id').val(),
				fld_url : $('#url').val()
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


</script>
