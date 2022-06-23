<?php

class Roles_application_model extends CI_Model {

    function __construct() {
      
        parent::__construct();

        $this->load->model('Activity_log_model');
        
    }

	public function get_application_model()
	{

		$this->db = $this->load->database('default', TRUE);

		$_data = $_REQUEST;

		$PerPage = $_data['PerPage'];
		$pageNumber = $_data['pageNumber'] * $PerPage;

		$search_text = explode(" ",$_data['search_text']);
		$count_search_text = count($search_text);


		$this->db->select('*');
		$this->db->from('role_application');
		if($search_text != ''){
			$this->db->group_start();
				for($i=0;$i<$count_search_text;$i++){
					$this->db->like('role_application.fld_id',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('role_application.fld_name',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('role_application.fld_url',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('role_application.fld_title',$search_text[$i]);
				}
			$this->db->group_end();
		}
		$this->db->limit($PerPage,$pageNumber);
		$this->db->order_by('role_application.fld_id','ASC'); 
		$data['application'] = $this->db->get()->result_array();


		$this->db->select('count(*) AS count');
		$this->db->from('role_application');
		if($search_text != ''){
			$this->db->group_start();
				for($i=0;$i<$count_search_text;$i++){
					$this->db->like('role_application.fld_id',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('role_application.fld_name',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('role_application.fld_url',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('role_application.fld_title',$search_text[$i]);
				}
			$this->db->group_end();
		}
		$this->db->order_by('role_application.fld_id','ASC'); 
		$data['total'] = $this->db->get()->result_array()[0]['count'];

		return $data;
		
	}

	public function get_application_all_model()
	{

		$this->db = $this->load->database('default', TRUE);

		$this->db->select('*');
		$this->db->from('role_application');
		$this->db->order_by('role_application.fld_id','ASC'); 
		$data['application'] = $this->db->get()->result_array();

		return $data;
		
	}

	public function get_application_byid_model() 
    {

		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

        $this->db->select('*');
		$this->db->from('role_application');
		$this->db->where('role_application.fld_id',$_data['fld_id']); 
		$data['data'] = $this->db->get()->result_array()[0];

		return $data;
    }

	public function get_application_byroles_model() 
    {

		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

		$data_all = $this->get_application_all_model();

		$data_check = '';
		$data['data'] = [];
		foreach ($data_all['application'] as $key => $value) {
		
			$this->db->select('role_function.fld_application_id');
			$this->db->from('role_access');
			$this->db->join('role_function','role_function.fld_id = role_access.fld_function_id'); 
			$this->db->where('role_access.fld_role_id',$_data['fld_role_id']); 
			$this->db->where('role_function.fld_application_id',$value['fld_id']); 
			$this->db->group_by("role_function.fld_application_id");
			$data_byroles = $this->db->get();

			$value_role_id = ["role_id" =>  $_data['fld_role_id'] ] ;

			if($data_byroles->num_rows() > 0){
				$value_check = ["check" =>  '<i class="fas fa-check-square"></i>' ] ;
			}else{
				$value_check = ["check" =>  '' ] ;
			}

			$data_check = $value + $value_check + $value_role_id;

			array_push($data['data'],$data_check);

		}


		return $data;
    }

	public function post_application_model() 
    {

		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;
	
		$this->db->set('fld_name',$_data['fld_name']);
		$this->db->set('fld_url',$_data['fld_url']);
		$this->db->set('fld_icon',$_data['fld_icon']);
		$this->db->set('fld_title',$_data['fld_title']);
		$this->db->set('fld_detail',$_data['fld_detail']);
		$this->db->insert('role_application');

		$id = $this->db->insert_id();
      
		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'เพิ่ม' ,
				"fld_table_name" => 'role_application',
				"fld_table_id" => $id,
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------

		return 'success';
    }

	public function put_application_model() 
    {
       
		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;
	
		$this->db->set('fld_name',$_data['fld_name']);
		$this->db->set('fld_url',$_data['fld_url']);
		$this->db->set('fld_icon',$_data['fld_icon']);
		$this->db->set('fld_title',$_data['fld_title']);
		$this->db->set('fld_detail',$_data['fld_detail']);
		$this->db->where('fld_id',$_data['fld_id']);
		$this->db->update('role_application');

		$id = $_data['fld_id'];
      
		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'แก้ไข' ,
				"fld_table_name" => 'role_application',
				"fld_table_id" => $id,
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------

		return 'success';
    }

	public function delete_application_check_use($val) 
    {
       
		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

        $this->db->select('*');
		$this->db->from('role_class');
		$this->db->where('role_class.fld_application_id',$val); 
		$data_check = $this->db->get();

		if($data_check->num_rows() > 0){
			$data = 'usedata';
		}else{
			$data = 'success';
		}
	

		return $data;
    }

	public function delete_application_model() 
    {
       
		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

		$check_use = $this->delete_application_check_use($_data['fld_id']);

		if($check_use == 'success'){

			$this->db->where('fld_id',$_data['fld_id']);
			$this->db->delete('role_application');
	
			$id = $_data['fld_id'];
		  
			//-------------------------------------Activity_log-------------------------------------------------
				$data_activity_log = array();
				$data_activity_log = array(
					"fld_activity" => 'ลบ' ,
					"fld_table_name" => 'role_application',
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
