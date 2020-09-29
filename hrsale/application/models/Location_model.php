<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class location_model extends CI_Model
	{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
		public function get_active_locations()
		{
			$this->db->order_by('location_id', 'desc');
			return $this->db->get_where("xin_office_location", ['location_active'=>1]);
		}
	public function get_locations()
	{
		$this->db->order_by('location_id', 'desc');
	  return $this->db->get("xin_office_location");
	}

	 public function read_location_information($id) {

		$sql = 'SELECT * FROM xin_office_location WHERE location_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_office_location', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('location_id', $id);
		$this->db->delete('xin_office_location');

	}

	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('location_id', $id);
		if( $this->db->update('xin_office_location',$data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record without logo > in table
	public function update_record_no_logo($data, $id){
		$this->db->where('location_id', $id);
		if( $this->db->update('xin_office_location',$data)) {
			return true;
		} else {
			return false;
		}
	}

	// get all office locations
	public function all_office_locations() {
	  $query = $this->db->query("SELECT * from xin_office_location");
  	  return $query->result();
	}

	// luffy
	// get company > departments
	public function ajax_location_info($id) {
		$condition = "company_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_office_location');
		$this->db->where('location_active', 1);
		$this->db->where($condition);
		$this->db->limit(100);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
?>
