<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rewards_point_value_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

  // get current rewards point value
  public function getCurrentRewardsPointAmount() {
     $sql = 'SELECT amount FROM luffy_rewards_point_value LIMIT 1';
     $query = $this->db->query($sql);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }

}
?>
