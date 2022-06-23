<?php $check_user_access = $this->Main_model->check_user_access();?>
<script>

    $(document).ready(function () {
	
		action_function();

		search_function_1();
      
    });

	function search_function_1() 
	{
		var search_text = '';
		search_text = $('#search_text').val();
		get_application(search_text);
	};

	function search_function_2() 
	{
		var search_text = '';
		search_text = $('#search_text').val();
		$('#pageNumber').val(0);
		get_application(search_text);
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
				get_application(search_text);
			});

		// END list

		$('#btn_add').click(function () {
			clear_data_manage();
			$('#manageModal').modal('show');
			$('#application_title').text('Add');
			$('#application_type').val('add');
		});

		$('#data_application').on('click','.btn_edit',function(){ 
			
			clear_data_manage();
			$('#manageModal').modal('show');
			$('#application_title').text('Edit');
			$('#application_type').val('edit');

			var id = $(this).closest('tr').find('.id').text();
			
			get_application_byid(id);
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
						application_manage();
					}
				})

			}

		});

		$('#data_application').on('click','.btn_del',function(){ 

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

					delete_application(id);

				}
			})
			
		});

	};

	function clear_data_manage()
	{ 
		$('#application_type').val('');
		$('#application_id').val('');

		$('#icon').val('').removeClass( "is-warning is-valid" );
		$('#name').val('').removeClass( "is-warning is-valid" );
		$('#detail').val('').removeClass( "is-warning is-valid" );
		$('#title').val('').removeClass( "is-warning is-valid" );
		$('#url').val('').removeClass( "is-warning is-valid" );

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

		if($('#title').val() == '' ){
			$( "#title" ).removeClass( "is-valid" ).addClass( "is-warning" );
			validate = 'false';
		}else if($('#title').val() != '' ){
			$( "#title" ).removeClass( "is-warning" ).addClass( "is-valid" );
		}

		if($('#icon').val() == '' ){
			$( "#icon" ).removeClass( "is-valid" ).addClass( "is-warning" );
			validate = 'false';
		}else if($('#icon').val() != '' ){
			$( "#icon" ).removeClass( "is-warning" ).addClass( "is-valid" );
		}

		if($('#url').val() == '' ){
			$( "#url" ).removeClass( "is-valid" ).addClass( "is-warning" );
			validate = 'false';
		}else if($('#url').val() != '' ){
			$( "#url" ).removeClass( "is-warning" ).addClass( "is-valid" );
		}

        return validate;
		
	};

	function get_application(search_text) 
	{ 

		var PerPage = parseInt($('#PerPage').val());
		var pageNumber = $('#pageNumber').val();

		$.ajax({
		type: "POST",
		url: "<?= site_url('roles/get_application')?>",
		data : {
			pageNumber : pageNumber ,
			PerPage : PerPage,
			search_text : search_text
		},
		dataType: "JSON",
		success: function (data) {
		
			$('#data_application').empty();
			$.each(data['application'], function (id, value) { 

				var btn_edit = '';
				var btn_del = '';
			
			
				<?php if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/edit"])) :?>
				btn_edit = '<button class="btn btn-info btn-sm btn_edit"> <i class="fas fa-edit"></i> Edit</button> ';
				<?php endif; ?>

				<?php if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/del"])) :?>
				btn_del = '<button class="btn btn-danger btn-sm btn_del" ><i class="fa fa-trash"></i> Delete</button> ';
				<?php endif; ?>
							
				$('#data_application').append(
				'<tr>'+
					'<td class="text-center id">' + value['fld_id'] + '</td>'+
					'<td class="text-left">' + value['fld_name'] + '</td>'+
					'<td class="text-left">' + value['fld_title'] + '</td>'+
					'<td class="text-center"> <i class="fa fa-' + value['fld_icon'] + '"></i></td>'+
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

	function get_application_byid(id) 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/get_application_byid')?>",
			dataType:'JSON',
			data:{
				fld_id : id
			},
		}).done(function(data){

			$('#application_id').val(id);
			$('#icon').val(data['data']['fld_icon']);
			$('#name').val(data['data']['fld_name']);
			$('#detail').val(data['data']['fld_detail']);
			$('#title').val(data['data']['fld_title']);
			$('#url').val(data['data']['fld_url']);
		
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

	function delete_application(id) 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/delete_application')?>",
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

	function application_manage() 
	{ 
	
		if($('#application_type').val() == 'add'){
			var url = '<?= site_url('roles/post_application')?>';
		}else if($('#application_type').val() == 'edit'){
			var url = '<?= site_url('roles/put_application')?>';
		}

		$('#manageModal').modal('hide');
	
		$.ajax({
			type:'POST',
			url: url,
			dataType:'JSON',
			data:{
				fld_id : $('#application_id').val(),
				fld_icon : $('#icon').val(),
				fld_name : $('#name').val(),
				fld_detail : $('#detail').val(),
				fld_title : $('#title').val(),
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
