<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class roles_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
  	public function get_user_roles(){
      $sql = 'SELECT * FROM xin_user_roles WHERE deleted_at IS NULL';
  		$query = $this->db->query($sql);
  	  return $query;
  	}
  	public function get_user_roles_deleted(){
      $sql = 'SELECT * FROM xin_user_roles WHERE deleted_at IS NOT NULL';
  		$query = $this->db->query($sql);
  	  return $query;
  	}
	 public function read_role_information($id) {
		$sql = 'SELECT * FROM xin_user_roles WHERE role_id = ?';
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
		$this->db->insert('xin_user_roles', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
  // luffy
	// soft delete
	public function delete_record($id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('deleted_at', date('Y-m-d H:i:s'));
    $this->db->set('deleted_by', $userId);
    $this->db->where('role_id', $id);
    $this->db->update('xin_user_roles');
	}
	// luffy restore
	public function restore($id){
    $this->db->set('deleted_at', NULL);
    $this->db->set('deleted_by', 0);
    $this->db->where('role_id', $id);
    $this->db->update('xin_user_roles');
	}
	// luffy
	// destroy permanent
	public function destroy($id){
		$this->db->where('user_id', $id);
		$this->db->delete('xin_employees');
	}
	// Function to update record in table
	public function update_record($data, $id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('role_id', $id);
    if($this->db->update('xin_user_roles',$data))
			return true;
		else return false;
		// $this->db->where('role_id', $id);
		// if( $this->db->update('xin_user_roles',$data)) {
		// 	return true;
		// } else {
		// 	return false;
		// }
	}

	// get all user roles
	public function all_user_roles()
	{
	  $query = $this->db->query("SELECT * from xin_user_roles");
  	  return $query->result();
	}
}
?>
