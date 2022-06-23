<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model');
		$this->load->model('Activity_log_model');

		// $this->Main_model->check_session();
	}

    public function index() 
    {
		
		$this->load->view('template/css/con-css-1');
       
		if ($this->session->userdata('people_login') and $this->session->userdata('people_login') == 1) {

			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('template/sidebar');
			$this->load->view('dashboard/dashboard');
			$this->load->view('template/footer');
			$this->load->view('template/js/con-js-1');
			$this->load->view('dashboard/js/dashboard-js');

		} else {
			
			$this->load->view('template/login');
			$this->load->view('template/js/con-js-1');
			$this->load->view('template/js/login-js');
			
		}

    }

    public function login() 
    {
        $this->load->model(array('Main_model'));
        $data = $this->Main_model->login_model($_REQUEST);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

	public function logout()
	{
    	$this->session->sess_destroy();

		//-------------------------------------Activity_log-------------------------------------------------
			$data_activity_log = array();
			$data_activity_log = array(
				"fld_activity" => 'ออกจากระบบ' ,
				"fld_table_name" => '',
				"fld_table_id" => '',
				"fld_creator_id" => $_SESSION['people_id'],
				"fld_creator_date" => date('Y-m-d H:i:s')
			);
			$this->Activity_log_model->add_activity_log_1_model($data_activity_log);
		//-------------------------------------END-Activity_log--------------------------------------------
	}

}
