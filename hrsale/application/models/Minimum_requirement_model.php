<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Minimum_requirement_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

  public function all_minimum_requirements() {
    $this->db->from("luffy_minimum_requirement");
    $this->db->order_by("minimum_monthly_requirement", "asc");
    $query = $this->db->get();
    return $query;
	}

  // Function to add record in table
	public function add($data){
		$this->db->insert('luffy_minimum_requirement', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

  // Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->delete('luffy_minimum_requirement');
	}

	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('id', $id);
		if( $this->db->update('luffy_minimum_requirement',$data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to read minimum requirement information
	public function read_requirement_information($id){
    $sql = 'SELECT * FROM luffy_minimum_requirement WHERE id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows()> 0) {
			return $query->result();
		} else {
			return null;
		}
	}

}
?>
