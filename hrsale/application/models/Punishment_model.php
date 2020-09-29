<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Punishment_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

	public function get_punishment() {
	  return $this->db->get("luffy_punishment");
	}

  public function all_punishment()
	{
    $sql = 'SELECT
              punishment.*, amount.amount AS punishmentAmount
            FROM luffy_punishment AS punishment
               LEFT JOIN luffy_punishment_amount AS amount ON amount.id = punishment.punishment_amount_id
            ORDER BY punishment.id DESC';
    $query = $this->db->query($sql);
    return $query;
	}

  // ini buat View Own
  public function my_own_punishment($id)
	{
    $this->db->from("luffy_punishment");
    $this->db->where('employee_id', $id);
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    return $query;
	}

  // Function to add record in table
	public function add($data){
		$this->db->insert('luffy_punishment', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

  // Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->delete('luffy_punishment');
	}

	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('id', $id);
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
		if( $this->db->update('luffy_punishment',$data)) {
			return true;
		} else {
			return false;
		}
	}

  public function read_punishment_information($id)
  {
    $this->db->from("luffy_punishment");
    $this->db->where('id', $id);
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    return $query->result();
 }

}
?>
