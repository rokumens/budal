<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rewards_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

	public function get_rewards() {
	  return $this->db->get("luffy_rewards");
	}

  public function all_rewards()
	{
    $sql = 'SELECT
              rewards.*, amount.amount AS rewardsAmount
            FROM luffy_rewards AS rewards
               LEFT JOIN luffy_rewards_amount AS amount ON amount.id = rewards.rewards_amount_id
            ORDER BY rewards.id DESC';
    $query = $this->db->query($sql);
    return $query;
	}

  // ini buat View Own
  public function my_own_rewards($id)
	{
    $this->db->from("luffy_rewards");
    $this->db->where('employee_id', $id);
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    return $query;
	}

  // Function to add record in table
	public function add($data){
		$this->db->insert('luffy_rewards', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

  // Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->delete('luffy_rewards');
	}

	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('id', $id);
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
		if( $this->db->update('luffy_rewards',$data)) {
			return true;
		} else {
			return false;
		}
	}

  public function read_rewards_information($id)
  {
    $this->db->from("luffy_rewards");
    $this->db->where('id', $id);
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    return $query->result();
 }

}
?>
