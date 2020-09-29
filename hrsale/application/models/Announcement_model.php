<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class announcement_model extends CI_Model {
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
  	public function get_announcements(){
      return $this->db->query("SELECT * from xin_announcements WHERE deleted_at IS NULL");
  	}
  	public function get_announcements_deleted(){
      return $this->db->query("SELECT * FROM xin_announcements WHERE deleted_at IS NOT NULL");
  	}
  	public function get_new_announcements(){
  		$query = $this->db->query("SELECT * from xin_announcements");
  		return $query->result();
  	}
    // luffy start
  	public function get_new_announcements_by_department($departmentId, $allDepartmentId) {
  		$sql = 'SELECT * FROM xin_announcements WHERE department_id IN (?,?)';
  		$binds = array($departmentId, $allDepartmentId);
  		$query = $this->db->query($sql, $binds);
  		if ($query->num_rows() > 0)
  			return $query->result();
  		else return null;
  	}
    // luffy end
	 public function read_announcement_information($id){
		$sql = 'SELECT * FROM xin_announcements WHERE announcement_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return false;
	}
	// luffy add
	public function add($data){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('xin_announcements', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// luffy update
	public function update_record($data, $id){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('announcement_id', $id);
		$data = $this->security->xss_clean($data);
    if($this->db->update('xin_announcements',$data))
			return true;
		else return false;
	}
	// luffy delete
	public function delete_record($id){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('deleted_at', date('Y-m-d H:i:s'));
    $this->db->set('deleted_by', $userId);
    $this->db->set('is_active', 0);
    $this->db->where('announcement_id', $id);
    $this->db->update('xin_announcements');
	}
	// luffy restore
	public function restore($id){
    $this->db->set('deleted_at', NULL);
    $this->db->set('deleted_by', 0);
    $this->db->set('is_active', 1);
    $this->db->where('announcement_id', $id);
    $this->db->update('xin_announcements');
	}
	// luffy destroy permanent
	public function destroy($id){
		$this->db->where('announcement_id', $id);
		$this->db->delete('xin_announcements');
	}
}
?>
