<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_punishment_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

	public function get_punishment() {
	  return $this->db->get("luffy_assign_punishment");
	}

  public function all_assign_punishment()
	{
    $sql = 'SELECT
              assPunishment.*,
              assignTo.first_name AS assignTo_firstName, assignTo.last_name AS assignTo_lastName, assignTo.fingerprint_location AS fingerprint_location_to,
              assignBy.first_name AS assignBy_firstName, assignBy.last_name AS assignBy_lastName, assignBy.fingerprint_location AS fingerprint_location_by,
              punishment.punishment_name, punishment.punishment_point AS punishmentPoint, punishment.amount AS punishmentAmount,
              subDept.department_name,
              locationTo.location_name AS location_name_to, locationBy.location_name AS location_name_By
            FROM luffy_assign_punishment AS assPunishment
               LEFT JOIN xin_employees AS assignTo ON assignTo.user_id = assPunishment.assigned_to
               LEFT JOIN xin_employees AS assignBy ON assignBy.user_id = assPunishment.assigned_by
               LEFT JOIN xin_office_location AS locationTo ON locationTo.location_id = assignTo.fingerprint_location
               LEFT JOIN xin_office_location AS locationBy ON locationBy.location_id = assignBy.fingerprint_location
               LEFT JOIN luffy_punishment AS punishment ON punishment.id = assPunishment.punishment_id
               LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = assPunishment.sub_department_id
            ORDER BY assPunishment.id DESC';
   $query = $this->db->query($sql);
   return $query;
	}

  public function my_own_assigned_punishment($userId)
	{
    $sql = 'SELECT
              assPunishment.*,
              assignTo.first_name AS assignTo_firstName, assignTo.last_name AS assignTo_lastName, assignTo.fingerprint_location AS fingerprint_location_to,
              assignBy.first_name AS assignBy_firstName, assignBy.last_name AS assignBy_lastName, assignBy.fingerprint_location AS fingerprint_location_by,
              punishment.punishment_name, punishment.punishment_point AS punishmentPoint, punishment.amount AS punishmentAmount,
              subDept.department_name,
              locationTo.location_name AS location_name_to, locationBy.location_name AS location_name_By
            FROM luffy_assign_punishment AS assPunishment
               LEFT JOIN xin_employees AS assignTo ON assignTo.user_id = assPunishment.assigned_to
               LEFT JOIN xin_employees AS assignBy ON assignBy.user_id = assPunishment.assigned_by
               LEFT JOIN xin_office_location AS locationTo ON locationTo.location_id = assignTo.fingerprint_location
               LEFT JOIN xin_office_location AS locationBy ON locationBy.location_id = assignBy.fingerprint_location
               LEFT JOIN luffy_punishment AS punishment ON punishment.id = assPunishment.punishment_id
               LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = assPunishment.sub_department_id
            WHERE assPunishment.assigned_to=? ORDER BY assPunishment.id DESC';
   $bind = array($userId);
   $query = $this->db->query($sql, $bind);
   return $query;
	}

  // ini buat View Own
  public function my_own_assign_punishment($id)
	{
    $this->db->from("luffy_assign_punishment");
    $this->db->where('assigned_to', $id);
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    return $query;
	}

  // Function to add record in table
	public function add($data){
		$this->db->insert('luffy_assign_punishment', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

  // Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->delete('luffy_assign_punishment');
	}

	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('id', $id);
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
		if( $this->db->update('luffy_assign_punishment',$data)) {
			return true;
		} else {
			return false;
		}
	}

  public function read_assign_punishment_information($assPunishmentId)
  {
    $sql = 'SELECT
              assPunishment.*,
              assignTo.first_name AS assignTo_firstName, assignTo.last_name AS assignTo_lastName, assignTo.fingerprint_location AS fingerprint_location_to,
              assignBy.first_name AS assignBy_firstName, assignBy.last_name AS assignBy_lastName, assignBy.fingerprint_location AS fingerprint_location_by,
              punishment.punishment_name, punishment.punishment_point AS punishmentPoint, punishment.amount AS punishmentAmount,
              subDept.department_name
            FROM luffy_assign_punishment AS assPunishment
               LEFT JOIN xin_employees AS assignTo ON assignTo.user_id = assPunishment.assigned_to
               LEFT JOIN xin_employees AS assignBy ON assignBy.user_id = assPunishment.assigned_by
               LEFT JOIN luffy_punishment AS punishment ON punishment.id = assPunishment.punishment_id
               LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = assPunishment.sub_department_id
            WHERE assPunishment.id=?';
    $bind = array($assPunishmentId);
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
 public function getSumPunishmentBy_Month_UserId($monthPeriode,$employeeId) {
    $sql = 'SELECT
             SUM(punishment.punishment_point) AS sum_punishmentPoint,
             SUM(punishment.amount) AS sum_punishmentAmount
            FROM luffy_assign_punishment AS assPunishment
              LEFT JOIN luffy_punishment AS punishment ON punishment.id = assPunishment.punishment_id
            WHERE MONTH(assPunishment.punishment_date)=? AND assPunishment.assigned_to=?';
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
