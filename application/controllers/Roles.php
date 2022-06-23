<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model');
		// $this->load->model('Activity_log_model');
		$this->load->model('Roles_application_model');
		$this->load->model('Roles_class_model');
		$this->load->model('Roles_function_model');
		$this->load->model('Roles_access_model');

		// $this->Main_model->check_session();
	}

	// application

		public function application() 
		{

			$check_user_access = $this->Main_model->check_user_access();

			if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/index"])) {


				$this->load->view('template/header');
				$this->load->view('template/css/con-css-1');
				$this->load->view('template/navbar');
				$this->load->view('template/sidebar');
				$this->load->view('roles/application-home');
				$this->load->view('template/footer');

				$this->load->view('template/js/con-js-1');
				$this->load->view('template/js/all-js-1');
				$this->load->view('roles/js/application-home-js');

			}else{

				$this->Main_model->error_403();
	
			}

		}

		public function get_application() 
		{
			$data = $this->Roles_application_model->get_application_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function get_application_all() 
		{
			$data = $this->Roles_application_model->get_application_all_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function get_application_byid() 
		{
			$data = $this->Roles_application_model->get_application_byid_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function get_application_byroles() 
		{
			$data = $this->Roles_application_model->get_application_byroles_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function post_application() 
		{
			$data = $this->Roles_application_model->post_application_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function put_application() 
		{
			$data = $this->Roles_application_model->put_application_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function delete_application() 
		{
			$data = $this->Roles_application_model->delete_application_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

	// END application

	// class

		public function class() 
		{

			$check_user_access = $this->Main_model->check_user_access();

			if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/index"])) {


				$this->load->view('template/header');
				$this->load->view('template/css/con-css-1');
				$this->load->view('template/navbar');
				$this->load->view('template/sidebar');
				$this->load->view('roles/class-home');
				$this->load->view('template/footer');

				$this->load->view('template/js/con-js-1');
				$this->load->view('template/js/all-js-1');
				$this->load->view('roles/js/class-home-js');

			}else{

				$this->Main_model->error_403();

			}

		}

		public function get_class() 
		{
			$data = $this->Roles_class_model->get_class_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function get_class_byapplication() 
		{
			$data = $this->Roles_class_model->get_class_byapplication_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function get_class_byapplicationroles() 
		{
			$data = $this->Roles_class_model->get_class_byapplicationroles_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function get_class_byid() 
		{
			$data = $this->Roles_class_model->get_class_byid_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function post_class() 
		{
			$data = $this->Roles_class_model->post_class_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function put_class() 
		{
			$data = $this->Roles_class_model->put_class_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function delete_class() 
		{
			$data = $this->Roles_class_model->delete_class_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

	// END class

	// function

		public function function() 
		{
			
			$check_user_access = $this->Main_model->check_user_access();

			if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/index"])) {
	
		
				$this->load->view('template/header');
				$this->load->view('template/css/con-css-1');
				$this->load->view('template/navbar');
				$this->load->view('template/sidebar');
				$this->load->view('roles/function-home');
				$this->load->view('template/footer');

				$this->load->view('template/js/con-js-1');
				$this->load->view('template/js/all-js-1');
				$this->load->view('roles/js/function-home-js');

			}else{

				$this->Main_model->error_403();
	
			}
			
		}

		public function get_function() 
		{
			$data = $this->Roles_function_model->get_function_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	
		public function get_function_byid() 
		{
			$data = $this->Roles_function_model->get_function_byid_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function get_function_byclassapplicationroles() 
		{
			$data = $this->Roles_function_model->get_function_byclassapplicationroles_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function post_function() 
		{
			$data = $this->Roles_function_model->post_function_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function put_function() 
		{
			$data = $this->Roles_function_model->put_function_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function delete_function() 
		{
			$data = $this->Roles_function_model->delete_function_model();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

	// END function

	// Access

		public function access() 
		{

			$check_user_access = $this->Main_model->check_user_access();

			if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/index"])) {


				$this->load->view('template/header');
				$this->load->view('template/css/con-css-1');
				$this->load->view('template/navbar');
				$this->load->view('template/sidebar');
				$this->load->view('roles/access-home');
				$this->load->view('template/footer');

				$this->load->view('template/js/con-js-1');
				$this->load->view('template/js/all-js-1');
				$this->load->view('roles/js/access-home-js');

				
			}else{

				$this->Main_model->error_403();

			}

		}

		public function get_access_all() 
		{
			$data = $this->Roles_access_model->get_access_all_model();
			$this->output->set_content_type('access/json')->set_output(json_encode($data));
		}

		public function put_access() 
		{
			$data = $this->Roles_access_model->put_access_model();
			$this->output->set_content_type('access/json')->set_output(json_encode($data));
		}

		public function post_roles_copy() 
		{
			$data = $this->Roles_access_model->post_roles_copy_model();
			$this->output->set_content_type('access/json')->set_output(json_encode($data));
		}

		
		public function post_roles_manage() 
		{
			$data = $this->Roles_access_model->post_roles_manage_model();
			$this->output->set_content_type('access/json')->set_output(json_encode($data));
		}


		public function delete_roles() 
		{
			$data = $this->Roles_access_model->delete_roles_model();
			$this->output->set_content_type('access/json')->set_output(json_encode($data));
		}

		


	// END Access
}
