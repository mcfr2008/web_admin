<?php

class Users_model extends CI_Model {

    function __construct() {
      
        parent::__construct();

        $this->load->model('Activity_log_model');
        
    }

	public function get_users_confirm_status_model()
	{

		$this->db = $this->load->database('default', TRUE);

		$data = array();

		$data = array(

			
			array(
				'id' => '0',
				'name' => 'wait'
			),
			array(
				'id' => '1',
				'name' => 'confirmed'
			),
			
		);

		return $data;
		
	}

	public function get_users_model()
	{

		$this->db = $this->load->database('default', TRUE);

		$_data = $_REQUEST;

		$PerPage = $_data['PerPage'];
		$pageNumber = $_data['pageNumber'] * $PerPage;

		$search_text = explode(" ",$_data['search_text']);
		$count_search_text = count($search_text);
		$search_confirm = $_data['search_confirm'];

		$this->db->select("
			users.* , 
			CASE
				WHEN users.fld_confirm_status = 1  THEN '<span class=\"text-primary\"><i class=\"fa fa-check-circle\"></i>  confirmed</span>'
				WHEN users.fld_confirm_status = 0  THEN '<span class=\"text-warning\"><i class=\"fa fa-clock\"></i> wait</span>'
				ELSE ''
			END AS html_confirm_status,
		");
		$this->db->from('users');
		if($search_text != ''){
			$this->db->group_start();
				for($i=0;$i<$count_search_text;$i++){
					$this->db->like('users.fld_id',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('users.fld_name',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('users.fld_email',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('users.fld_username',$search_text[$i]);
				}
			$this->db->group_end();
		}
		if($search_confirm != ''){
			$this->db->where('users.fld_confirm_status',$search_confirm);
		}
		$this->db->where('users.fld_trash',1);
		$this->db->limit($PerPage,$pageNumber);
		$this->db->order_by('users.fld_id','ASC'); 
		$data['users'] = $this->db->get()->result_array();


		$this->db->select('count(*) AS count');
		$this->db->from('users');
		if($search_text != ''){
			$this->db->group_start();
				for($i=0;$i<$count_search_text;$i++){
					$this->db->like('users.fld_id',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('users.fld_name',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('users.fld_email',$search_text[$i]);
				}
				for($i=0;$i<$count_search_text;$i++){
					$this->db->or_like('users.fld_username',$search_text[$i]);
				}
			$this->db->group_end();
		}
		if($search_confirm != ''){
			$this->db->where('users.fld_confirm_status',$search_confirm);
		}
		$this->db->where('users.fld_trash',1);
		$data['total'] = $this->db->get()->result_array()[0]['count'];

		return $data;
		
	}

	public function get_users_byid_model() 
    {

		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

        $this->db->select('
			users.*,
			user_access.fld_role_id AS role_id
		');
		$this->db->from('users');
		$this->db->join('user_access','user_access.fld_user_id = users.fld_id','left'); 
		$this->db->where('users.fld_id',$_data['fld_id']); 
		$data['data'] = $this->db->get()->result_array()[0];

		return $data;
    }

	public function post_users_model() 
    {

		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;
	
		$this->db->set('fld_email',$_data['fld_email']);
		$this->db->set('fld_name',$_data['fld_name']);
		$this->db->set('fld_username',$_data['fld_username']);
		$this->db->set('fld_password',$_data['fld_password']);
		$this->db->set('fld_employee_id',$_data['fld_employee_id']);
		$this->db->set('fld_confirm_status',0);
		$this->db->set('fld_creator_id',$_SESSION['people_id']);
		$this->db->set('fld_create_date',date('Y-m-d H:i:s'));
		$this->db->set('fld_trash',1);
		$this->db->insert('users');

		$id = $this->db->insert_id();

		$this->db->set('fld_user_id',$id);
		$this->db->set('fld_role_id',$_data['roles_id']);
		$this->db->insert('user_access');
      
		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'เพิ่ม' ,
				"fld_table_name" => 'users',
				"fld_table_id" => $id,
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------

		return 'success';
    }

	public function put_users_model() 
    {
       
		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;
	
		$this->db->set('fld_email',$_data['fld_email']);
		$this->db->set('fld_name',$_data['fld_name']);
		$this->db->set('fld_username',$_data['fld_username']);
		$this->db->set('fld_password',$_data['fld_password']);
		$this->db->set('fld_employee_id',$_data['fld_employee_id']);
		$this->db->where('fld_id',$_data['fld_id']);
		$this->db->update('users');

		$id = $_data['fld_id'];

		$this->db->where('fld_user_id',$id);
		$this->db->delete('user_access');

		$this->db->set('fld_user_id',$id);
		$this->db->set('fld_role_id',$_data['roles_id']);
		$this->db->insert('user_access');
      
		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'แก้ไข' ,
				"fld_table_name" => 'users',
				"fld_table_id" => $id,
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------

		return 'success';
    }

	public function put_users_confirm_model() 
	{
	
		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

		$this->db->set('fld_confirm_status',$_data['fld_confirm_status']);
		$this->db->where('fld_id',$_data['fld_id']);
		$this->db->update('users');

		$id = $_data['fld_id'];

		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'อนุมัติการเข้าใช้งาน' ,
				"fld_table_name" => 'users',
				"fld_table_id" => $id,
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------

		return 'success';

	}

	public function delete_users_model() 
    {
       
		$this->db = $this->load->database('default', TRUE);

		$_data  = $_REQUEST;

		$this->db->set('fld_trash',0);
		$this->db->where('fld_id',$_data['fld_id']);
		$this->db->update('users');

		$id = $_data['fld_id'];
		
		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'ลบ' ,
				"fld_table_name" => 'users',
				"fld_table_id" => $id,
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------

		
	
		return 'success';
	
    }
  
}

?>
