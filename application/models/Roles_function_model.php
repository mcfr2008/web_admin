<?php

class Roles_function_model extends CI_Model {

    function __construct() {
      
        parent::__construct();

        $this->load->model('Activity_log_model');
        
    }

	public function get_function_model()
	{

		$this->db = $this->load->database('default', TRUE);

		$_data = $_REQUEST;

		$PerPage = $_data['PerPage'];
		$pageNumber = $_data['pageNumber'] * $PerPage;

		$search_text = explode(" ",$_data['search_text']);
		$count_search_text = count($search_text);


		$this->db->select('
			role_function.*,
			role_class.fld_name AS class_name ,
			role_application.fld_name AS application_name
		');
		$this->db->from('role_function');
		$this->db->join('role_class','role_class.fld_id = role_function.fld_class_id','');
		$this->db->join('role_application','role_application.fld_id = role_function.fld_application_id','');
		if($search_text != ''){
			$this->db->group_start();
				for($i=0;$i<$count_search_text;$i++){
					$this->db->like('role_function.fld_id',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('role_function.fld_name',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('role_function.fld_url',$search_text[$i]);
				}
			$this->db->group_end();
		}
		$this->db->limit($PerPage,$pageNumber);
		$this->db->order_by('role_function.fld_id','ASC'); 
		$data['function'] = $this->db->get()->result_array();


		$this->db->select('count(*) AS count');
		$this->db->from('role_function');
		$this->db->join('role_class','role_class.fld_id = role_function.fld_class_id','');
		$this->db->join('role_application','role_application.fld_id = role_function.fld_application_id','');
		if($search_text != ''){
			$this->db->group_start();
				for($i=0;$i<$count_search_text;$i++){
					$this->db->like('role_function.fld_id',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('role_function.fld_name',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('role_function.fld_url',$search_text[$i]);
				}
			$this->db->group_end();
		}
		$this->db->order_by('role_function.fld_id','ASC'); 
		$data['total'] = $this->db->get()->result_array()[0]['count'];

		return $data;
		
	}

	public function get_function_byid_model() 
    {

		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

        $this->db->select('*');
		$this->db->from('role_function');
		$this->db->where('role_function.fld_id',$_data['fld_id']); 
		$data['data'] = $this->db->get()->result_array()[0];

		return $data;
    }

	function get_function_byclass_model() 
    {

		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

        $this->db->select('*');
		$this->db->from('role_function');
		$this->db->where('role_function.fld_class_id',$_data['fld_class_id']); 
		$data['function'] = $this->db->get()->result_array();

		return $data;
    }

	public function get_function_byclassapplicationroles_model() 
	{
		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

		$data_all = $this->get_function_byclass_model();

		$data_check = '';
		$data['data'] = [];
		foreach ($data_all['function'] as $key => $value) {
		

			$this->db->select('
			role_function.fld_id,
			role_function.fld_class_id
			');
			$this->db->from('role_access');
			$this->db->join('role_function','role_function.fld_id = role_access.fld_function_id'); 
			$this->db->where('role_access.fld_role_id',$_data['fld_role_id']); 
			$this->db->where('role_function.fld_class_id',$_data['fld_class_id']); 
			$this->db->where('role_function.fld_id',$value['fld_id']); 
			$this->db->group_by("
			role_function.fld_id,
			role_function.fld_class_id");
			$data_byroles = $this->db->get();

			$value_class_id = ["class_id" =>  $_data['fld_class_id'] ] ;
			
			$value_application_id = ["application_id" =>  $_data['fld_application_id'] ] ;

			$value_role_id = ["role_id" =>  $_data['fld_role_id'] ] ;

			if($data_byroles->num_rows() > 0){
				$value_check = ["check" =>  '<i class="fas fa-check-square"></i>' ] ;
			}else{
				$value_check = ["check" =>  '' ] ;
			}

			$data_check = $value + $value_check + $value_role_id + $value_application_id + $value_class_id;

			array_push($data['data'],$data_check);

		}


		return $data;
		
	}

	public function post_function_model() 
    {

		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;
	
		$this->db->set('fld_name',$_data['fld_name']);
		$this->db->set('fld_url',$_data['fld_url']);
		$this->db->set('fld_application_id',$_data['fld_application_id']);
		$this->db->set('fld_class_id',$_data['fld_class_id']);
		$this->db->insert('role_function');

		$id = $this->db->insert_id();
      
		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'เพิ่ม' ,
				"fld_table_name" => 'role_function',
				"fld_table_id" => $id,
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------

		return 'success';
    }

	public function put_function_model() 
    {
       
		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;
	
		$this->db->set('fld_name',$_data['fld_name']);
		$this->db->set('fld_url',$_data['fld_url']);
		$this->db->set('fld_application_id',$_data['fld_application_id']);
		$this->db->set('fld_class_id',$_data['fld_class_id']);
		$this->db->where('fld_id',$_data['fld_id']);
		$this->db->update('role_function');

		$id = $_data['fld_id'];
      
		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'แก้ไข' ,
				"fld_table_name" => 'role_function',
				"fld_table_id" => $id,
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------

		return 'success';
    }

	public function delete_function_check_use($val) 
    {
       
		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

        $this->db->select('*');
		$this->db->from('role_access');
		$this->db->where('role_access.fld_function_id',$val); 
		$data_check = $this->db->get();

		if($data_check->num_rows() > 0){
			$data = 'usedata';
		}else{
			$data = 'success';
		}
	

		return $data;
    }

	public function delete_function_model() 
    {
       
		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

		$check_use = $this->delete_function_check_use($_data['fld_id']);

		if($check_use == 'success'){

			$this->db->where('fld_id',$_data['fld_id']);
			$this->db->delete('role_function');
	
			$id = $_data['fld_id'];
		  
			//-------------------------------------Activity_log-------------------------------------------------
				$data_activity_log = array();
				$data_activity_log = array(
					"fld_activity" => 'ลบ' ,
					"fld_table_name" => 'role_function',
					"fld_table_id" => $id,
					"fld_creator_id" => $_SESSION['people_id'],
					"fld_creator_date" => date('Y-m-d H:i:s')
				);
				$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
			//-------------------------------------END-Activity_log--------------------------------------------

		}
	
		return $check_use;
	
    }
  
}

?>
