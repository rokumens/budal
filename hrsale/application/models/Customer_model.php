<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

  public function get_contacts() {
    // $this->db->from("luffy_customer");
    // $this->db->order_by("id", "desc");
    // $query = $this->db->get();
    // use query above to keep displaying repeated duplicate mobile numbers.
    // ...or use query below to keep showing the duplicate mobile number only once (not repeated).
    $sql = 'SELECT mobile_number, email FROM luffy_customer GROUP BY mobile_number ORDER BY id DESC';
    $query = $this->db->query($sql);
    return $query;
	}

  public function get_duplicate_contacts() {
    $this->db->from("luffy_customer_duplicate");
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    return $query;
	}

  // Function to add record in table
	public function add($data){
		$this->db->insert('luffy_customer', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

  // Function to add record in table
	public function addDuplicate($data){
		$this->db->insert('luffy_customer_duplicate', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

  // Check duplicated mobile number from contacts
	public function duplicate(){
		$sql = 'SELECT
              mobile_number,
              COUNT(mobile_number) AS count_mobile_number
            FROM
              luffy_customer
            GROUP BY
              mobile_number
            HAVING
              COUNT(mobile_number) > 1;';
    $query = $this->db->query($sql);
    return $query;
	}

  // Function to empty customer data & duplicates tables.
	public function empty_customer_data(){
    // $this->db->empty_table('luffy_customer');
    // $this->db->empty_table('luffy_customer_duplicate');
    // or mo pake ini boleh:
    $this->db->truncate('luffy_customer');
    $this->db->truncate('luffy_customer_duplicate');
	}

}
?>
