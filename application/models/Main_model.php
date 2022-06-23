<?php

class Main_model extends CI_Model {

    function __construct() {
      
        parent::__construct();

        $this->load->model('Activity_log_model');
        
    }

	function application_id()
	{
		return 13;
	}

	public function application_name()
	{
		return 'Admin-Manage';
	}
	
	// public function check_session()
    // {
	// 	$this->db = $this->load->database('people', TRUE);

	// 	$this->load->view('template/css/con-css-1');
       
	// 	if ($this->session->userdata('people_login') and $this->session->userdata('people_login') == 1) {

	// 	} else {
			
	// 		$this->load->view('template/login');
	// 		$this->load->view('template/js/con-js-1');
	// 		$this->load->view('template/js/login-js');
			
	// 	}

	
    // }

    public function login_model($data = array('')) 
    {

        $this->db = $this->load->database($data['database'], TRUE);

        $this->db->select('
			users.fld_id,
			users.fld_name,
			users.fld_username,
			users.fld_password,
			users.fld_lastlogin,
			users.fld_employee_id,
			users.fld_creator_id,
			users.fld_create_date,
			user_access.fld_role_id

        ');
        $this->db->from('users');
        $this->db->join('user_access','user_access.fld_user_id = users.fld_id','left');	
        $this->db->where('users.fld_username',$data['username']);
        $this->db->where('users.fld_password',$data['password']);
        $data_user = $this->db->get()->result_array()[0];

        if(count($data_user) > 0){
            $this->session->set_userdata('people_login', 1);
            $this->session->set_userdata('people_id', $data_user['fld_id']);
            $this->session->set_userdata('people_username', $data_user['fld_username']);
            $this->session->set_userdata('people_password', $data_user['fld_password']);
            $this->session->set_userdata('people_name', $data_user['fld_name']);
            // $this->session->set_userdata('people_part_id', $data_user['fld_part_id']);
            // $this->session->set_userdata('people_depart_id', $data_user['fld_depar_tid']);
            $this->session->set_userdata('people_role', $data_user['fld_role_id']);
            $this->session->set_userdata('people_employee', $data_user['fld_employee_id']);
            $this->session->set_userdata('people_database',$data['database']);
             
            $result['people_login'] = 1;

            //-------------------------------------Activity_log-------------------------------------------------
                $data_activity_log = array();
                $data_activity_log = array(
                    "fld_activity" => 'เข้าสู่ระบบสำเร็จ รหัสผู้เข้าใช้งาน ' . $data['username'] ,
                    "fld_table_name" => '',
                    "fld_table_id" => '',
                    "fld_creator_id" => $_SESSION['people_id'],
                    "fld_creator_date" => date('Y-m-d H:i:s')
                );
                $this->Activity_log_model->add_activity_log_1_model($data_activity_log);
            //-------------------------------------END-Activity_log--------------------------------------------
        }else{
             //-------------------------------------Activity_log-------------------------------------------------
                $data_activity_log = array();
                $data_activity_log = array(
                    "fld_activity" => 'เข้าสู่ระบบไม่สำเร็จ รหัสผู้เข้าใช้งาน ' . $data['username'] ,
                    "fld_table_name" => '',
                    "fld_table_id" => '',
                    "fld_creator_id" => '',
                    "fld_creator_date" => date('Y-m-d H:i:s')
                );
                $this->Activity_log_model->add_activity_log_1_model($data_activity_log);
            //-------------------------------------END-Activity_log--------------------------------------------
        }

        return $result;
    }

    public function appMenu()
    {
		$this->db = $this->load->database('people', TRUE);

		$application_id = $this->application_id();

        if ($this->session->userdata('people_role') == 0) {

            $this->db->select('
				role_application.*  
			');
			$this->db->from('role_application');
			$this->db->join('role_function','role_function.fld_application_id = role_application.fld_id');
			// $this->db->join('user_access','user_access.fld_function_id = role_function.fld_id ');	
			$this->db->where('role_function.fld_id', $this->session->userdata('people_id'));
			$this->db->where('role_application.fld_id',$application_id);
            $this->db->group_by('role_application.fld_id');
			$data = $this->db->get()->result_array();
				
			
        } else {

            $this->db->select('
				role_application.*  
            ');
            $this->db->from('role_application');
			$this->db->join('role_function','role_function.fld_application_id = role_application.fld_id');
            $this->db->join('role_access','role_function.fld_id = role_access.fld_function_id');	
            $this->db->where('role_access.fld_role_id',$this->session->userdata('people_role'));
			$this->db->where('role_application.fld_id',$application_id);
			$this->db->group_by('role_application.fld_id');
            $data = $this->db->get()->result_array();
        }
       
        return  $data ;
    }

	public function menu() 
	{

		$this->db = $this->load->database('people', TRUE);

		$application_id = $this->application_id();

		$result = [];

		$this->db->select('
			role_class.fld_id AS class_fld_id ,
			role_class.fld_name AS class_fld_name ,
			role_class.fld_url AS class_fld_url ,
			role_class.fld_icon AS class_fld_icon ,
			role_class.fld_title AS class_fld_title ,
			role_class.fld_application_id AS class_fld_application_id ,
			role_class.fld_group_id AS class_fld_group_id ,
			role_class.fld_group_icon AS class_fld_group_icon 
		');
		$this->db->from('user_access');
		$this->db->join('role_access','role_access.fld_role_id = user_access.fld_role_id');
		$this->db->join('role_function','role_function.fld_id = role_access.fld_function_id');
		$this->db->join('role_class','role_class.fld_id = role_function.fld_class_id');	
		$this->db->join('role_application','role_application.fld_id = role_function.fld_application_id ');	
		$this->db->where('user_access.fld_user_id', $_SESSION['people_id']);
		$this->db->where('role_application.fld_id',$application_id);
		$this->db->order_by('role_class.fld_order','ASC'); 
		$this->db->order_by('role_class.fld_name','ASC'); 
		$data_class = $this->db->get()->result_array();

		// $result['data'] = $data_class;
		

		foreach ($data_class as $value_group) {
			
			$result[$value_group['class_fld_group_id']]['name'] = $value_group['class_fld_group_id'] ;
			$result[$value_group['class_fld_group_id']]['icon'] = $value_group['class_fld_group_icon'] ;
			$result[$value_group['class_fld_group_id']]['group'] = $value_group['class_fld_group_id'] ;
		
			foreach ($data_class as $value_group_sub) {

				$result[$value_group_sub['class_fld_group_id']]['menusub'][$value_group_sub['class_fld_title']]['id'] = $value_group_sub['class_fld_id'];
				$result[$value_group_sub['class_fld_group_id']]['menusub'][$value_group_sub['class_fld_title']]['name'] = $value_group_sub['class_fld_name'];
				$result[$value_group_sub['class_fld_group_id']]['menusub'][$value_group_sub['class_fld_title']]['title'] = $value_group_sub['class_fld_title'];
				$result[$value_group_sub['class_fld_group_id']]['menusub'][$value_group_sub['class_fld_title']]['url'] = $value_group_sub['class_fld_url'];
				$result[$value_group_sub['class_fld_group_id']]['menusub'][$value_group_sub['class_fld_title']]['icon'] = $value_group_sub['class_fld_icon'];
			}


        }

        return $result;
    }

	public function check_user_access($data = array("")) 
	{

		$this->db = $this->load->database('people', TRUE);

		$application_id = $this->application_id();

		if ($_SESSION['people_role'] <> "0") {
		
			$this->db->select('
				*,
				role_function.fld_url AS FUNC,
				role_function.fld_name AS NAME,
				role_class.fld_url AS CLASS

			');
			$this->db->from('role_access');
			$this->db->join('role_function','role_function.fld_id = role_access.fld_function_id');
			$this->db->join('role_class','role_class.fld_id = role_function.fld_class_id');	
			$this->db->join('role_application','role_application.fld_id = role_function.fld_application_id ');	
			$this->db->where('role_access.fld_role_id', $_SESSION['people_role']);
			$this->db->where('role_application.fld_id',$application_id);
			// $data_function1 = $this->db->get()->result_array();
        } else {

			$this->db->select('
				*,
				role_function.fld_url AS FUNC,
				role_function.fld_name AS NAME
			');
			$this->db->from('user_access');
			$this->db->join('role_function','role_function.fld_id = user_access.fld_function_id');
			$this->db->join('role_class','role_class.fld_id = role_function.fld_class_id');	
			$this->db->join('role_application','role_application.fld_id = role_function.fld_application_id ');	
			$this->db->where('user_access.fld_user_id', $_SESSION['people_id']);
			$this->db->where('role_application.fld_id',$application_id);
			// $data_function2 = $this->db->get()->result_array();

        }

		$data_function = $this->db->get()->result();

		foreach ($data_function as $item) {
            $result[$item->CLASS] = array("");
        }
        foreach ($data_function as $item) {
            $result[$item->CLASS][$item->FUNC] = $item->NAME;
            #$result[$item->CLASS] = $item->NAME;
        }

        return $result;
    }

	public function error_403()
	{
		
		$this->load->view('template/header');
		$this->load->view('template/css/con-css-1');
		$this->load->view('template/navbar');
		$this->load->view('template/sidebar');
		$this->load->view('template/errors_page/error_403');
		$this->load->view('template/footer');

		$this->load->view('template/js/con-js-1');
		$this->load->view('template/js/all-js-1');
		

	}

		


    // public function classMenu($data = array("")) 
	// {
    //     if ($_SESSION['saeree_group'] <> "0") {
    //         $sql = "SELECT *,class.class AS CLASS,class.name AS NAME ";
    //         $sql .= "FROM groupdata ";
    //         $sql .= "INNER JOIN functions ON groupdata.gp_funcid = functions.id ";
    //         $sql .= "INNER JOIN class ON functions.class_id = class.id ";
    //         $sql .= "INNER JOIN application ON application.id = functions.program_id ";
    //         $sql .= "WHERE application.id = 1 AND groupdata.gp_groupid = '" . $_SESSION['saeree_group'] . "' ";
    //     } else {
    //         $sql = "SELECT *,class.class AS CLASS,class.name AS NAME ";
    //         $sql .= "FROM privilege ";
    //         $sql .= "INNER JOIN functions ON privilege.pv_funcid = functions.id ";
    //         $sql .= "INNER JOIN class ON functions.class_id = class.id ";
    //         $sql .= "INNER JOIN application ON application.id = functions.program_id ";
    //         $sql .= "WHERE application.id = 1 AND privilege.pv_userid = '" . $_SESSION['saeree_id'] . "' ";
    //     }
    //     $query = $this->db->query($sql);
    //     #$result = array("sql" => $sql);
    //     foreach ($query->result() as $item) {
    //         $title = explode('/', $item->CLASS);
    //         #$array = array($item->CLASS => $item->NAME);
    //         #array_push($result[$title[0]],$item->CLASS => $item->NAME);
    //         $result[$title[0]] = array($item->CLASS => $item->NAME);
    //     }
    //     return $result;
    // }
  
}

?>
