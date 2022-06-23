<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model');
		// $this->load->model('Activity_log_model');
		$this->load->model('Users_model');
		// $this->Main_model->check_session();
	}

	public function index() 
	{

		$check_user_access = $this->Main_model->check_user_access();

		if(isset($check_user_access[substr($_SERVER['PATH_INFO'],1)][substr($_SERVER['PATH_INFO'],1)."/index"])) {

			$this->load->view('template/header');
			$this->load->view('template/css/con-css-1');
			$this->load->view('template/navbar');
			$this->load->view('template/sidebar');
			$this->load->view('users/users-home');
			$this->load->view('template/footer');

			$this->load->view('template/js/con-js-1');
			$this->load->view('template/js/all-js-1');
			$this->load->view('users/js/users-home-js');

		}else{

			$this->Main_model->error_403();

		}

	}

	public function get_users_confirm_status() 
	{
		$data = $this->Users_model->get_users_confirm_status_model();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_users() 
	{
		$data = $this->Users_model->get_users_model();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_users_byid() 
	{
		$data = $this->Users_model->get_users_byid_model();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function post_users() 
	{
		$data = $this->Users_model->post_users_model();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function put_users() 
	{
		$data = $this->Users_model->put_users_model();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function put_users_confirm() 
	{
		$data = $this->Users_model->put_users_confirm_model();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function delete_users() 
	{
		$data = $this->Users_model->delete_users_model();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

}

