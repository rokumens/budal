<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class company_model extends CI_Model
{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
	public function get_companies() {
		$query = $this->db->query("SELECT * from xin_companies WHERE deleted_at IS NULL");
		return $query;
	}
	public function get_companies_deleted() {
		$query = $this->db->query("SELECT * from xin_companies WHERE deleted_at IS NOT NULL");
		return $query;
	}
	public function get_company_documents() {
    return $this->db->query('SELECT * FROM xin_company_documents WHERE deleted_at IS NULL');
	}
	public function get_company_documents_deleted() {
    return $this->db->query('SELECT * FROM xin_company_documents WHERE deleted_at IS NOT NULL');
	}
	// company types
	public function get_company_types() {
		$query = $this->db->get("xin_company_type");
		return $query->result();
	}
	public function get_all_companies() {
	  $query = $this->db->get("xin_companies");
	  return $query->result();
	}
	public function read_company_information($id) {
		$sql = 'SELECT * FROM xin_companies WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return false;
	}
	// get company > departments
	public function ajax_company_departments_info($id) {
		$condition = "company_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_departments');
		$this->db->where($condition);
		$this->db->limit(100);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query->result();
		else return false;
	}
  // luffy
	// add
	public function add($data){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('xin_companies', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// luffy
	// update
	public function update_record($data, $id){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('company_id', $id);
		$data = $this->security->xss_clean($data);
    if($this->db->update('xin_companies',$data))
			return true;
		else return false;
	}
  // Function to update record without logo > in table
	public function update_record_no_logo($data, $id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('company_id', $id);
		$data = $this->security->xss_clean($data);
    if($this->db->update('xin_companies',$data))
			return true;
		else return false;
	}
	// luffy
	// delete
	public function delete_record($id){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('deleted_at', date('Y-m-d H:i:s'));
    $this->db->set('deleted_by', $userId);
    $this->db->set('is_active', 0);
    $this->db->where('company_id', $id);
    $this->db->update('xin_companies');
	}
	// luffy restore
	public function restore($id){
    $this->db->set('deleted_at', NULL);
    $this->db->set('deleted_by', 0);
    $this->db->set('is_active', 1);
    $this->db->where('company_id', $id);
    $this->db->update('xin_companies');
	}
	// luffy destroy permanent
	public function destroy($id){
		$this->db->where('company_id', $id);
		$this->db->delete('xin_companies');
	}
  public function read_company_document_info($id) {
		$sql = 'SELECT * FROM xin_company_documents WHERE document_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return false;
	}
	// Function to add record in table
	public function add_document($data){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('xin_company_documents', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
  // Function to update record without logo > in table
	public function update_company_document_record($data, $id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('document_id', $id);
		$data = $this->security->xss_clean($data);
    if($this->db->update('xin_company_documents',$data))
			return true;
		else return false;
	}
	// Function to Delete selected record from table
	public function delete_doc_record($id){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('deleted_at', date('Y-m-d H:i:s'));
    $this->db->set('deleted_by', $userId);
    $this->db->where('document_id', $id);
    $this->db->update('xin_company_documents');
	}
	// luffy restore document
	public function restore_doc($id){
    $this->db->set('deleted_at', NULL);
    $this->db->set('deleted_by', 0);
    $this->db->where('document_id', $id);
    $this->db->update('xin_company_documents');
	}
}
?>
