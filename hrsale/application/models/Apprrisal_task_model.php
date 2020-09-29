<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apprrisal_task_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

	public function get_competencies() {
	  return $this->db->get("luffy_appraisal_task");
	}

}
?>
