<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_detail_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

  public function all_grade_detail() {
    $this->db->from("luffy_grade_detail");
    $this->db->order_by("grade_name", "asc");
    $query = $this->db->get();
    return $query;
	}

  // Function to add record in table
	public function add($data){
		$this->db->insert('luffy_grade_detail', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

  // Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('grade_id', $id);
		$this->db->delete('luffy_grade_detail');
	}

	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('grade_id', $id);
		if( $this->db->update('luffy_grade_detail',$data)) {
			return true;
		} else {
			return false;
		}
	}

}
?>
