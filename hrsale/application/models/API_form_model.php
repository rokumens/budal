<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_form_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	// get all api form data
	public function get_api_form_data($formID) {
		  if(empty($formID)) {
        $sql = 'SELECT * FROM api_form_23760
                UNION SELECT * FROM api_form_36882
                UNION SELECT * FROM api_form_37873
                UNION SELECT * FROM api_form_31392
                ORDER BY date_created DESC';
			  return $query = $this->db->query($sql);
		  } else {
			  $sql = "SELECT * from api_form_$formID where form_id = ? ORDER BY date_created DESC";
			  $binds = array($formID);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  }
	}

	public function get_api_form_idname() {
    $sql = 'SELECT form_id, form_name FROM api_form_23760 GROUP BY form_name
            UNION SELECT form_id, form_name FROM api_form_36882 GROUP BY form_name
            UNION SELECT form_id, form_name FROM api_form_37873 GROUP BY form_name
            UNION SELECT form_id, form_name FROM api_form_31392 GROUP BY form_name
            ORDER BY form_name ASC';
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

}
?>
