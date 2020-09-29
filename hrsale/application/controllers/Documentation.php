<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Documentation extends MY_Controller {
  public function __construct() {
    parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->model("Xin_model");
	}
  public function index(){
    $session = $this->session->userdata('username');
		if(!$session)
      redirect('admin/');
    $role_resources_ids = $this->Xin_model->user_role_resource();
    if(!in_array('1028',$role_resources_ids))
      redirect('admin/');
    $this->load->view('documentation/index');
  }

}