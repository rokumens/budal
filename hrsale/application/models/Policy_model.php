<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class policy_model extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

	public function get_policies() {
	  return $this->db->get("xin_company_policy");
	}

  public function read_policy_information($id){
		$sql = 'SELECT * FROM xin_company_policy WHERE policy_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return false;
	}

	// Function to add record in table
	public function add($data){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('xin_company_policy', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('policy_id', $id);
		$this->db->delete('xin_company_policy');
	}

	// Function to update record in table
	public function update_record($data, $id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
		$this->db->where('policy_id', $id);
		if( $this->db->update('xin_company_policy',$data))
			return true;
		else return false;
	}
}
?>