<?php

class Roles_access_model extends CI_Model {

    function __construct() {
      
        parent::__construct();

        $this->load->model('Activity_log_model');
        
    }

	public function get_access_all_model()
	{

		$this->db = $this->load->database('default', TRUE);

		$this->db->select('*');
		$this->db->from('roles');
		$this->db->where('fld_trash', 1);
		$this->db->order_by('roles.fld_id','ASC'); 
		$data['roles'] = $this->db->get()->result_array();

		return $data;
		
	}

	public function put_access_model() 
	{

		$this->db = $this->load->database('default', TRUE);

		$_data = $_REQUEST;

		$this->db->where_in('fld_function_id', $_data['function_id']);
		$this->db->where('fld_role_id', $_data['fld_role_id']);
		$this->db->delete('role_access');

		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'จัดการสิทธิ์ ลบ' ,
				"fld_table_name" => 'role_access',
				"fld_table_id" => $_data['fld_role_id'],
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------

		if(isset($_data['data_function'])){

            foreach($_data['data_function'] as $value){
			
				$this->db->set('fld_function_id',$value['fld_function_id']);
				$this->db->set('fld_role_id',$value['fld_role_id']);
				$this->db->insert('role_access');

				//-------------------------------------Activity_log-------------------------------------------------
					$data_activity_log = array();
					$data_activity_log = array(
						"fld_activity" => 'จัดการสิทธิ์ เพิ่ม function_id ' . $value['fld_function_id'],
						"fld_table_name" => 'role_access',
						"fld_table_id" => $_data['fld_role_id'],
						"fld_creator_id" => $_SESSION['people_id'],
						"fld_creator_date" => date('Y-m-d H:i:s')
					);
					$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
				//-------------------------------------END-Activity_log--------------------------------------------
            }
        }
		
		return 'success';
	}

	public function post_roles_copy_model() 
	{

		$this->db = $this->load->database('default', TRUE);

		$_data = $_REQUEST;

		$this->db->select('*');
		$this->db->from('role_access');
		$this->db->where('role_access.fld_role_id',$_data['copy_roles_id']); 
		$this->db->order_by('role_access.fld_id','ASC'); 
		$data_role_access = $this->db->get()->result_array();

		foreach($data_role_access as $value){
			
			$this->db->set('fld_function_id',$value['fld_function_id']);
			$this->db->set('fld_role_id',$_data['copy_to_roles_id']);
			$this->db->insert('role_access');
			
		}

		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'คัดลอกสิทธิ์ จาก roles_id ' . $_data['copy_roles_id'] . ' ไปยัง roles_id ' . $_data['copy_to_roles_id'],
				"fld_table_name" => 'role_access',
				"fld_table_id" => $_data['copy_roles_id'] . ' ' . $_data['copy_to_roles_id'] ,
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------

		return 'success';
	}

	public function post_roles_manage_model() 
	{
		$this->db = $this->load->database('default', TRUE);

		$_data = $_REQUEST;

		if($_data['fld_id'] == ''){

			$this->db->set('fld_trash',1);
			$this->db->set('fld_name',$_data['fld_name']);
			$this->db->insert('roles');

			$id = $this->db->insert_id();

			//-------------------------------------Activity_log-------------------------------------------------
				$data_activity_log = array();
				$data_activity_log = array(
					"fld_activity" => 'เพิ่ม',
					"fld_table_name" => 'roles',
					"fld_table_id" => $id ,
					"fld_creator_id" => $_SESSION['people_id'],
					"fld_creator_date" => date('Y-m-d H:i:s')
				);
				$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
			//-------------------------------------END-Activity_log--------------------------------------------
	
			return 'success';

		}else{

			$this->db->set('fld_name',$_data['fld_name']);
			$this->db->where('fld_id',$_data['fld_id']);
			$this->db->update('roles');

			//-------------------------------------Activity_log-------------------------------------------------
				$data_activity_log = array();
				$data_activity_log = array(
					"fld_activity" => 'แก้ไข',
					"fld_table_name" => 'roles',
					"fld_table_id" => $_data['fld_id'] ,
					"fld_creator_id" => $_SESSION['people_id'],
					"fld_creator_date" => date('Y-m-d H:i:s')
				);
				$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
			//-------------------------------------END-Activity_log--------------------------------------------
	
			return 'success';

		}

	}

	public function delete_roles_model() 
	{
		$this->db = $this->load->database('default', TRUE);

		$_data = $_REQUEST;

		$this->db->set('fld_trash',0);
		$this->db->where('fld_id',$_data['fld_id']);
		$this->db->update('roles');

		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'ลบ',
				"fld_table_name" => 'roles',
				"fld_table_id" => $_data['fld_id'] ,
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------

		return 'success';

	}


  
}

?>
