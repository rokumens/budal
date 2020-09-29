<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		 $this->load->model('Employees_model');
		 $this->load->model('Xin_model');
		 $this->load->model('Login_model');
	}

	public function index()
	{
		 $data['title'] = $this->Xin_model->site_title().' | Log in';
		 $this->load->view('admin/auth/login', $data);
	}
}
