<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Punishment_amount_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

  // get current punishment point value
  public function getCurrentPunishmentPointAmount() {
     $sql = 'SELECT amount FROM luffy_punishment_amount LIMIT 1';
     $query = $this->db->query($sql);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }

  // Function to update record in table
	public function update_record($data, $id){
		$this->db->where('id', $id);
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
		if( $this->db->update('luffy_punishment_amount',$data)) {
			return true;
		} else {
			return false;
		}
	}

}
?>
