<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appraisal_status_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

	public function get_appraisal_status() {
	  return $this->db->get("luffy_appraisal_status");
	}

}
?>
