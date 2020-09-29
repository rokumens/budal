<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class termination_model extends CI_Model {

  public function __construct() {
    parent::__construct();
    $this->load->database();
  }

	public function get_terminations() {
    return $this->db->query("SELECT * FROM xin_employee_terminations ORDER BY termination_id DESC");
	}

	public function read_termination_information($id) {
		$sql = 'SELECT * FROM xin_employee_terminations WHERE termination_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else  return null;
	}

	public function read_termination_type_information($id) {
		$sql = 'SELECT * FROM xin_termination_type WHERE termination_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}

	public function all_termination_types() {
	  $query = $this->db->query("SELECT * from xin_termination_type");
  	return $query->result();
	}

	// Function to add record in table
  // luffy modified 8 Dec 2019 - 05:12 pm
	public function add($data){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('xin_employee_terminations', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('termination_id', $id);
		$this->db->delete('xin_employee_terminations');
	}

	// Function to update record in table
  // luffy modified 8 Dec 2019 - 05:13 pm
	public function update_record($data, $id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
		$this->db->where('termination_id', $id);
		if( $this->db->update('xin_employee_terminations',$data))
			return true;
		else return false;
	}
}
?>
