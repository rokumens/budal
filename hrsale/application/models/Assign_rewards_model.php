<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_rewards_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

	public function get_rewards() {
	  return $this->db->get("luffy_assign_rewards");
	}

  public function all_assign_rewards(){
    $sql = 'SELECT
              assRewards.*,
              assignTo.first_name AS assignTo_firstName, assignTo.last_name AS assignTo_lastName, assignTo.fingerprint_location AS fingerprint_location_to,
              assignBy.first_name AS assignBy_firstName, assignBy.last_name AS assignBy_lastName, assignBy.fingerprint_location AS fingerprint_location_by,
              rewards.rewards_name, rewards.rewards_point AS rewardsPoint, rewards.amount AS rewardsAmount,
              subDept.department_name,
              locationTo.location_name AS location_name_to, locationBy.location_name AS location_name_By
            FROM luffy_assign_rewards AS assRewards
               LEFT JOIN xin_employees AS assignTo ON assignTo.user_id = assRewards.assigned_to
               LEFT JOIN xin_employees AS assignBy ON assignBy.user_id = assRewards.assigned_by
               LEFT JOIN xin_office_location AS locationTo ON locationTo.location_id = assignTo.fingerprint_location
               LEFT JOIN xin_office_location AS locationBy ON locationBy.location_id = assignBy.fingerprint_location
               LEFT JOIN luffy_rewards AS rewards ON rewards.id = assRewards.rewards_id
               LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = assRewards.sub_department_id
            ORDER BY assRewards.id DESC';
   $query = $this->db->query($sql);
   return $query;
	}
  // public function all_assign_rewards(){
  //   $sql = 'SELECT
  //             assRewards.*,
  //             assignTo.first_name AS assignTo_firstName, assignTo.last_name AS assignTo_lastName, assignTo.fingerprint_location AS fingerprint_location_to,
  //             assignBy.first_name AS assignBy_firstName, assignBy.last_name AS assignBy_lastName, assignBy.fingerprint_location AS fingerprint_location_by,
  //             rewards.rewards_name, rewards.rewards_point AS rewardsPoint, rewards.amount AS rewardsAmount,
  //             subDept.department_name
  //           FROM luffy_assign_rewards AS assRewards
  //              LEFT JOIN xin_employees AS assignTo ON assignTo.user_id = assRewards.assigned_to
  //              LEFT JOIN xin_employees AS assignBy ON assignBy.user_id = assRewards.assigned_by
  //              LEFT JOIN luffy_rewards AS rewards ON rewards.id = assRewards.rewards_id
  //              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = assRewards.sub_department_id
  //           ORDER BY assRewards.id DESC';
  //  $query = $this->db->query($sql);
  //  return $query;
	// }

  public function my_own_assigned_rewards($userId){
    $sql = 'SELECT
              assRewards.*,
              assignTo.first_name AS assignTo_firstName, assignTo.last_name AS assignTo_lastName, assignTo.fingerprint_location AS fingerprint_location_to,
              assignBy.first_name AS assignBy_firstName, assignBy.last_name AS assignBy_lastName, assignBy.fingerprint_location AS fingerprint_location_by,
              rewards.rewards_name, rewards.rewards_point AS rewardsPoint, rewards.amount AS rewardsAmount,
              subDept.department_name,
              locationTo.location_name AS location_name_to, locationBy.location_name AS location_name_By
            FROM luffy_assign_rewards AS assRewards
               LEFT JOIN xin_employees AS assignTo ON assignTo.user_id = assRewards.assigned_to
               LEFT JOIN xin_employees AS assignBy ON assignBy.user_id = assRewards.assigned_by
               LEFT JOIN xin_office_location AS locationTo ON locationTo.location_id = assignTo.fingerprint_location
               LEFT JOIN xin_office_location AS locationBy ON locationBy.location_id = assignBy.fingerprint_location
               LEFT JOIN luffy_rewards AS rewards ON rewards.id = assRewards.rewards_id
               LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = assRewards.sub_department_id
            WHERE assRewards.assigned_to=? ORDER BY assRewards.id DESC';
   $binds = array($userId);
   $query = $this->db->query($sql,$binds);
   return $query;
 }
//   public function my_own_assigned_rewards($userId){
//     $sql = 'SELECT
//               assRewards.*,
//               assignTo.first_name AS assignTo_firstName, assignTo.last_name AS assignTo_lastName, assignTo.fingerprint_location AS fingerprint_location_to,
//               assignBy.first_name AS assignBy_firstName, assignBy.last_name AS assignBy_lastName, assignBy.fingerprint_location AS fingerprint_location_by,
//               rewards.rewards_name, rewards.rewards_point AS rewardsPoint, rewards.amount AS rewardsAmount,
//               subDept.department_name
//             FROM luffy_assign_rewards AS assRewards
//                LEFT JOIN xin_employees AS assignTo ON assignTo.user_id = assRewards.assigned_to
//                LEFT JOIN xin_employees AS assignBy ON assignBy.user_id = assRewards.assigned_by
//                LEFT JOIN luffy_rewards AS rewards ON rewards.id = assRewards.rewards_id
//                LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = assRewards.sub_department_id
//             WHERE assRewards.assigned_to=? ORDER BY assRewards.id DESC';
//    $binds = array($userId);
//    $query = $this->db->query($sql,$binds);
//    return $query;
//  }

  // ini buat View Own
  public function my_own_assign_rewards($id)
	{
    $this->db->from("luffy_assign_rewards");
    $this->db->where('assigned_to', $id);
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    return $query;
	}

  // Function to add record in table
	public function add($data){
		$this->db->insert('luffy_assign_rewards', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

  // Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->delete('luffy_assign_rewards');
	}

	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('id', $id);
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
		if( $this->db->update('luffy_assign_rewards',$data)) {
			return true;
		} else {
			return false;
		}
	}

  public function read_assign_rewards_information($assRewardsId)
  {
    $sql = 'SELECT
              assRewards.*,
              assignTo.first_name AS assignTo_firstName, assignTo.last_name AS assignTo_lastName, assignTo.fingerprint_location AS fingerprint_location_to,
              assignBy.first_name AS assignBy_firstName, assignBy.last_name AS assignBy_lastName, assignBy.fingerprint_location AS fingerprint_location_by,
              rewards.rewards_name, rewards.rewards_point AS rewardsPoint, rewards.amount AS rewardsAmount,
              subDept.department_name
            FROM luffy_assign_rewards AS assRewards
               LEFT JOIN xin_employees AS assignTo ON assignTo.user_id = assRewards.assigned_to
               LEFT JOIN xin_employees AS assignBy ON assignBy.user_id = assRewards.assigned_by
               LEFT JOIN luffy_rewards AS rewards ON rewards.id = assRewards.rewards_id
               LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = assRewards.sub_department_id
            WHERE assRewards.id=?';
    $bind = array($assRewardsId);
    $query = $this->db->query($sql, $bind);
    return $query->result();
 }

 public function all_employees()
 {
   $this->db->from("xin_employees");
   $this->db->order_by("user_id", "desc");
   $query = $this->db->get();
   return $query;
 }

 // get total SUM by point and amount
 public function getSumRewardsBy_Month_UserId($monthPeriode, $employeeId) {
    $sql = 'SELECT
             SUM(rewards.rewards_point) AS sum_rewardsPoint,
             SUM(rewards.amount) AS sum_rewardsAmount
            FROM luffy_assign_rewards AS assRewards
              LEFT JOIN luffy_rewards AS rewards ON rewards.id = assRewards.rewards_id
            WHERE MONTH(assRewards.rewards_date)=? AND assRewards.assigned_to=?';
    $binds=array($monthPeriode,$employeeId);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return null;
    }
 }

}
?>
