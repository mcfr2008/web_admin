<script>

    $(document).ready(function () {
	
		action_function();

		get_access_all('all');

	
      
    });
	
	function action_function() 
	{ 

		$('#data_roles').delegate('tr', 'click', function(e) {
			

			$(this).toggleClass('bg-primary select');
		
			$('#data_roles tr').not(this).removeClass('bg-primary select');

			var id = $(this).closest('tr').find('.id').text();
			

			get_application_byroles(id);
			
		});

		$('#data_application').delegate('tr', 'click', function(e) {
	
			$(this).toggleClass('bg-primary select');

			$('#data_application tr').not(this).removeClass('bg-primary select');

			var id = $(this).closest('tr').find('.id').text();
			var role_id = $(this).closest('tr').find('.role_id').text();

			get_class_byapplicationroles(id,role_id);
			
		});

		
		$('#data_class').delegate('tr', 'click', function(e) {
	
			$(this).toggleClass('bg-primary select');

			$('#data_class tr').not(this).removeClass('bg-primary select');

			var id = $(this).closest('tr').find('.id').text();
			var role_id = $(this).closest('tr').find('.role_id').text();
			var application_id = $(this).closest('tr').find('.application_id').text();

			get_function_byclassapplicationroles(id,role_id,application_id);
			
		});

		$('#data_function').delegate('tr', 'click', function(e) {
			if($(this).hasClass('select')){
			$(this).removeClass('bg-primary select');
			$(this).find('.check').html('');
			//   $('#dataSelect tbody tr#'+$(this).attr('id')).remove();
			//   if($('#Table_employee tbody tr.select').length == 0){
			//     $('#btn_report_monthly_employee').hide();
			
			//   }
			}else{
			$(this).addClass('bg-primary select');
			$(this).find('.check').html('<i class="fas fa-check-square"></i>');
			//   $(this).clone().appendTo('#dataSelect tbody');
			//   $('#dataSelect tbody tr#'+$(this).attr('id')+' td.remove').remove();
			//   $('#dataSelect tbody tr#'+$(this).attr('id')).removeClass('select');
			//   $('#btn_report_monthly_employee').show();
			}

		});

		$(document).delegate('#btn_function_select_all', 'click', function(e) 
		{
			if($("#data_function tr:not(.select)").length == 0){
				$("#data_function  tr.select").removeClass('bg-primary select');
				$("#data_function  tr").find('.check').html('');
			
				// if($('#Table_depart tbody tr.select').length == 0){
				// $('.row_report_daily_detail_company_formulti').hide();
				// $('.row_report_daily_company_formulti').hide();
				// }
			}else{
				$("#data_function tr:not(.select)").addClass('bg-primary select');
				$('#data_function tr').find('.check').html('<i class="fas fa-check-square"></i>');
				// $('.row_report_daily_detail_company_formulti').show();
				// $('.row_report_daily_company_formulti').show();
			}
		});

		$('#function_submit').click(function (e) { 
			e.preventDefault();
			var data_function = [];
			$('#data_function').find('.select').each(function(){

				var data_functions = {};

				data_functions['fld_role_id'] = $(this).find('.role_id').text();
				data_functions['fld_application_id'] = $(this).find('.application_id').text();
				data_functions['fld_class_id'] = $(this).find('.class_id').text();
				data_functions['fld_function_id'] = $(this).find('.id').text();
				data_function.push(data_functions);

			});

			var function_id = [];
			var role_id = '';
			var application_id = '';
			var class_id = '';
			$('#data_function').find('tr').each(function(){

				var function_ids = {};

				function_ids = $(this).find('.id').text();
				function_id.push(function_ids);

				role_id = $(this).find('.role_id').text();
				application_id = $(this).find('.application_id').text();
				class_id = $(this).find('.class_id').text();

			});

			put_access(
				data_function,
				function_id,
				role_id,
				application_id,
				class_id
			);
			
		});

		$("#search_roles").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#data_roles tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#search_application").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#data_application tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#search_class").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#data_class tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#search_function").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#data_function tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#search_manage_roles").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#data_manage_roles tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		// // list
			
		// 	$('#search_text').keyup(function (e) { 
		// 		e.preventDefault();
		// 		search_function_1();
		// 	});

		// 	$(document).on('click','.pageNumber',function(){
		// 		var search_text = '';
		// 		search_text = $('#search_text').val();
		// 		$('#pageNumber').val($(this).text()-1);
		// 		get_application(search_text);
		// 	});

		// // END list

		// $('#btn_add').click(function () {
		// 	clear_data_manage();
		// 	$('#manageModal').modal('show');
		// 	$('#application_title').text('Add');
		// 	$('#application_type').val('add');
		// });

		$('#data_roles').on('click','.btn_copy',function(){ 
			
		
			get_access_all('copy');
		
			var id = $(this).closest('tr').find('.id').text();
			var name = $(this).closest('tr').find('.name').text();

			$('#copy_roles_id').val(id);
			$('#copy_roles_name').text(name);
			
			$('#copyModal').modal('show');
		});

		$('#copy_submit').click(function () { 

			var validate = validate_copy();

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
						post_roles_copy();
					}
				})

			}

		});

		// Manage roles

			$('#btn_roles_manage').click(function (e) { 
				e.preventDefault();
				$('#rolesModal').modal('show');
				get_access_all('manage');
			});

			$('#btn_roles_reset').click(function (e) { 
				e.preventDefault();
				clear_data_manage_roles();
			});

			$('#data_manage_roles').on('click','.btn_edit',function(){ 
				
				var id = $(this).closest('tr').find('.id').text();
				var name = $(this).closest('tr').find('.name').text();

				$('#roles_id').val(id);
				$('#roles_name').val(name);
				
			});

			$('#data_manage_roles').on('click','.btn_del',function(){ 
				
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

						delete_roles(id);

					}
				})
				
			});

			
			$('#roles_submit').click(function (e) { 
				e.preventDefault();
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

						post_roles_manage();

					}
				})
				
			});

		// END Manage roles

		
		

	};

	function clear_data_copy()
	{ 
		$('#copy_roles_id').val('');
		$('#copy_roles_name').text('');

		$('#copy_to_roles_id').val('').trigger('change').removeClass( "is-warning is-valid" );
	};

	function clear_data_manage_roles()
	{ 
		$('#roles_id').val('');
		$('#roles_name').val('');
	};

	function validate_copy() 
	{
		var validate = 'true';

		if($("#copy_to_roles_id").val() == '' ){
			$( "#copy_to_roles_id" ).removeClass( "is-valid" ).addClass( "is-warning" );
			validate = 'false';
		}else if($('#copy_to_roles_id').val() != '' ){
			$( "#copy_to_roles_id" ).removeClass( "is-warning" ).addClass( "is-valid" );
		}
	
        return validate;
		
	};

	function delete_roles(id) 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/delete_roles')?>",
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
						

						clear_data_manage_roles();

						get_access_all('manage');
						
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

	function post_roles_manage() 
	{ 
	
		$.ajax({
			type:'POST',
			url: '<?= site_url('roles/post_roles_manage')?>',
			dataType:'JSON',
			data:{
				fld_id : $('#roles_id').val(),
				fld_name : $('#roles_name').val(),
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

			    	clear_data_manage_roles();

					get_access_all('manage');

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

	function get_access_all(type) 
	{ 

		$.ajax({
		type: "POST",
		url: "<?= site_url('roles/get_access_all')?>",
		dataType: "JSON",
		success: function (data) {

			if(type == 'all'){
				$('#data_roles').empty();
				$.each(data['roles'], function (id, value) { 
								
					$('#data_roles').append(
					'<tr>'+
						'<td class="text-center hidden id">' + value['fld_id'] + '</td>'+
						'<td class="text-left name">' + value['fld_name'] + '</td>'+
						'<td class="text-left">' +
							'<span class="float-right ">' +
								'<button type="button" class="btn btn-primary btn-sm btn_copy"><i class="fas fa-copy"></i></button>' + 
							'</span>'+
						'</td>'+
					'</tr>'
					);

				});

			}else if(type == 'copy'){

				$( "#copy_to_roles_id" ).select2({
					theme: "bootstrap4"
				}); 

				$('#copy_to_roles_id').empty();
				$('#copy_to_roles_id').append('<option value="">select</option>');
				$.each(data['roles'],function(id,value){
					$('#copy_to_roles_id').append(
						'<option value="'+value['fld_id']+'">'+value['fld_name']+'</option>'
					);
				});

			}else if(type == 'manage'){

				$('#data_manage_roles').empty();
				$.each(data['roles'],function(id,value){
					$('#data_manage_roles').append(
					'<tr>'+
						'<td class="text-center hidden id">' + value['fld_id'] + '</td>'+
						'<td class="text-left name">' + value['fld_name'] + '</td>'+
						'<td class="text-left">' +
							'<span class="float-right ">' +
								'<button type="button" class="btn btn-info btn-sm btn_edit"><i class="fas fa-edit"></i></button> ' + 
								'<button type="button" class="btn btn-danger btn-sm btn_del"><i class="fas fa-trash"></i></button> ' + 
							'</span>'+
							
						'</td>'+
					'</tr>'
					);
				});

			}
		
			


		}
		});

	};

	function get_application_byroles(id) 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/get_application_byroles')?>",
			dataType:'JSON',
			data: {
				fld_role_id : id
			}
		}).done(function(data){

			// console.log(data);

			$('#data_application').empty();
			$.each(data['data'], function (id, value) { 
							
				$('#data_application').append(
				
				'<tr>'+
					'<td class="text-center hidden role_id">' + value['role_id'] + '</td>'+
					'<td class="text-center hidden id">' + value['fld_id'] + '</td>'+
					'<td class="text-left">' + value['fld_name'] + 
					'<span class="float-right ">'+ value['check'] +'</span>' +
					'</td>'+
				'</tr>'
				);

			});
		
		}).fail(function(data){
		
			console.log(data);

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

	function get_class_byapplicationroles(id,role_id) 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/get_class_byapplicationroles')?>",
			dataType:'JSON',
			data: {
				fld_role_id : role_id,
				fld_application_id : id,
			}
		}).done(function(data){

			// console.log(data);

			$('#data_class').empty();
			$.each(data['data'], function (id, value) { 
							
				$('#data_class').append(
				
				'<tr>'+
					'<td class="text-center hidden role_id">' + value['role_id'] + '</td>'+
					'<td class="text-center hidden application_id">' + value['application_id'] + '</td>'+
					'<td class="text-center hidden id">' + value['fld_id'] + '</td>'+
					'<td class="text-left">' + value['fld_name'] + 
					'<span class="float-right ">'+ value['check'] +'</span>' +
					'</td>'+
				'</tr>'
				);

			});
		
		}).fail(function(data){
		
			console.log(data);

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
	
	function get_function_byclassapplicationroles(id,role_id,application_id) 
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/get_function_byclassapplicationroles')?>",
			dataType:'JSON',
			data: {
				fld_role_id : role_id,
				fld_application_id : application_id,
				fld_class_id : id,
			}
		}).done(function(data){

			// console.log(data);

			$('#data_function').empty();
			$.each(data['data'], function (id, value) { 
							
				$('#data_function').append(
				
				'<tr>'+
					'<td class="text-center hidden role_id">' + value['role_id'] + '</td>'+
					'<td class="text-center hidden application_id">' + value['application_id'] + '</td>'+
					'<td class="text-center hidden class_id">' + value['class_id'] + '</td>'+
					'<td class="text-center hidden id">' + value['fld_id'] + '</td>'+
					'<td class="text-left">' + value['fld_name'] + 
					'<span class="float-right check">'+ value['check'] +'</span>' +
					'</td>'+
				'</tr>'
				);

			});
		
		}).fail(function(data){
		
			console.log(data);

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

	function put_access(
		data_function,
		function_id,
		role_id,
		application_id,
		class_id
		)
	{ 

		// console.log(data_function,
		// function_id,
		// role_id,
		// application_id,
		// class_id)
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/put_access')?>",
			dataType:'JSON',
			data: {
				data_function : data_function,
				function_id : function_id,
				fld_role_id : role_id
			}
		}).done(function(data){

			// console.log(data);

			Swal.fire({
				title: 'สำเร็จ',
				text: "บันทึกข้อมูล",
				backdrop: `rgba(49,53,56, 0.8)`,
				icon: 'success',
				allowOutsideClick: false,
				confirmButtonColor: '#3085d6',
			}).then((result) => {
				if (result.isConfirmed) {
					
					get_class_byapplicationroles(application_id,role_id);
					
					get_function_byclassapplicationroles(class_id,role_id,application_id);

				}
			})
		
		}).fail(function(data){
		
			console.log(data);

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

	function post_roles_copy()
	{ 
	
		$.ajax({
			type:'POST',
			url: "<?= site_url('roles/post_roles_copy')?>",
			dataType:'JSON',
			data: {
				copy_roles_id : $('#copy_roles_id').val() ,
				copy_to_roles_id :  $('#copy_to_roles_id').val() ,
			}
		}).done(function(data){

			// console.log(data);

			$('#copyModal').modal('hide');

			Swal.fire({
				title: 'สำเร็จ',
				text: "บันทึกข้อมูล",
				backdrop: `rgba(49,53,56, 0.8)`,
				icon: 'success',
				allowOutsideClick: false,
				confirmButtonColor: '#3085d6',
			}).then((result) => {
				if (result.isConfirmed) {
					
					

				}
			})
		
		}).fail(function(data){
		
			console.log(data);

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
